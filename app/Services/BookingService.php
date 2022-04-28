<?php

namespace App\Services;

class BookingService
{
    public function destroy($booking)
    {
        $booking->delete();
        return "Deleted successfully";

    }


}
