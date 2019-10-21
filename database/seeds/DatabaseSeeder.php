<?php

use App\Order;
use App\Ticket;
use App\Concert;
use Carbon\Carbon;
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
        $faker = \Faker\Factory::create();
        $gateway = new \App\Billing\FakePaymentGateway;
        
        $user = factory(App\User::class)->create([
            'email' => 'user@somewhere.com',
            'password' => bcrypt('secret')
        ]);

        //Create published concerts
        $concert = factory(App\Concert::class)->create([
            'user_id' => $user->id,
            'title' => "The Red Chord",
            'subtitle' => "with Animosity and Lethargy",
            'venue' => "The Mosh Pit",
            'venue_address' => "123 Example Lane",
            'city' => "Laraville",
            'state' => "ON",
            'zip' => "17916",
            'date' => Carbon::today()->addMonths(3)->hours(20),
            'ticket_price' => 3250,
            'ticket_quantity' => 210,
            'additional_information' => "This concert is 19+.",
        ]);

        $concert->publish();

        foreach(range(1, 50) as $i) {
            Carbon::setTestNow(Carbon::instance($faker->dateTimebetween('-2 months')));

            $concert->reserveTickets(rand(1, 4), $faker->safeEmail)
                ->complete($gateway, $gateway->getValidTestToken($faker->creditCardNumber), 'test_account_1234');
        }

        Carbon::setTestNow();

        //Create unpublished concerts
        factory(App\Concert::class)->create([
            'user_id' => $user->id,
            'title' => "Slayer",
            'subtitle' => "with Forbidden and Testament",
            'venue' => "The Rock Pile",
            'venue_address' => "55 Sample Blvd",
            'city' => "Laraville",
            'state' => "ON",
            'zip' => "19276",
            'date' => Carbon::today()->addMonths(3)->hours(20),
            'ticket_price' => 5500,
            'ticket_quantity' => 10,
            'additional_information' => null,
        ]);
    }
}
