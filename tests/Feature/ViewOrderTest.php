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
			'confirmation_number' => 'ORDERCONFIRMATION1234',
			'card_last_four' => '1984',
			'amount' => 8500
		]);
		$ticket = factory(Ticket::class)->create([
			'concert_id' => $concert->id,
			'order_id' => $order->id,
			'code' => 'ticketCode123'
		]);
		$ticket = factory(Ticket::class)->create([
			'concert_id' => $concert->id,
			'order_id' => $order->id,
			'code' => 'ticketCode456'
		]);

		$response = $this->get("/orders/ORDERCONFIRMATION1234");

		$response->assertStatus(200);

		$response->assertViewHas('order', function($viewOrder) use ($order) {
			return $order->id === $viewOrder->id;
		});

		$response->assertSee('ORDERCONFIRMATION1234');
		$response->assertSee('$85.00');
		$response->assertSee('**** **** **** 1984');
		$response->assertSee('ticketCode123');
		$response->assertSee('ticketCode456');
	}
}