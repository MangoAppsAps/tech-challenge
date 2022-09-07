<?php

namespace App\Http\Controllers;

use App\Client;
use App\Http\Requests\StoreClient;

class ClientsController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $clients = Client::where('user_id', $user->id)->get();

        foreach ($clients as $client) {
            $client->append('bookings_count');
        }

        return view('clients.index', ['clients' => $clients]);
    }

    public function create()
    {
        return view('clients.create');
    }

    public function show($clientId)
    {
        $client = Client::where('id', $clientId)->with('bookings')->first();

        return view('clients.show', ['client' => $client]);
    }

    public function store(StoreClient $request)
    {
        $validated = $request->validated();
        $user = auth()->user();

        $client = new Client;
        $client->user_id = $user->id;
        $client->name = $validated['name'];
        $client->email = $validated['email'];
        $client->phone = $validated['phone'];
        $client->address = $validated['address'];
        $client->city = $validated['city'];
        $client->postcode = $validated['postcode'];
        $client->save();

        return $client;
    }

    public function destroy($clientId)
    {
        Client::where('id', $clientId)->delete();

        return 'Deleted';
    }
}
