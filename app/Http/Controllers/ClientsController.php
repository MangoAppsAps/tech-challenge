<?php

namespace App\Http\Controllers;

use App\Client;
use App\Http\Requests\StoreClientRequest;
use App\User;
use Illuminate\Http\Request;

class ClientsController extends Controller
{
    public function index(Request $request)
    {
        /** @var User $currentUser */
        $currentUser = $request->user();

        /** @var Client[] $clients */
        $clients = $currentUser->clients()->withCount('bookings')->get();

        return view('clients.index', ['clients' => $clients]);
    }

    public function create()
    {
        return view('clients.create');
    }

    public function show(Request $request, Client $client)
    {
        /** @var User $currentUser */
        $currentUser = $request->user();

        $this->validateOwnership($currentUser, $client);

        $client->load(['bookings' => function ($query) {
            $query->orderBy('start', 'desc');
        }]);

        return view('clients.show', ['client' => $client]);
    }

    public function store(StoreClientRequest $request): Client
    {
        /** @var User $currentUser */
        $currentUser = $request->user();

        return $currentUser->clients()->create($request->validated());
    }

    public function destroy(Request $request, Client $client)
    {
        /** @var User $currentUser */
        $currentUser = $request->user();
        $currentUser->clients()
            ->where('id', $client->id)
            ->delete();

        $this->validateOwnership($currentUser, $client);

        return redirect()
            ->route('clients.index')
            ->setStatusCode(303);
    }

    private function validateOwnership(User $currentUser, Client $client): void
    {
        if ($currentUser->clients()->where('id', $client->id)->doesntExist()) {
            abort(403);
        }
    }
}
