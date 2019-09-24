<?php

namespace Tests\Feature;

use App\User;
use App\Concert;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class PublishConcertTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    function promoter_can_publish_their_own_concert()
    {
        $user = factory(User::class)->create();
        $concert = factory(Concert::class)->state('unpublished')->create([
            'user_id' => $user->id,
            'ticket_quantity' => 3
        ]);

        $response = $this->actingAs($user)->post('/backstage/published-concerts', [
            'concert_id' => $concert->id
        ]);

        $response->assertRedirect('/backstage/concerts');

        $concert = $concert->fresh();

        $this->assertTrue($concert->isPublished());

        $this->assertEquals(3, $concert->ticketsRemaining());

    }

    /** @test */
    function concert_can_only_be_published_once() {
        $user = factory(User::class)->create();
        $concert = factory(Concert::class)->create([
            'user_id' => $user->id,
            'ticket_quantity' => 3
        ]);

        $concert->publish();

        $response = $this->actingAs($user)->post('/backstage/published-concerts', [
            'concert_id' => $concert->id
        ]);

        $response->assertStatus(422);

        $this->assertEquals(3, $concert->fresh()->ticketsRemaining());
    }

    /** @test */
    function promoter_cannot_publish_other_concerts()
    {
        $user = factory(User::class)->create();
        $otheruser = factory(User::class)->create();
        $concert = factory(Concert::class)->states('unpublished')->create([
            'user_id' => $otheruser->id,
            'ticket_quantity' => 3
        ]);

        $response = $this->actingAs($user)->post('/backstage/published-concerts', [
            'concert_id' => $concert->id
        ]);

        $response->assertStatus(404);
        $concert = $concert->fresh();
        $this->assertFalse($concert->isPublished());
        $this->assertEquals(0, $concert->ticketsRemaining());
    }

    /** @test */
    function guest_cannot_publish_concerts()
    {
        $concert = factory(Concert::class)->states('unpublished')->create([
            'ticket_quantity' => 3
        ]);

        $response = $this->post('/backstage/published-concerts', [
            'concert_id' => $concert->id
        ]);

        $concert = $concert->fresh();
        $this->assertFalse($concert->isPublished());
        $this->assertEquals(0, $concert->ticketsRemaining());

    }
}