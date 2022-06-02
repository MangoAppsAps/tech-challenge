<?php

namespace App\Http\Controllers;

use App\Client;
use App\Journal;
use http\Env\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class JournalController extends Controller
{
    public function store(Request $request, $clientId)
    {
        // Check if the user owns the client before creating a journal
        if(is_null(Client::where('id', $clientId)->where('owned_by', Auth::id())->first()))
        {
            return response()->status(401);
        }

        $journal = new Journal();
        $journal->client_id = $clientId;
        $journal->journal = $request->input('journal');
        $journal->save();

        return $journal;
    }

    public function destroy($clientId, $journalId)
    {
        // Check if the user owns the client before creating a journal
        if(is_null(Client::where('id', $clientId)->where('owned_by', Auth::id())->first()))
        {
            return response()->status(401);
        }

        Journal::where('id', $journalId)
            ->where('client_id', $clientId)
            ->delete();

        return 'Deleted';
    }
}
