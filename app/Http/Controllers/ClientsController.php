<?php

namespace App\Http\Controllers;

use App\Booking;
use App\Client;
use App\Http\Requests\FilterBookingRequest;
use App\Http\Requests\StoreClientRequest;
use Carbon\Carbon;

class ClientsController extends Controller
{
    public function index()
    {
        $clients = Client::CurrentUser()->latest()->get();
        return view('clients.index', ['clients' => $clients]);
    }

    public function create()
    {
        return view('clients.create');
    }

    public function show(Client $client)
    {
        $client->load('bookings','journals');

        return view('clients.show', ['client' => $client]);
    }

    public function store(StoreClientRequest $request)
    {
        $request->merge(['user_id' => auth()->id()]);
        $client = Client::create($request->all());
        return $client;
    }

    public function destroy(Client $client)
    {
        $client->delete();
        return 'Deleted';
    }

    public function filterBookings(FilterBookingRequest $request)
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
