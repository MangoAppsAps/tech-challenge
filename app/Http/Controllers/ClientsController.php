<?php

namespace App\Http\Controllers;

use App\Client;
use App\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\StoreRequest;
use App\Journal;
use Carbon\Carbon;

class ClientsController extends Controller
{
    public function index()
    {
        $clients = Client::all();

        foreach ($clients as $client) {
            $client->append('bookings_count');
        }

        return view('clients.index', ['clients' => $clients]);
    }

    public function create()
    {
        return view('clients.create');
    }

    public function show($client)
    {
        $client = Client::where('id', $client)->first();

        $bookings = $client->bookings;

        $journals = $client->journals;

        foreach ($bookings as $booking) {
            $booking->append('formatted_time_range');
        }


        foreach ($journals as $journal) {
            $journal->append('formatted_date');
        }


        return view('clients.show', [
            'client' => $client, 
            'bookings' => $bookings, 
            'journals' => $journals,
            ]
        );
    }

    public function store(StoreRequest $request)
    {

        $validated = $request->validated();

        $client = new Client;
        $client->user_id = auth()->user()->id;
        $client->name = $request->get('name');
        $client->email = $request->get('email');
        $client->phone = $request->get('phone');
        $client->address = $request->get('address');
        $client->city = $request->get('city');
        $client->postcode = $request->get('postcode');
        $client->save();

        return $client;
    }

    public function destroy($client)
    {
        Client::where('id', $client)->delete();

        return 'Deleted';
    }
}
