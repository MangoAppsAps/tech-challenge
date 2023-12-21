<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Client;
use App\Journal;
use Faker\Generator as Faker;

$factory->define(Journal::class, function (Faker $faker) {
    return [
        'date' => $faker->dateTimeBetween('-1 year'),
        'notes' => $faker->paragraph,
    ];
});
