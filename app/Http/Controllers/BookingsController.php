<?php

namespace App\Http\Controllers;

use App\Booking;
use App\Client;
use App\Http\Requests\Booking\IndexRequest;
use Carbon\Carbon;

class BookingsController extends Controller
{
    public function index(Client $client, IndexRequest $request)
    {
        $this->authorize('view', $client);

        $bookings = $client->bookings()
            ->orderBy('created_at', 'desc');

        if ($request->has('time_range')) {
            if ($request->time_range == 'future') {
                $bookings->where('start', '>', Carbon::now());
            } elseif ($request->time_range == 'past') {
                $bookings->where('start', '<', Carbon::now());
            }
        }

        return response()->json([
            'bookings' => $bookings->get()
        ]);
    }

    public function destroy(Client $client, Booking $booking)
    {
        $this->authorize('delete', $booking);

        $booking->delete();

        return 'Deleted';
    }
}
