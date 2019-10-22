<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use App\User;
use Illuminate\Support\Str;
use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(User::class, function (Faker $faker) {
    return [
        'email' => $faker->unique()->safeEmail,
        'password' => '$2y$10$54Tfs2x18n7XpXh1jiv5HeuN0r8K96bV59ttdHs7d7OEuqz/xijXa', // 'secret'
        'remember_token' => Str::random(10),
        'stripe_account_id' => 'test_account_1234',
        'stripe_access_token' => 'test_token1'
    ];
});
