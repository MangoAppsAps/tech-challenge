<?php

namespace App\Services;

use App\Booking;

class BookingsService
{
    public function deleteBooking(Booking $booking)
    {
        $booking->delete();
    }
}
