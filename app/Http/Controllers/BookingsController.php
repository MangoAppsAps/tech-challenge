<?php

namespace App\Http\Controllers;

use App\Client;
use App\Booking;
use Illuminate\Http\Request;

class BookingsController extends Controller
{
    public function destroy(Client $client, Booking $booking)
    {
        $booking->delete();

        return response()->json([]);
    }
}
