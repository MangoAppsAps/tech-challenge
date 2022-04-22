<?php

namespace App\Http\Controllers;

use App\Client;
use App\Journal;
use Illuminate\Http\Request;

class JournalsController extends Controller
{
    public function index(Client $client)
    {

        return response()->json([
            'journals' =>  $client->journals
        ]);
    }

    public function store(Request $request)
    {
        $journal = new Journal;
        $journal->date = $request->get('date');
        $journal->notes = $request->get('notes');
        $journal->client_id = $request->get('client');
        $journal->save();

        return $journal;
    }

    public function destroy(Journal $journal)
    {
        $journal->delete();

        return 'Deleted';
    }
}
