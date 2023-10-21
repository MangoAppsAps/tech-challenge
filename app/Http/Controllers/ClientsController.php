<?php

namespace App\Http\Controllers;

use App\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ClientsController extends Controller
{
    public function index()
    {
        $userId = Auth::user()->id;

        $clients = Client::where('owner_id', $userId)->get();

        foreach ($clients as $client) {
            $client->append('bookings_count');
        }

        return view('clients.index', ['clients' => $clients]);
    }

    public function create()
    {
        return view('clients.create');
    }

    public function show($client)
    {
        $client = Client::where('id', $client)->first();

        // Add chronologically-ordered bookings belonging to client to $client, using bookings relationship
        $client['bookings'] = $client->bookings()->orderBy('start', 'desc')->get();

        return view('clients.show', ['client' => $client]);
    }

    public function store(Request $request)
    {
        $userId = Auth::user()->id;

        $client = new Client;
        $client->name = $request->get('name');
        $client->email = $request->get('email');
        $client->phone = $request->get('phone');
        $client->address = $request->get('address');
        $client->city = $request->get('city');
        $client->postcode = $request->get('postcode');
        $client->owner_id = $userId;
        $client->save();

        return $client;
    }

    public function destroy($client)
    {
        Client::where('id', $client)->delete();

        return 'Deleted';
    }
}
