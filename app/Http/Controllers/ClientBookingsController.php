<?php

namespace App\Http\Controllers;

use App\Booking;
use App\Client;
use App\Http\Resources\BookingResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;

class ClientBookingsController extends Controller
{
    public function index(Client $client): JsonResource
    {
        $this->authorize('viewAny', [Booking::class, $client]);

        $bookings = $client->bookings()
            ->when(in_array(request('time'), ['past', 'future']), function ($query) {
                $operator = request('time') === 'past' ? '<' : '>';
                $query->where('start', $operator, now());
            });

        return BookingResource::collection(
            $bookings->latest()->paginate()->withQueryString()
        );
    }

    public function destroy(Client $client, Booking $booking): JsonResponse
    {
        $this->authorize('delete', $booking);

        $booking->delete();

        return response()->json();
    }
}
