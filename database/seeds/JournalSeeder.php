<?php

namespace Database\Seeders;

use App\Client;
use App\Journal;
use Illuminate\Database\Seeder;

class JournalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Client::all()->each(function ($client) {
            factory(Journal::class, rand(10, 15))->create([
                'client_id' => $client->id,
            ]);
        });
    }
}
