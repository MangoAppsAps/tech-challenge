<?php

namespace App\Http\Controllers;

use App\Client;
use Illuminate\Http\Request;

class ClientsController extends Controller
{
    public function index()
    {
        $clients = Client::where('user_id', auth()->user()->id)->get();

        // TODO: append directly on the Eloquent query. No need for loop
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
        $client = Client::where('id', $client)->with('bookings')->first();

        return view('clients.show', ['client' => $client]);
    }

    public function store(Request $request)
    {
        // TODO: Place this in a form request for validation and save validated data
        $client = new Client;
        $client->user_id = auth()->user()->id;
        $client->name = $request->get('name');
        $client->email = $request->get('email');
        $client->phone = $request->get('phone');
        $client->address = $request->get('address');
        $client->city = $request->get('city');
        $client->postcode = $request->get('postcode');
        $client->save();

        return $client;
    }

    public function destroy($client)
    {
        // TODO: validate this for only allowing current auth()->user() to delete clients owned by them
        Client::where('id', $client)->delete();

        return 'Deleted';
    }
}
