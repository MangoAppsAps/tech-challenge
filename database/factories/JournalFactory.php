<?php

namespace Database\Factories;

use App\Client;
use Illuminate\Database\Eloquent\Factories\Factory;

class JournalFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'client_id' => Client::factory(),
            'date' => $this->faker->date,
            'content' => $this->faker->paragraphs(3, true),
        ];
    }
}
