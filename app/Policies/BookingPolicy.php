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
        return $user->id === $client->user_id;
    }

    public function destroy(User $user, Booking $booking, Client $client): bool
    {
        return $client->id === $booking->client_id &&
            $user->id === $booking->client->user_id;
    }
}
