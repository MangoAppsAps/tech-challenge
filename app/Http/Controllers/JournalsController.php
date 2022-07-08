<?php

namespace App\Http\Controllers;

use App\Client;
use App\Http\Requests\Journal\StoreRequest;
use App\Journal;

class JournalsController extends Controller
{
    public function index(Client $client)
    {
        $this->authorize('view', $client);

        return response()->json([
            'journals' => $client->journals
        ]);
    }

    public function create(Client $client)
    {
        return view('journals.create')->with([
            'client' => $client
        ]);
    }

    public function store(Client $client, StoreRequest $request)
    {
        return Journal::create($request->merge([
            'client_id' => $client->id
        ])->all());
    }

    public function destroy(Client $client, Journal $journal)
    {
        $this->authorize('delete', $journal);

        $journal->delete();

        return 'Deleted';
    }
}
