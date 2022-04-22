<?php

namespace App\Http\Controllers;

use App\Actions\FilterBooking;
use App\Http\Requests\FilterBookingRequest;
use App\Http\Requests\StoreClientRequest;
use App\Models\Client;
use App\Services\ClientService;

class ClientsController extends Controller
{
    private $clientService;

    public function __construct(ClientService $clientService)
    {
        $this->clientService = $clientService;
    }

    public function index()
    {
        return $this->clientService->index();
    }

    public function create()
    {
        return view('clients.create');
    }

    public function show(Client $client)
    {
        return $this->clientService->show($client);
    }

    public function store(StoreClientRequest $request)
    {
        return $this->clientService->store($request);
    }

    public function destroy(Client $client)
    {
        return $this->clientService->destroy($client);
    }

    public function filterBookings(FilterBookingRequest $request, FilterBooking $filterBooking)
    {
        return $filterBooking->execute($request)->values();
    }
}
