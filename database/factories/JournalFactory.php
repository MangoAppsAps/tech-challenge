<?php

namespace Database\Factories;

use App\Client;
use App\Journal;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class JournalFactory extends Factory
{
    protected $model = Journal::class;

    public function definition(): array
    {
        return [
            'date' => Carbon::now(),
            'text' => $this->faker->text(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),

            'client_id' => Client::factory(),
        ];
    }

    public function forClient(Client $client): static
    {
        return $this->state(fn () => [
            'client_id' => $client->id,
        ]);
    }
}
