<?php

namespace Tests\Feature;

use App\Concert;
use App\Order;
use App\Ticket;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;

class ViewOrderTest extends TestCase
{
	use DatabaseMigrations;

	/** @test */
	function user_can_view_their_order_confirmation()
	{
		$concert = factory(Concert::class)->create();
		$order = factory(Order::class)->create([
			'confirmation_number' => 'ORDERCONFIRMATION1234'
		]);
		$ticket = factory(Ticket::class)->create([
			'concert_id' => $concert->id,
			'order_id' => $order->id
		]);

		$response = $this->get("/orders/ORDERCONFIRMATION1234");

		$response->assertStatus(200);
	}
}