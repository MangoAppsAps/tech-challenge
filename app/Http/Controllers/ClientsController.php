<?php

namespace App\Http\Controllers;

use App\Client;
use App\Http\Requests\CreateClientRequest;
use App\Services\ClientsService;

class ClientsController extends Controller
{
    protected $clientsService;

    public function __construct(ClientsService $clientsService)
    {
        $this->clientsService = $clientsService;
    }

    public function index()
    {
        $clients = $this->clientsService->getClientsForUser();
        return view('clients.index', ['clients' => $clients]);
    }

    public function create()
    {
        return view('clients.create');
    }

    public function show(Client $client)
    {
        $client = $this->clientsService->getClientDetails($client);
        return view('clients.show', ['client' => $client]);
    }

    public function store(CreateClientRequest $request)
    {
        $validatedData = $request->validated();
        return $this->clientsService->createClient($validatedData);
    }

    public function destroy(Client $client)
    {
        return $this->clientsService->deleteClient($client);
    }
}
