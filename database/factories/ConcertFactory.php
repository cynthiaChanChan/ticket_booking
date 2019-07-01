<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use Carbon\Carbon;
use Faker\Generator as Faker;


$factory->define(App\Concert::class, function (Faker $faker) {
    return [
        'title' => 'Example Band',
        'subtitle' => 'with The Fake Operners',
        'date' => Carbon::parse('+2 weeks'),
        'ticket_price' => 3750,
        'venue' => 'The Big Concert',
        'venue_address' => '10 Big Road',
        'city' => 'New York',
        'state' => 'NY',
        'zip' => '15780',
        'additional_information' => 'For more info, call (1)555-555'
    ];
});

$factory->state(App\Concert::class, 'published', function(Faker $faker) {
    return [
        'published_at' => Carbon::parse('-1 week'),
    ];
});


$factory->state(App\Concert::class, 'unpublished', function(Faker $faker) {
    return [
        'published_at' => null,
    ];
});     
  