<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Journal;
use Faker\Generator as Faker;

$factory->define(\App\Journal::class, function (Faker $faker) {
    return [
        'date' => $faker->date,
        'text' => $faker->text,
    ];
});
