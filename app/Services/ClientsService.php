<?php

namespace App\Services;

use App\Client;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class ClientsService
{
    public function getClientsForUser()
    {
        $user = Auth::user();
        $clients = $user->clients;

        foreach ($clients as $client) {
            $client->append('bookings_count');
        }

        return $clients;
    }

    public function getClientDetails(Client $client)
    {
        if (!Gate::allows('show-client', $client)) {
            abort(403, 'Unauthorized action.');
        }

        return $client->load([
            'bookings' => function ($query) {
                $query->orderBy('start', 'desc');
            },
            'journals' => function ($query) {
                $query->orderBy('date', 'desc');
            }
        ]);
    }

    public function createClient($validatedData)
    {
        $user = Auth::user();
        return $user->clients()->create($validatedData);
    }

    public function deleteClient(Client $client)
    {
        if (!Gate::allows('delete-client', $client)) {
            abort(403, 'Unauthorized action.');
        }

        $client->delete();
        return response()->json([]);
    }
}
