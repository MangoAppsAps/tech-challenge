<?php

namespace App\Http\Controllers;

use App\Booking;
use App\Client;
use Illuminate\Support\Facades\Gate;

class BookingsController extends Controller
{

    public function destroy(Client $client, Booking $booking)
    {
        if (!Gate::allows('delete-booking', $booking)) {
            abort(403);
        }

        $booking->delete();

        return 'Success';
    }
}
