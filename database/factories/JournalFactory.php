<?php

namespace Database\Factories;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

class JournalFactory extends Factory
{
    public function definition()
    {
        return [
            'date' => Carbon::make($this->faker->dateTimeBetween('-1 year', '+1 year')),
            'description' => $this->faker->sentences(4, true)
        ];
    }
}
