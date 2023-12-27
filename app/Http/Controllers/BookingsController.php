<?php

namespace App\Http\Controllers;

use App\Client;
use App\Booking;
use App\Services\BookingsService;

class BookingsController extends Controller
{
    protected $bookingsService;

    public function __construct(BookingsService $bookingsService)
    {
        $this->bookingsService = $bookingsService;
    }

    public function destroy(Client $client, Booking $booking)
    {
        $this->bookingsService->deleteBooking($booking);

        return response()->json([]);
    }
}
