<?php

namespace App\Http\Controllers;

use App\Client;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class ClientsController extends Controller
{
    public function index()
    {
        $userId = Auth::id();
        $clients = Client::where('owned_by', $userId)->get();

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
        // Get the bookings before the client id is used
        $bookings = DB::table('bookings')
            ->where('client_id', $client)
            ->orderBy('created_at', 'desc')
            ->get();

        // Find out client
        $client = DB::table('clients')
            ->where('id', $client)
            ->first();

        /*
         * Could have used with() but Eloquent ends up
         * using two queries anyway. Plus the query builder
         * gives more control and better readability. The
         * query builder is just simple and easy to change.
         */
        $client->bookings = $bookings->toArray();

        foreach($client->bookings as $booking)
        {
            $booking->formattedTime = Carbon::createFromFormat('Y-m-d H:s:i', $booking->start)
                ->format('l d F Y');

            $bookingDuration = Carbon::createFromFormat('Y-m-d H:s:i', $booking->start)
                ->format('H:i');

            $bookingDuration .= ' to ';

            $bookingDuration .= Carbon::createFromFormat('Y-m-d H:s:i', $booking->end)
                ->format('H:i');

            $booking->formattedTime .= " $bookingDuration";
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
        $client->owned_by = Auth::id();
        $client->save();

        return $client;
    }

    public function destroy($client)
    {
        Client::where('id', $client)->delete();

        return 'Deleted';
    }
}
