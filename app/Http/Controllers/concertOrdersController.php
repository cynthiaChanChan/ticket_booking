<?php

namespace App\Http\Controllers;

use App\Billing\PaymentFailedException;
use App\Billing\PaymentGateway;
use App\Concert;
use App\Exceptions\NotEnoughTicketsException;
use App\Order;
use App\Reservation;
use Illuminate\Http\Request;

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
            // Find some tickets
            $reservation = $concert->reserveTickets(request('ticket_quantity'), request('email'));

            // Charge the customer for the tickets
            $this->paymentGateway->charge($reservation->totalCost(), request('payment_token'));

            // Create an order for those tickets
            $order = Order::forTickets(request('email'), $reservation->tickets(), $reservation->totalCost());

            return response($order, 201);
        } catch (PaymentFailedException $e) {
            $reservation->cancel();
            return response([], 422);
        } catch (NotEnoughTicketsException $e) {
            return response([], 422);
        }
     	
    	
    }
}
