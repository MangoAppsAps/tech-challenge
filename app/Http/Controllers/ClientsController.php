<?php

namespace App\Http\Controllers;

use App\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ClientsController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $clients = $user->clients;

        return view('clients.index', ['clients' => $clients]);
    }

    public function create()
    {
        return view('clients.create');
    }

    public function show($client)
    {
        $client = Client::where('id', $client)->with(['bookings' => function ($query) {
            $query->orderBy('created_at', 'desc');
        }])->first();

        return view('clients.show', ['client' => $client]);
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        $client = new Client;
        $client->name = $request->get('name');
        $client->email = $request->get('email');
        $client->phone = $request->get('phone');
        $client->adress = $request->get('adress');
        $client->city = $request->get('city');
        $client->postcode = $request->get('postcode');
        $client->created_by = $user->id;
        $client->save();

        return $client;
    }

    public function destroy(Client $client)
    {
        $client->delete();

        return 'Deleted';
    }
}
