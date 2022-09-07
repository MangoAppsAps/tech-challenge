<?php

namespace App\Http\Controllers;

use App\Client;
use Illuminate\Http\Request;

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

    public function store(Request $request)
    {
        $user = auth()->user();

        $client = new Client;
        $client->user_id = $user->id;
        $client->name = $request->get('name');
        $client->email = $request->get('email');
        $client->phone = $request->get('phone');
        $client->address = $request->get('address');
        $client->city = $request->get('city');
        $client->postcode = $request->get('postcode');
        $client->save();

        return $client;
    }

    public function destroy($clientId)
    {
        Client::where('id', $clientId)->delete();

        return 'Deleted';
    }
}
