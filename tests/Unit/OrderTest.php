<?php

namespace Tests\Unit;

use App\Concert;
use App\Order;
use App\Ticket;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class OrderTest extends TestCase
{
	use DatabaseMigrations;


    /** @test */
    function retrieving_an_order_by_confirmation_number()
    {
        $order = factory(Order::class)->create([
            'confirmation_number' => 'ORDERCONFIRMATION1234'
        ]);

        $foundOrder = Order::findByConfirmationNumber('ORDERCONFIRMATION1234');
  
        $this->assertEquals($order->id, $foundOrder->id);
    }

    /** @test */
    function retrieving_a_nonexistent_order_by_confirmation_number_throws_anexception()
    {
        try {
            Order::findByConfirmationNumber('NONEXISTENTCONFIRMATIONNUMBER');
        } catch (ModelNotFoundException $e) {
            return;
        }
        
        $this->fail('No matching order was found for the specified confirmation number, but an exception was not throw');
    }
}