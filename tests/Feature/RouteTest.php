<?php

namespace Tests\Feature;

use App\User;
use App\Concert;
use Carbon\Carbon;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class RouteTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    function login() {
        $user = factory(User::class)->create([
            'email' => 'test@my.com',
            'password' => bcrypt('secret')
        ]);

        $response = $this->post('login', [
            'email' => 'test@my.com',
            'password' => bcrypt('secret')
        ]);

        $response->assertRedirect('/backstage/concerts/');
    }

    /** @test */
    function new()
    {
        $this->get('/backstage/concerts/new');
    }

    /** @test */
    function promoters_can_view_their_concerts()
    {
        $user = factory(User::class)->create();
        $otherUser = factory(User::class)->create();

        $concertA = factory(Concert::class)->create(['user_id' => $user->id]);
        $concertB = factory(Concert::class)->create(['user_id' => $user->id]);
        $concertC = factory(Concert::class)->create(['user_id' => $otherUser->id]);
        $concertD = factory(Concert::class)->create(['user_id' => $user->id]);

        $response = $this->actingAs($user)->get('/backstage/concerts');

        $response->assertStatus(200);

        $data = $response->original->getData()['concerts'];

        $this->assertTrue($data->contains($concertA));
        $this->assertTrue($data->contains($concertB));
        $this->assertTrue($data->contains($concertD));
        $this->assertFalse($data->contains($concertC));
    }

    /** @test */
    function view_concerts_list() {
        $user = factory(User::class)->create();
        $response = $this->actingAs($user)->get('/backstage/concerts');
    }

    /** @test */
    function edit_concert() {
        $user = factory(User::class)->create();
        $concert = factory(Concert::class)->create(['user_id' => $user->id]);
        $this->assertFalse($concert->isPublished());
        
        $response = $this->actingAs($user)->get("/backstage/concerts/{$concert->id}/edit");

        $response->assertStatus(200);
        
        $this->assertTrue($response->original->getData()["concert"]->is($concert));
    }

    /** @test */
    function update_concert() {
        $user = factory(User::class)->create();
        $concert = factory(Concert::class)->create([
            'user_id' => $user->id,
            'title' => 'Big Concert',
            'subtitle' => '',
            'additional_information' => "You must be 19 years of age to attend this concert.",
            'date' => Carbon::parse('2020-01-01 5:00pm'),
            'venue' => 'The Mosh Pit',
            'venue_address' => '123 Fake St.',
            'city' => 'Laraville',
            'state' => 'ON',
            'zip' => '12345',
            'ticket_price' => '6',
            'ticket_quantity' => '10'
        ]);
        

        $response = $this->actingAs($user)->patch("/backstage/concerts/{$concert->id}", [
            'title' => 'HulaHula',
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
            'ticket_quantity' => '11'
        ]);
            
        $this->assertFalse($concert->isPublished());

        $concert = $concert->fresh();

        $response->assertRedirect("/backstage/concerts");

        $this->assertEquals('HulaHula', $concert->title);
        $this->assertEquals(Carbon::parse("2019-08-18 8:00pm"), $concert->date);
        $this->assertEquals('11', $concert->ticket_quantity);
    }
}