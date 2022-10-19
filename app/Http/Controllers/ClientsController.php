<?php

namespace App\Http\Controllers;

use App\Client;
use App\Http\Requests\ClientStoreRequest;
use App\Http\Resources\ClientResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\View\View;

class ClientsController extends Controller
{
    public function index(Request $request): View
    {
        $clients = $request->user()->clients()
            ->withCount('bookings')
            ->paginate();

        return view('clients.index', [
            'clients' => ClientResource::collection($clients)->response()->getData(),
        ]);
    }

    public function create(): View
    {
        return view('clients.create');
    }

    public function show(Client $client): View
    {
        $this->authorize('view', $client);

        return view('clients.show', [
            'client' => ClientResource::make($client)
        ]);
    }

    public function store(ClientStoreRequest $request): JsonResource
    {
        return ClientResource::make(
            Client::create([
                'user_id' => auth()->id(),
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'phone' => $request->input('phone'),
                'address' => $request->input('address'),
                'city' => $request->input('city'),
                'postcode' => $request->input('postcode'),
            ])
        );
    }

    public function destroy(Client $client): JsonResponse
    {
        $this->authorize('delete', $client);

        $client->delete();

        return response()->json();
    }
}
