<?php

namespace App\Http\Controllers;

use App\Client;
use App\Http\Requests\CreateClientRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ClientsController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $clients = $user->clients;

        foreach ($clients as $client) {
            $client->append('bookings_count');
        }

        return view('clients.index', ['clients' => $clients]);
    }

    public function create()
    {
        return view('clients.create');
    }

    public function show(Client $client)
    {
        $client = $client->load(['bookings' => function ($query) {
            $query->orderBy('start', 'desc');
        }]);

        return view('clients.show', ['client' => $client]);
    }

    public function store(CreateClientRequest $request)
    {
        $user = Auth::user();

        return $user->clients()->create($request->validated());
    }

    public function destroy(Client $client)
    {
        $user = Auth::user();

        if ($user->id === $client->user_id) {
            $client->delete();

            return response()->json([]);
        }

        return response()->json(['error' => 'Cannot delete this client'], 400);
    }
}
