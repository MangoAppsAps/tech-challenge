<?php

namespace App\Http\Controllers;

use App\Client;
use App\Http\Requests\CreateJournalRequest;
use App\Journal;
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
        $service->create($client, $request->all());

        return [
            'url' => route('client.show', ['client' => $client->id, 'current_tab' => 'journals'])
        ];
    }

    public function destroy(Request $request, Client  $client, Journal $journal, JournalService  $service)
    {
        $service->delete($journal);

        return [
            'url' => route('client.show', ['client' => $client->id, 'current_tab' => 'journals'])
        ];
    }
}
