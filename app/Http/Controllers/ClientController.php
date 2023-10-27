<?php

namespace App\Http\Controllers;

use App\Client;
use App\Http\Requests\ClientStoreRequest;

class ClientController extends Controller
{
    public function index()
    {
        $clients = Client::where('user_id', auth()->user()->id)
            ->orderByDesc('created_at')
            ->get()
            ->append('bookings_count');

        return view('clients.index', ['clients' => $clients]);
    }

    public function create()
    {
        return view('clients.create');
    }

    public function show($client)
    {
        $client = Client::where('user_id', auth()->user()->id)
            ->where('id', $client)
            ->with(['bookings', 'journals'])
            ->first();
        if (!$client) return redirect('/clients');

        return view('clients.show', ['client' => $client]);
    }

    public function store(ClientStoreRequest $request)
    {
        return Client::create($request->validated());
    }

    public function destroy($client)
    {
        // TODO: validate this for only allowing current auth()->user() to delete clients owned by them
        Client::where('id', $client)->delete();

        // TODO: Remove as this is not being read on the front-end
        return 'Deleted';
    }
}
