<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreJournalRequest;
use App\Models\Client;
use App\Models\Journal;
use App\Services\JournalService;

class JournalController extends Controller
{

    private $journalService;

    public function __construct(JournalService $journalService)
    {
        $this->journalService = $journalService;
    }

    public function create($id)
    {
        return view('journals.create', compact('id'));
    }

    public function store(StoreJournalRequest $request, Client $client)
    {
        return $this->journalService->store($request, $client);
    }

    public function destroy(Journal $journal)
    {
        return $this->journalService->destroy($journal);
    }
}
