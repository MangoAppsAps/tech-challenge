<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\User;
use App\Client;
use Faker\Generator as Faker;

$factory->define(Client::class, function (Faker $faker) {
    return [
        'user_id' => rand(1, User::count()),
        'name' => $faker->name,
        'email' => $faker->email,
        'phone' => $faker->phoneNumber,
        'address' => $faker->streetAddress,
        'city' => $faker->city,
        'postcode' => $faker->postcode,
    ];
});
