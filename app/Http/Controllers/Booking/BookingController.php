<?php

namespace App\Http\Controllers\Booking;

use App\Client;
use App\Http\Controllers\Controller;
use App\Booking;
use App\Http\Resources\Booking as BookingResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class BookingController extends Controller
{
    public function index(Client $client): AnonymousResourceCollection
    {
        $this->authorize('viewAny', [Booking::class, $client]);

        return BookingResource::collection(
            $client->bookings
        );
    }

    public function destroy(Client $client, Booking $booking): JsonResponse
    {
        $this->authorize('destroy', [$booking, $client]);

        return response()->json(
            $booking->delete()
        );
    }
}
