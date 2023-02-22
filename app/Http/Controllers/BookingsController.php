<?php

namespace App\Http\Controllers;

use App\Booking;
use Illuminate\Http\Request;

class BookingsController extends Controller
{
    public function index()
    {
        $bookings = Booking::all();
        return view('bookings.index', ['bookings' => $bookings]);
    }

    public function show($client)
    {
        $bookings = Booking::where('client_id', $client);  
        return view('clients.show', ['bookings' => $bookings]);
    }

    public function store(Request $request)
    {
        $booking = new Booking;
        $booking->start = $request->get('start');
        $booking->end = $request->get('end');
        $booking->notes = $request->get('notes');
        $booking->save();

        return $booking;
    }
}
