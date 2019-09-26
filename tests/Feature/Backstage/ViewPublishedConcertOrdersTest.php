<?php

namespace Tests\Feature;

use App\User;
use App\Order;
use App\Ticket;
use App\Concert;
use Carbon\Carbon;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ViewPublishedConcertOrdersTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    function promoter_can_view_the_orders_of_their_own_published_concert()
    {
        $user = factory(User::class)->create();
        $concert = factory(Concert::class)->create([
            'user_id' => $user->id
        ]);
        $concert->publish();
        
        $order = factory(Order::class)->create(['created_at' => Carbon::parse('10 days ago')]);
        $tickets = factory(Ticket::class, 1)->create(['concert_id' => $concert->id]);
        $order->tickets()->saveMany($tickets);

        $response = $this->actingAs($user)->get("/backstage/published-concerts/{$concert->id}/orders");

        $response->assertStatus(200);
        $response->assertViewIs('backstage.published-concert-orders.index');
        $this->assertTrue($response->original->getData()['concert']->is($concert));
    }
}