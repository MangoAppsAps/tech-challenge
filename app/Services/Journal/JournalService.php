<?php

namespace App\Services\Journal;

use App\Client;
use App\Journal;

class JournalService
{
    public function create(Client $client, array $data): Journal
    {
        return Journal::create([
            'client_id' => $client->id,
            'date' => $data['date'],
            'description' => $data['description'],
        ]);
    }

    public function delete(Journal $journal): bool
    {
        $journal->delete();
        return true;
    }
}
