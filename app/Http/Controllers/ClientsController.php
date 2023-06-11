<?php

namespace App\Http\Controllers;

use App\Client;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Http\Request;

class ClientsController extends Controller
{
    public function index()
    {
        $clients = Client::where('created_by', '=', auth()->id())->get();

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
            ->where('created_by', '=', auth()->id())
            ->with('bookings', function(HasMany $innerQuery) {
                $innerQuery->orderBy('start', 'desc');
            })
            ->first();

        if ($client === null) {
            throw new AuthorizationException();
        }

        return view('clients.show', ['client' => $client]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:190',
            'email' => 'required_without:phone|email',
            'phone' => 'required_without:email|nullable|regex:/^\+?[0-9\s]+$/',
        ]);

        $client = new Client;
        $client->created_by = auth()->id();
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
        $client = Client::where('id', $client)
            ->where('created_by', '=', auth()->id())
            ->first();

        if ($client === null) {
            throw new AuthorizationException();
        }

        $client->delete();

        return 'Deleted';
    }
}
