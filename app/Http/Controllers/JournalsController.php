<?php

namespace App\Http\Controllers;

use App\Client;
use App\Journal;
use Illuminate\Http\Request;
use Carbon\Carbon;

class JournalsController extends Controller
{
    public function create($client)
    {
        $current_client = Client::where('id', $client)->first();
        return view('journals.create', ['current_client' => $current_client]);
    }

    public function store(Request $request)
    {
        $date = Carbon::parse($request->get('date'))->toDateTimeString();

        $journal = new Journal();
        $journal->date = $date;
        $journal->content = $request->get('content');
        $journal->client_id = $request->get('client_id');
        $journal->save();

        return $journal;
    }

    public function destroy($client, $journal)
    {
        Journal::where('id', $journal)->delete();
        $client = Client::where('id', $client)->first();
        $client->load('journals');
        return $client;
    }
}
