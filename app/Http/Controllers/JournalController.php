<?php

namespace App\Http\Controllers;

use App\Client;
use App\Http\Requests\StoreJournalRequest;
use App\Journal;

class JournalController extends Controller
{

    public function create($id)
    {
        return view('journals.create', compact('id'));
    }

    public function store(StoreJournalRequest $request, Client $client)
    {
        $request->merge(['user_id' => Auth()->id()]);
        $client->journals()->create($request->all());

        return "created successfully";
    }

    public function destroy(Journal $journal)
    {
        $journal->delete();
        return 'deleted successfully';
    }
}
