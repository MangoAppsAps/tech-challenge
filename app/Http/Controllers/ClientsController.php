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
            ->with([
                'bookings' => function ($query) {
                    $query->orderBy('start', 'asc');
                }, 
                'journals' => function ($query) {
                    $query->orderBy('date', 'asc');
                }])
            ->first();
            
        if($client != null) {
            foreach($client->bookings as $booking) {
                $booking->readable_start_date = Carbon::parse($booking->start)->isoFormat('dddd D MMMM YYYY, HH:mm');
                $booking->readable_end_date = Carbon::parse($booking->end)->isoFormat('HH:mm');
            }
        } else {
            abort(404);
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

        $client = Client::create([
            'user_id' => $userId,
            'name' => $request->get('name'),
            'email' => $request->get('email'),
            'phone' => $request->get('phone'),
            'address' => $request->get('address'),
            'city' => $request->get('city'),
            'postcode' => $request->get('postcode'),
        ]);

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
