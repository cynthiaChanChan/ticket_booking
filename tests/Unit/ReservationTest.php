<?php

namespace Tests\Unit;

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

    	$reservation = new Reservation($tickets);

    	$this->assertEquals(3600, $reservation->totalCost());
    }
}