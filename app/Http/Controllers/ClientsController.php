<?php

namespace App\Http\Controllers;

use App\Client;
use Illuminate\Http\Request;

class ClientsController extends Controller
{
    public function index()
    {
        $userId = auth()->id();
        $clients = Client::where('userId', $userId)->get();
//        $clients = Client::all();

        foreach ($clients as $client) {
            $client->append('bookings_count');
        }
        foreach ($clients as $client) {
            $client->journals_count = $client->journalsCount();
        }
        return view('clients.index', ['clients' => $clients]);
    }

    public function create()
    {
        $userId = auth()->id();
        return view('clients.create', ['userId' => $userId]);
    }

    public function show($client)
    {
        $client = Client::where('id', $client)->first();
        $client->load('bookings');
        $client->load('journals');
        return view('clients.show', ['client' => $client]);
    }

    public function store(Request $request)
    {
        $client = new Client;
        $client->name = $request->get('name');
        $client->email = $request->get('email');
        $client->phone = $request->get('phone');
        $client->address = $request->get('address');
        $client->city = $request->get('city');
        $client->postcode = $request->get('postcode');
        $client->userId = $request->get('userId');
        $client->save();

        return $client;
    }

    public function destroy($client)
    {
        Client::where('id', $client)->delete();
        $userId = auth()->id();
        return Client::where('userId', $userId)->get();
    }
}
