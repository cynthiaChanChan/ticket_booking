<?php

use App\Concert;
use App\Order;
use App\Ticket;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
        $concert = factory(Concert::class)->states("published")->create();
        $order = factory(Order::class)->create([
			'confirmation_number' => 'ORDERCONFIRMATION1234',
        	'card_last_four' => '2666'
		]);
		$ticket = factory(Ticket::class, 3)->create([
			'concert_id' => $concert->id,
			'order_id' => $order->id,
			'code' => 'ticketCode'
		]);
    }
}
