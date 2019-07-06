<?php

namespace Tests\Unit;

use Mockery;
use App\Concert;
use App\Reservation;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ReservationTest extends TestCase
{
	use DatabaseMigrations;

	/** @test */
    function calculating_the_total_cost()
    {
    	$tickets = collect([
    		(object) ['price' => 1200],
    		(object) ['price' => 1200],
    		(object) ['price' => 1200]
    	]);

    	$reservation = new Reservation($tickets, 'john@example.com');

    	$this->assertEquals(3600, $reservation->totalCost());
    }

    /** @test */
    function reserved_tickets_are_released_when_a_reservation_is_cancelled ()
    {
        $tickets = collect([
            Mockery::spy(Ticket::class),
            Mockery::spy(Ticket::class),
            Mockery::spy(Ticket::class)
        ]);
        $reservation = new Reservation($tickets, 'john@example.com');

        $reservation->cancel();

        foreach($tickets as $ticket) {
            $ticket->shouldHaveReceived('release');
        }
    }
}