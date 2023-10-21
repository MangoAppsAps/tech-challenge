<?php

namespace App\Http\Controllers;

use App\Journal;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;

class JournalsController extends Controller
{
    public function create($client): View
    {
        return view('journals.create', ['client' => $client]);
    }

    public function store(Request $request): Journal
    {
        $journal = new Journal;
        $journal->text = $request->get('text');
        $date = new Carbon($request->get('date'));
        $journal->date = $date;
        $journal->client_id = $request->get('client_id');
        $journal->save();

        return $journal;
    }

    public function destroy($client, $journal): bool
    {
        $journalEntity = Journal::find($journal);

        if ($journalEntity === null) {
            return false;
        }

        $deleted = Journal::where('id', $journal)
            ->where('client_id', $client)
            ->delete();

        return $deleted;
    }
}
