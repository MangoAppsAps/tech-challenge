<?php

namespace App\Http\Controllers;

use App\Client;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;

class ClientsController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $clients = Client::latest()->where('user_id', $user->id)->get();

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
        $user = auth()->user();
        $client = Client::where('id', $client)->with(['bookings'])->first();

        if($client->user_id !== $user->id) {
            throw new AuthorizationException('Unauthorized to perform the action');
        }

        return view('clients.show', ['client' => $client]);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string|max:190',
            'email' => 'required_without:phone|nullable|email',
            'phone' => 'required_without:email|nullable|regex:/^[\d\s+]+$/',
        ]);

        $user = auth()->user();

        $client = new Client;
        $client->name = $request->get('name');
        $client->email = $request->get('email');
        $client->phone = $request->get('phone');
        $client->address = $request->get('address');
        $client->city = $request->get('city');
        $client->postcode = $request->get('postcode');
        $client->user_id = $user->id;
        $client->save();

        return $client;
    }

    public function destroy($client)
    {
        $user = auth()->user();
        $client = Client::where('id', $client)->first();

        if($client->user_id !== $user->id) {
            throw new AuthorizationException('Unauthorized to perform the action');
        }

        $client->delete();
        return 'Deleted';
    }
}
