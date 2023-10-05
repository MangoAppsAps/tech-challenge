<?php

namespace App\Policies;

use App\Client;
use App\Journal;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class JournalPolicy
{
    use HandlesAuthorization;

    public function store(User $user, Client $client): bool
    {
        return $user->id === $client->user_id;
    }

    public function destroy(User $user, Journal $journal, Client $client): bool
    {
        return $client->id === $journal->client_id &&
            $user->id === $journal->client->user_id;
    }
}
