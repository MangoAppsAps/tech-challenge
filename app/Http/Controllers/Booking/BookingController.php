<?php

namespace App\Http\Controllers\Booking;

use App\Client;
use App\Http\Controllers\Controller;
use App\Booking;
use Illuminate\Http\JsonResponse;

class BookingController extends Controller
{
    public function destroy(Client $client, Booking $booking): JsonResponse
    {
        $this->authorize('destroy', [$booking, $client]);

        return response()->json(
            $booking->delete()
        );
    }
}
