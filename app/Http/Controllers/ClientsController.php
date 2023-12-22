<?php

namespace App\Http\Controllers;

use App\Client;
use Carbon\Carbon;
use Illuminate\Http\Request;

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
        $client = Client::where('id', $client)
            ->with('bookings')
            ->first();

        if($client != null) {
            foreach($client->bookings as $booking) {
                $booking->readable_start_date = Carbon::parse($booking->start)->isoFormat('dddd D MMMM YYYY, HH:mm');
                $booking->readable_end_date = Carbon::parse($booking->end)->isoFormat('HH:mm');
            }
        }
        
        return view('clients.show', ['client' => $client]);
    }

    public function store(Request $request)
    {
        $client = new Client;
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
