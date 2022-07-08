<?php

namespace App\Http\Controllers;

use App\Client;
use App\Http\Requests\Client\StoreRequest;
use Illuminate\Support\Facades\Auth;

class ClientsController extends Controller
{
    public function index()
    {
        $clients = Client::filterByAuthUser()
            ->withCount('bookings')
            ->get();

        return view('clients.index', ['clients' => $clients]);
    }

    public function create()
    {
        return view('clients.create');
    }

    public function show(Client $client)
    {
        $this->authorize('view', $client);

        return view('clients.show', ['client' => $client]);
    }

    public function store(StoreRequest $request)
    {
        return Client::create($request->merge([
            'user_id' => Auth::id()
        ])->all());
    }

    public function destroy(Client $client)
    {
        $this->authorize('delete', $client);

        $client->delete();

        return 'Deleted';
    }
}
