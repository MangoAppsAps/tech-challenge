<?php

namespace App\Http\Controllers;

use App\Client;
use App\User;
use App\Http\Requests\StoreClient;
use Illuminate\Support\Facades\Auth;

class ClientsController extends Controller
{
    public function index()
    {

        $clients = User::find(Auth::id())->clients;

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
        $client->bookings;

        return view('clients.show', ['client' => $client]);
    }

    public function store(StoreClient $request)
    {
        $data = array_merge(
            $request->all(),
            $request->validated(),
        );
        $data['user_id'] = Auth::id();

        return Client::create($data);
    }

    public function destroy($client)
    {
        Client::where('id', $client)->delete();

        return 'Deleted';
    }
}
