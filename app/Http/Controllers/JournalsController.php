<?php

namespace App\Http\Controllers;

use App\Client;
use App\Journal;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class JournalsController extends Controller
{
    /**
     * The list of journals for a client is on the client's show page.
     */
    public function index(Client $client): RedirectResponse
    {
        return redirect()->route('clients.show', $client);
    }

    public function create(Client $client)
    {
        return view('journals.create', [
            'client' => $client,
        ]);
    }

    public function store(Request $request, Client $client): Journal
    {
        $validated = $request->validate([
            'notes' => 'required',
        ]);

        $journal = $client->journals()->create(array_merge($validated, [
            'date' => now()->format('Y-m-d'),
        ]));

        return $journal;
    }

    public function destroy(Client $client, Journal $journal): RedirectResponse
    {
        $journal->delete();

        return redirect()->route('clients.show', $client)->setStatusCode(303);
    }
}
