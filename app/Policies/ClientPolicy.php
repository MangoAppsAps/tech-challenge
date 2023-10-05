<?php

namespace App\Policies;

use App\Client;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ClientPolicy
{
    use HandlesAuthorization;

    public function show(User $user, Client $client): bool
    {
        return $user->id === $client->user_id;
    }

    public function destroy(User $user, Client $client): bool
    {
        return $user->id === $client->user_id;
    }
}
