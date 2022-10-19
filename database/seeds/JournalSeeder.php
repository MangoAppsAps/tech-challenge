<?php

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
        foreach (Client::cursor() as $client) {
            $numberOfJournals = rand(0, 30);

            Journal::factory($numberOfJournals)->create([
                'client_id' => $client->id,
            ]);
        }
    }
}
