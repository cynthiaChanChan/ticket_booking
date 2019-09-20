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
}