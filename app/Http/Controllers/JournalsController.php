<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateJournalRequest;
use App\Client;
use App\Journal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class JournalsController extends Controller
{
    public function store(CreateJournalRequest $request, Client $client, )
    {
        $data = $request->validated();
        $data['client_id'] = $client->id;
        $data['date'] = now()->format('Y-m-d');

        return Journal::create(
            $data
        );
    }

    public function destroy(Client $client, Journal $journal)
    {
        $journal->delete();

        return response()->json([]);
    }
}
