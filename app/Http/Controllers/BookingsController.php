<?php

namespace App\Http\Controllers;

use App\Booking;
use App\Client;
use Illuminate\Http\Request;

class BookingsController extends Controller
{
    public function index()
    {
        //
    }

    public function create($clientId)
    {
        $client = Client::where('id', $clientId)->first();

        return view('bookings.create', ['client' => $client]);
    }

    public function show()
    {
        //
    }

    public function store(Request $request, $clientId)
    {
        $booking = new Booking;
        $booking->client_id = $clientId;
        $booking->start = $request->get('start');
        $booking->end = $request->get('end');
        $booking->notes = $request->get('notes');
        $booking->save();

        return $booking;
    }

    public function destroy($clientId, $bookingId)
    {
        Booking::where('id', $bookingId)->delete();

        return 'Deleted';
    }
}
