<?php

namespace App\Policies;

use App\Booking;
use App\Client;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class BookingPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user, Client $client): bool
    {
        return $client->user_id === $user->id;
    }

    public function delete(User $user, Booking $booking): bool
    {
        return $booking->client->user_id === $user->id;
    }
}
