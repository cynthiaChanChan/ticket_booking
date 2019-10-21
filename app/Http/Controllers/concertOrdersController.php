<?php

namespace App\Http\Controllers;

use App\Order;
use App\Concert;
use App\Reservation;
use Illuminate\Http\Request;
use App\Billing\PaymentGateway;
use App\Mail\OrderConfirmationEmail;
use Illuminate\Support\Facades\Mail;
use App\Billing\PaymentFailedException;
use App\Exceptions\NotEnoughTicketsException;

class concertOrdersController extends Controller
{
	private $paymentGateway;
	public function __construct(PaymentGateway $paymentGateway) 
	{
		$this->paymentGateway = $paymentGateway;
	}
	
    public function store($concert_id) 
    {
        $concert = Concert::published()->findOrFail($concert_id);
        
        $this->validate(request(), [
            'email' => ['required', 'email'],
            'ticket_quantity' => ['required', 'integer', 'min:1'],
            'payment_token' => ['required']
        ]);

        try {
            $reservation = $concert->reserveTickets(request('ticket_quantity'), request('email'));
            $order = $reservation->complete($this->paymentGateway, request('payment_token'), $concert->user->stripe_account_id);
            Mail::to($order->email)->send(new OrderConfirmationEmail($order));
            return response($order, 201);
        } catch (PaymentFailedException $e) {
            $reservation->cancel();
            return response([], 422);
        } catch (NotEnoughTicketsException $e) {
            return response([], 422);
        }
     	
    	
    }
}
