<?php

use App\Journal;
use App\Client;
use Illuminate\Database\Seeder;

class JournalSeeder extends Seeder
{
    public function run()
    {
        $clients = Client::all();

        foreach ($clients as $client) {
            Journal::factory(10)->create([
                'client_id' => $client->id
            ]);
        }
    }
}
