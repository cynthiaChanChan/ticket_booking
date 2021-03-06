<?php

namespace Tests\Feature;

use App\User;
use App\Concert;
use Carbon\Carbon;
use Tests\TestCase;
use App\Events\ConcertAdded;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Event;
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
        Storage::fake('public');
        $user = factory(User::class)->create();
        $file = UploadedFile::fake()->image('concert-poster.png', 850, 1100);

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

        Storage::disk('public')->assertExists($concert->poster_image_path);
    }

    /** @test */
    public function an_event_is_fired_when_a_concert_is_created() 
    {
        Event::fake([ConcertAdded::class]);

        $user = factory(User::class)->create();

        $response = $this->actingAs($user)->post('backstage/concerts', [
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

        Event::assertDispatched(ConcertAdded::class, function ($event) {
            $concert = Concert::firstOrFail();
            return $event->concert->is($concert);
        });
    }
}