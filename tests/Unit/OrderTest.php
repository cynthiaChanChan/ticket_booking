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
    function converting_to_an_array()
    {
        $concert = factory(Concert::class)->create(['ticket_price' => 1200]);
        $concert->addTickets(5);
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