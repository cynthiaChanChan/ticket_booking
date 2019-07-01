<?php

namespace App\Http\Controllers;

use App\Billing\PaymentFailedException;
use App\Billing\PaymentGateway;
use App\Concert;
use App\Exceptions\NotEnoughTicketsException;
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
            $ticketQuantity = request('ticket_quantity');
            $amount = $ticketQuantity * $concert->ticket_price;

            // Find some tickets
            $tickets = $concert->findTickets($ticketQuantity);

            // Charge the customer for the tickets
            $this->paymentGateway->charge($amount, request('payment_token'));
            
            // Create an order for those tickets
            $order = $concert->createOrder(request('email'), $tickets);

            return response($order, 201);
        } catch (PaymentFailedException $e) {
            //$order->cancel();
            return response([], 422);
        } catch (NotEnoughTicketsException $e) {
            return response([], 422);
        }
     	
    	
    }
}
