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
        $concerts = factory(Concert::class, 3)->create(['user_id' => $user->id]);

        $response = $this->actingAs($user)->get('/backstage/concerts');

        $response->assertStatus(200);

        $data = $response->original->getData()['concerts'];

        $this->assertTrue($data->contains($concerts[0]));
    }
}