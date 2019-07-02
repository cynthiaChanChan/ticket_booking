<?php

namespace App\Http\Controllers;

use App\Billing\PaymentFailedException;
use App\Billing\PaymentGateway;
use App\Concert;
use App\Exceptions\NotEnoughTicketsException;
use App\Order;
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
            $tickets = $concert->findTickets(request('ticket_quantity'));

            // Charge the customer for the tickets
            $this->paymentGateway->charge($tickets->sum('price'), request('payment_token'));

            // Create an order for those tickets
            $order = Order::forTickets(request('email'), $tickets, $tickets->sum('price'));

            return response($order, 201);
        } catch (PaymentFailedException $e) {
            return response([], 422);
        } catch (NotEnoughTicketsException $e) {
            return response([], 422);
        }
     	
    	
    }
}
