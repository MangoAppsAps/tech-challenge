<?php

namespace App\Services;

use App\Models\Client;

class ClientService
{
    public function index()
    {
        $clients=Client::CurrentUser()->latest()->paginate(10);
        return view('clients.index', ['clients' => $clients]);

    }
    public function store($request)
    {
        $request->merge(['user_id' => auth()->id()]);
        return Client::create($request->all());

    }

    public function show($client)
    {
        $client->load('bookings', 'journals');

        return view('clients.show', ['client' => $client]);
    }
    public function destroy($client)
    {
        $client->delete();
        return 'Deleted';
    }

}
