<?php

namespace Tests\Unit;

use App\Ticket;
use App\Concert;
use App\Order;
use Carbon\Carbon;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use App\Exceptions\NotEnoughTicketsException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ConcertTest extends TestCase
{
    use DatabaseMigrations;
    /** @test */
    function can_get_formatted_date()
    {
        $concert = factory(Concert::class)->make([
            'date' => Carbon::parse('2018-10-13 8:00pm')
        ]);

        $this->assertEquals('October 13, 2018', $concert->formatted_date);
    }

    /** @test */
    function can_get_formatted_start_time()
    {
        $concert = factory(Concert::class)->make([
            'date' => Carbon::parse('2018-10-13 17:00:00')
        ]);

        $this->assertEquals('5:00pm', $concert->formatted_start_time);
    }  

    /** @test */
    function can_get_ticket_price_in_dollars()
    {
        $concert = factory(Concert::class)->make([
            'ticket_price' => 6750
        ]);

        $this->assertEquals('67.50', $concert->ticket_price_in_dollars);
    }    

    /** @test */
    function concerts_with_a_published_at_date_are_published() 
    {
        $publishedConcertA = factory(Concert::class)->create(['published_at' => Carbon::parse('-1 week')]);
        $publishedConcertB = factory(Concert::class)->create(['published_at' => Carbon::parse('-1 week')]);
        $unpublishedConcert = factory(Concert::class)->create(['published_at' => null]);

        $publishedConcerts = Concert::published()->get();
        $this->assertTrue($publishedConcerts->contains($publishedConcertA));
        $this->assertTrue($publishedConcerts->contains($publishedConcertB));
        $this->assertFalse($publishedConcerts->contains($unpublishedConcert));
    }  

    /** @test */
    function can_add_tickets()
    {
        $concert = factory(Concert::class)->create(['ticket_quantity' => 50]);

        $this->assertEquals(50, $concert->ticketsRemaining());
    }


    /** @test */
    function can_reserve_available_tickets()
    {
        $concert = factory(Concert::class)->create(['ticket_quantity' => 3]);
        $this->assertEquals(3, $concert->ticketsRemaining());  

        $reservation = $concert->reserveTickets(2, 'john@example.com');

        $this->assertCount(2, $reservation->tickets());
        $this->assertEquals('john@example.com', $reservation->email());
        $this->assertEquals(1, $concert->ticketsRemaining());  
    }

    /** @test */
    function tickets_sold_only_includes_tickets_associated_with_an_order()
    {
        $concert = factory(Concert::class)->create();
        $concert->tickets()->saveMany(factory(Ticket::class, 3)->create(['order_id' => 1]));
        $concert->tickets()->saveMany(factory(Ticket::class, 2)->create(['order_id' => null]));
        $this->assertEquals(3, $concert->ticketsSold());
    }

    /** @test */
    function calculating_the_revenue_in_dollars() {
        $concert = factory(Concert::class)->create();
        $orderA = factory(Order::class)->create(['amount' => 3850]);
        $orderB = factory(Order::class)->create(['amount' => 9625]);
        $concert->tickets()->saveMany(factory(Ticket::class, 2)->create(['order_id' => $orderA->id]));
        $concert->tickets()->saveMany(factory(Ticket::class, 5)->create(['order_id' => $orderB->id]));

        $this->assertEquals(134.75, $concert->revenueInDollars());

    }
}
