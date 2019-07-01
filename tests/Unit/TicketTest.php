<?php

namespace Tests\Unit;

use App\Concert;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TicketTest extends TestCase 
{
	use DatabaseMigrations;

    /** @test */
    function a_ticket_can_be_released()
    {
    	$concert = factory(Concert::class)->create();
    	$concert->addTickets(1);

    	$order = $concert->orderTickets('cindy@example.com', 1);
    	$ticket = $order->tickets()->first(); 
    	$this->assertEquals($ticket->order_id, $order->id);

    	$ticket->release();
    	$this->assertNull($ticket->fresh()->order_id);
    }
}