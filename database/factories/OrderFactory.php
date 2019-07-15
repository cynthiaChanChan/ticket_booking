<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Order;
use Faker\Generator as Faker;

$factory->define(Order::class, function (Faker $faker) {
    return [
        'email' => 'cindy@example.com',
        'amount' => 5000,
        'card_last_four' => '2666'
    ];
});
