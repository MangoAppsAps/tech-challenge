<?php

namespace App\Http\Controllers;

use App\Client;
use App\Http\Requests\CreateClientRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

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
        if (!Gate::allows('show-client', $client)) {
            abort(403, 'Unauthorized action.');
        }

        $client = $client->load([
            'bookings' => function ($query) {
                $query->orderBy('start', 'desc');
            },
            'journals' => function ($query) {
                $query->orderBy('date', 'desc');
            }
        ]);

        return view('clients.show', ['client' => $client]);
    }

    public function store(CreateClientRequest $request)
    {
        $user = Auth::user();

        return $user->clients()->create($request->validated());
    }

    public function destroy(Client $client)
    {
        if (!Gate::allows('delete-client', $client)) {
            abort(403, 'Unauthorized action.');
        }

        $user = Auth::user();

        if ($user->id === $client->user_id) {
            $client->delete();

            return response()->json([]);
        }

        return response()->json(['error' => 'Cannot delete this client'], 400);
    }
}
