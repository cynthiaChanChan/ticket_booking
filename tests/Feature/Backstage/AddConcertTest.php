<?php

namespace Tests\Feature;

use App\User;
use App\Concert;
use Carbon\Carbon;
use Tests\TestCase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
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
        
        tap(Concert::first(), function ($concert) use ($response) {

            $this->assertEquals(75, $concert->ticket_quantity);
    
            $response->assertStatus(302);
        });

    }

    /** @test */
    function poster_image_is_uploaded_if_included() {
        Storage::fake('s3');
        $user = factory(User::class)->create();
        $file = UploadedFile::fake()->image('concert-poster.png');

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
            'ticket_quantity' => '75',
            'poster_image' => $file
        ]);
        
        $concert = Concert::first();

        Storage::disk('s3')->assertExists($concert->poster_image_path);
    }
    
}