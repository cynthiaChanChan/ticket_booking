<?php

namespace Tests\Feature;

use App\Concert;
use Carbon\Carbon;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ViewConcertListingTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    function user_can_view_a_published_concert_listing()
    {
        // Arrage
        // Create a concert
        $concert = factory(Concert::class)->states('published')->create([
            'title' => 'The essential classic',
            'subtitle' => 'with Sharon Cook',
            'date' => Carbon::parse('October 13, 2018 8:00pm'),
            'ticket_price' => 2750,
            'venue' => 'The Big Concert',
            'venue_address' => '10 Big Road',
            'city' => 'New York',
            'state' => 'NY',
            'zip' => '15780',
            'additional_information' => 'For more info, call (1)555-555'
        ]);

        // Ack
        // View the concert listing
        $response = $this->get('/concerts/' . $concert->id);


        // Assert
        // See the concert details
        $response->assertSee('The essential classic');
        $response->assertSee('with Sharon Cook');
        $response->assertSee('October 13, 2018');
        $response->assertSee('8:00pm');
        $response->assertSee('27.50');
        $response->assertSee('The Big Concert');
        $response->assertSee('10 Big Road');
        $response->assertSee('New York, NY 15780');
        $response->assertSee('For more info, call (1)555-555');
    }

    /** @test */
    function user_cannot_view_unpublished_concert_listings()
    {
        $concert = factory(Concert::class)->states('unpublished')->create();

        $response = $this->get('/concerts/' . $concert->id);

        $response->assertStatus(404);
    }
}
