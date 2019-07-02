<?php

namespace Tests\Unit;

use App\Concert;
use App\Order;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class OrderTest extends TestCase
{
	use DatabaseMigrations;

    /** @test */
    function creating_an_order_from_tickets_email_and_amount()
    {
        $concert = factory(Concert::class)->create()->addTickets(5);
        $this->assertEquals(5, $concert->ticketsRemaining());
        $order = Order::forTickets('cindy@example.com', $concert->findTickets(3), 3600);

        $this->assertEquals('cindy@example.com', $order->email);
        $this->assertEquals(3, $order->tickets()->count());
        $this->assertEquals(3600, $order->amount);
        $this->assertEquals(2, $concert->ticketsRemaining());
    }

    /** @test */
    function converting_to_an_array()
    {
        $concert = factory(Concert::class)->create(['ticket_price' => 1200])->addTickets(5);
        $order = $concert->orderTickets('cindy@example.com', 5);

        $result = $order->toArray();
        
        $this->assertEquals([
            'email' => 'cindy@example.com',
            'ticket_quantity' => 5,
            'amount' => 6000
        ], $result);
    }

    /** @test */
    function tickets_are_released_when_an_order_is_cancelled()
    {
    	$concert = factory(Concert::class)->create()->addTickets(10);

    	$order = $concert->orderTickets('cindy@example.com', 3);

    	$this->assertEquals(7, $concert->ticketsRemaining());

    	$order->cancel();

    	$this->assertEquals(10, $concert->ticketsRemaining());
    	$this->assertNull(Order::find($order->id));
    }
}