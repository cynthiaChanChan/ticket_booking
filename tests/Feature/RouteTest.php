<?php

namespace Tests\Feature;

use App\User;
use App\Concert;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class RouteTests extends TestCase
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
}