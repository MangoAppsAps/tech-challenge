<?php

namespace App\Services;

use App\Client;
use App\Journal;

class JournalsService
{
    public function createJournal(Client $client, array $journalData): Journal
    {
        $journalData['client_id'] = $client->id;
        $journalData['date'] = now()->format('Y-m-d');

        return Journal::create($journalData);
    }

    public function deleteJournal(Journal $journal)
    {
        $journal->delete();
    }
}
