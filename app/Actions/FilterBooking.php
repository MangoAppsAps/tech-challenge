<?php

namespace App\Actions;

use App\Models\Booking;
use Carbon\Carbon;

class FilterBooking
{
    public function execute($request)
    {
        $bookings = Booking::where('client_id', '=', $request['client_id'])->get();

        if ($request['query'] == 'future') {
            return $bookings->where('start', '>', Carbon::now());
        } elseif ($request['query'] == 'past') {
            return $bookings->where('start', '<', Carbon::now());
        } else {
            return $bookings;
        }
    }

}
