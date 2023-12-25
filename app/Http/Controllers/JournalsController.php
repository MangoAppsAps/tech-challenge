<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateJournalRequest;
use App\Client;
use App\Journal;
use App\Services\JournalsService;

class JournalsController extends Controller
{
    protected $journalsService;

    public function __construct(JournalsService $journalsService)
    {
        $this->journalsService = $journalsService;
    }

    public function store(CreateJournalRequest $request, Client $client, )
    {
        $validatedData = $request->validated();
        return $this->journalsService->createJournal($client, $validatedData);
    }

    public function destroy(Client $client, Journal $journal)
    {
        $this->journalsService->deleteJournal($journal);

        return response()->json([]);
    }
}
