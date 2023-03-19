<?php

namespace App\Http\Controllers;

use App\Client;
use Illuminate\Http\Request;

class ClientsController extends Controller
{
    public function index()
    {
        $clients = auth()->user()->clients;

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
        $client = Client::where('id', $client)
            ->with('bookings', fn ($q) => $q->orderBy('start', 'DESC'))
            ->first();

        return view('clients.show', ['client' => $client]);
    }

    public function filterBookings(Request $request, Client $client) {
        return $client->bookings()
                ->when($request->filter == 'future', fn($q) => $q->where('start', '>', now()))
                ->when($request->filter == 'past', fn($q) => $q->where('start', '<', now()))
                ->orderBy('start', 'DESC')
                ->get();
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:190',
            'email' => 'required_without:phone|nullable|email:rfc,dns',
            'phone' => 'required_without:email|nullable|regex:/^\+?[0-9\s]+$/',
        ]);

        $client = new Client;
        $client->name = $request->get('name');
        $client->email = $request->get('email');
        $client->phone = $request->get('phone');
        $client->address = $request->get('adress');
        $client->city = $request->get('city');
        $client->postcode = $request->get('postcode');
        $client->user_id = auth()->id();
        $client->save();

        return $client;
    }

    public function destroy($client)
    {
        Client::where('id', $client)->delete();

        return 'Deleted';
    }
}
