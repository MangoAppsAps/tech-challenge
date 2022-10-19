<?php

namespace App\Policies;

use App\Client;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ClientPolicy
{
    use HandlesAuthorization;

    public function view(User $user, Client $client)
    {
        return $client->user_id === $user->id;
    }

    public function delete(User $user, Client $client)
    {
        return $client->user_id === $user->id;
    }
}
