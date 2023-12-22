<?php

namespace App\Http\Controllers;

use App\Client;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ClientsController extends Controller
{
    public function index()
    {
        $userId = auth()->id();

        $clients = Client::where('user_id', $userId)
            ->get();

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
        $userId = auth()->id();
        $client = Client::where([
                ['id', $client],
                ['user_id', $userId]
            ])
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
        $request->validate([
            'name' => 'required|string|max:190',
            'email' => 'nullable|email',
            'phone' => 'nullable|regex:/^[0-9\s+]+$/',
            'phone' => 'required_without:email',
            'email' => 'required_without:phone',
        ], [
            'phone.regex' => 'The phone can only contain digits, spaces and a plus sign.',
        ]);

        $userId = auth()->id();
        $client = new Client;
        $client->user_id = $userId;
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
        $userId = auth()->id();
        Client::where([
            ['id', $client],
            ['user_id', $userId]
        ])->delete();

        return 'Deleted';
    }
}
