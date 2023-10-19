<?php

namespace App\Http\Controllers;

use App\Client;
use App\Http\Requests\CreateClientRequest;
use App\Http\Resources\ClientResource;
use App\Services\Client\ClientData;
use App\Services\Client\ClientService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ClientsController extends Controller
{
    public function index()
    {
        $clients = Client::where('user_id', Auth::id())
            ->with('bookings')
            ->get()
            ->each(fn (Client $client) => $client->append('bookings_count'));

        return view('clients.index', [
            'clients' => ClientResource::collection($clients)
        ]);
    }

    public function create()
    {
        return view('clients.create');
    }

    public function show(Client $client)
    {
        $client->load([
            'bookings' => fn ($q) => $q->orderBy('start'),
            'journals' => fn ($q) => $q->orderBy('date')
        ]);

        return view('clients.show', [
            'client' => ClientResource::make($client)
        ]);
    }

    public function store(CreateClientRequest $request, ClientService $service)
    {
         $client = $service->create(
            Auth::user(),
            ClientData::fromArray($request->all())
        );

        return [
            'url' => route('client.show', ['client' => $client->id])
        ];
    }

    public function destroy(Client $client, ClientService $service)
    {
        $service->delete($client);

        return [
            'url' => route('client.show', ['client' => $client->id])
        ];
    }
}
