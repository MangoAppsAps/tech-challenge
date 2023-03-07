<?php

namespace App\Http\Controllers;

use App\Client;
use Illuminate\Http\Request;

class ClientsController extends Controller
{
    public function index()
    {
        $clients = Client::where('user_id', auth()->user()->id)->get();

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
        $client->bookings = $client->bookings()->get();

        return view('clients.show', ['client' => $client]);
    }

    public function store(Request $request)
    {

        //Validate the client before actually saving them
        $request->validate([
            'name' => "required|max:190",
            'email' => "nullable|required_without:phone|email",
            'phone' => "nullable|required_without:email|regex:/^\+?[\d\s]*$/" //A non regex solution is probably safer
        ]);

        $client = new Client;
        $client->name = $request->get('name');
        $client->email = $request->get('email');
        $client->phone = $request->get('phone');
        $client->address = $request->get('address');
        $client->city = $request->get('city');
        $client->postcode = $request->get('postcode');
        $client->user_id = auth()->user()->id;
        $client->save();

        return $client;
    }

    public function destroy($client)
    {
        Client::where('id', $client)->delete();

        return 'Deleted';
    }
}
