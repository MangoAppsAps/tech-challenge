<?php

namespace App\Policies;

use App\Client;
use App\Journal;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class JournalPolicy
{
    use HandlesAuthorization;

    public function view(User $user, Client $client): bool
    {
        return $client->user_id === $user->id;
    }

    public function delete(User $user, Journal $journal): bool
    {
        return $journal->client->user_id === $user->id;
    }
}
