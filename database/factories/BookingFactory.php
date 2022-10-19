<?php

namespace Database\Factories;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

class BookingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $start = Carbon::make($this->faker->dateTimeBetween('-1 year', '+1 year'));
        $end = $start->copy()->addMinutes($this->faker->randomElement([15, 30, 45, 60, 75, 90]));

        return [
            'start' => $start,
            'end' => $end,
            'notes' => $this->faker->boolean(30) ? $this->faker->paragraphs(1, true) : '',
        ];
    }
}

