<?php

namespace App\Http\Controllers\Client;

use App\Client;
use App\Http\Controllers\Controller;
use App\Http\Requests\Client\StoreClientRequest;
use App\Http\Resources\Client as ClientResource;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ClientsController extends Controller
{
    public function index(Request $request): View
    {
        return view('clients.index', [
            'clients' => $request->user()->clients,
        ]);
    }

    public function show(Client $client): View
    {
        $this->authorize('show', $client);

        return view('clients.show', compact('client'));
    }

    public function store(StoreClientRequest $request): ClientResource
    {
        return new ClientResource(
            Client::create([
                'user_id' => $request->user()->id,
                'name' => $request->get('name'),
                'email' => $request->get('email'),
                'phone' => $request->get('phone'),
                'address' => $request->get('address'),
                'city' => $request->get('city'),
                'postcode' => $request->get('postcode'),
            ])
        );
    }

    public function destroy(Client $client): JsonResponse
    {
        $this->authorize('destroy', $client);

        return response()->json(
            $client->delete()
        );
    }
}
