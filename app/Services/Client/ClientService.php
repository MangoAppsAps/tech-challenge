<?php

namespace App\Services\Client;

use App\Client;
use App\User;

class ClientService
{
    public function create(User $user, ClientData $clientData): Client
    {
        return Client::create([
            'user_id' => $user->id,
            'name' => $clientData->name,
            'email' => $clientData->email,
            'phone' => $clientData->phone,
            'address' => $clientData->address,
            'city' => $clientData->city,
            'postcode' => $clientData->postcode,
        ]);
    }

    public function delete(Client $client): void
    {
        $client->delete();
    }
}
