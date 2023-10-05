<?php

namespace App\Http\Controllers;

use App\Client;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;

class ClientsController extends Controller
{
    public function index(Request $request): View
    {
        $clients = Client::where('user_id', $request->user()->id)->get();

        foreach ($clients as $client) {
            $client->append('bookings_count');
        }

        return view('clients.index', ['clients' => $clients]);
    }

    public function create()
    {
        return view('clients.create');
    }

    public function show(Request $request, Client $client): View
    {
        if ($client->user_id !== $request->user()->id) {
            abort(Response::HTTP_FORBIDDEN);
        }

        return view('clients.show', ['client' => $client->load('bookings')]);
    }

    public function store(Request $request): Client
    {
        $client = new Client;
        $client->user_id = $request->user()->id;
        $client->name = $request->get('name');
        $client->email = $request->get('email');
        $client->phone = $request->get('phone');
        $client->address = $request->get('address');
        $client->city = $request->get('city');
        $client->postcode = $request->get('postcode');
        $client->save();

        return $client;
    }

    public function destroy(Request $request, Client $client): string
    {
        if ($client->user_id !== $request->user()->id) {
            abort(Response::HTTP_FORBIDDEN);
        }

        $client->delete();

        return 'Deleted';
    }
}
