<?php

namespace Tests\Feature;

use App\User;
use Carbon\Carbon;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class AddConcertTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    function adding_a_valid_concert() {

        $user = factory(User::class)->create();

        $response = $this->actingAs($user)->post('/backstage/concerts',[
            'title' => 'Big Concert',
            'subtitle' => '',
            'additional_information' => "You must be 19 years of age to attend this concert.",
            'date' => '2019-08-18',
            'time' => '8:00pm',
            'venue' => 'The Mosh Pit',
            'venue_address' => '123 Fake St.',
            'city' => 'Laraville',
            'state' => 'ON',
            'zip' => '12345',
            'ticket_price' => '6',
            'ticket_quantity' => '75'
        ]);
        
        var_dump($response);
        $response->assertStatus(302);
        
    }
    
}