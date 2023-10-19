<?php

namespace App\Services\Journal;

use App\Client;
use App\Journal;

class JournalService
{
    public function create(Client $client, JournalData $journalData): Journal
    {
        return Journal::create([
            'client_id' => $client->id,
            'date' => $journalData->date,
            'description' => $journalData->description,
        ]);
    }

    public function delete(Journal $journal): void
    {
        $journal->delete();
    }
}
