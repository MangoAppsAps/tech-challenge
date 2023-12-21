<?php

namespace App\Http\Controllers;

use App\Client;
use App\Journal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class JournalsController extends Controller
{
    public function create(Client $client)
    {
        if (!Gate::allows('view-client', $client)) {
            abort(403);
        }
        return view('journals.create',compact('client'));
    }

    public function store(Client $client, Request $request)
    {
        if (!Gate::allows('create-journal', $client)) {
            abort(403);
        }

        $data = $request->validate([
            'date' => 'required|date_format:Y-m-d',
        ]);

        $journal = $client->journals()->create($data);

        return $journal ? 'Success' : 'Failure';
    }


    public function destroy(Client $client, Journal $journal)
    {
        if (!Gate::allows('delete-journal', $journal)) {
            abort(403);
        }

        $journal->delete();

        return 'Success';
    }
}
