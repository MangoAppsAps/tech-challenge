<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Client;
use App\Journal;

class JournalsController extends Controller
{

    public function create()
    {
        return view('journals.create');
    }

    public function store(Request $request)
    {

        $journal = new Journal;
        $journal->client_id = $request->get('client_id');
        $journal->date = now();
        $journal->notes = $request->get('note');

        $journal->save();

        return $journal;
    }

    public function destroy($client, $journal)
    {

        Journal::where('id', $journal)->delete();

        return 'Deleted';
    }
}
