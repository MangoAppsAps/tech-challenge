<?php

namespace App\Http\Controllers;

use App\Client;
use App\Http\Requests\CreateJournalRequest;
use App\Journal;
use App\Services\Journal\JournalData;
use App\Services\Journal\JournalService;
use Illuminate\Http\Request;

class JournalsController extends Controller
{
    public function create(Request $request, Client $client)
    {
        return view('journals.create', [
            'client' => $client
        ]);
    }

    public function store(CreateJournalRequest $request, Client $client, JournalService $service)
    {
        return $service->create(
            $client,
            JournalData::fromArray($request->all())
        );
    }

    public function destroy(Request $request, Journal $journal, JournalService  $service)
    {
        $service->delete($journal);
    }
}
