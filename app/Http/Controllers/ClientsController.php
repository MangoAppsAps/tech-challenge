<?php

namespace App\Http\Controllers;

use App\Client;
use App\Journal;
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

    public function show(Request $request, $client)
    {
        // Get the bookings before the client id is used
        $bookings = DB::table('bookings')
            ->where('client_id', $client)
            ->orderBy('created_at', 'desc');

        // We only need to set a filter if future or past are selected
        if($bookingFilter = $request->query('bookingFilter'))
        {
            // Safe method to use data from the request and convert to DB operators
            $filters = [
                'future' => '>',
                'past' => '<',
            ];

            $bookings->where('start', $filters[$bookingFilter], Carbon::now());
        }

        $bookings = $bookings->get();

        // We need to use this ID to get the journals later...
        $clientId = $client;

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

        $journals = Journal::where('client_id', $clientId)->get();

        return view('clients.show', ['client' => $client, 'journals' => $journals]);
    }

    public function store(Request $request)
    {
        $validatedClientData = $request->validate([
            'name' => 'required|max:190',
            'email' => 'bail|nullable|required_without:phone|email:rfc,dns',
            'phone' => 'bail|nullable|required_without:email|min:10|regex:/^([0-9\s\-\+\(\)]*)$/',
            'address' => 'required',
            'city' => 'required',
            'postcode' => 'required'
        ]);

        $client = new Client;
        $client->name = $validatedClientData['name'];
        $client->email = $validatedClientData['email'];
        $client->phone = $validatedClientData['phone'];
        $client->address = $validatedClientData['address'];
        $client->city = $validatedClientData['city'];
        $client->postcode = $validatedClientData['postcode'];
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
