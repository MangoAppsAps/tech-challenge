<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Journal;
use Faker\Generator as Faker;
use Illuminate\Support\Carbon;

$factory->define(Journal::class, function (Faker $faker) {
    return [
        'date' => Carbon::make($faker->dateTimeBetween('-1 year', '+1 year')),
        'text' => $faker->boolean(30) ? $faker->paragraphs(1, true) : '',
    ];
});
