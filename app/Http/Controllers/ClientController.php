<?php

namespace App\Http\Controllers;

use App\Http\Requests\ClientRequest;
use App\Http\Requests\JournalRequest;
use App\Http\Resources\ClientCollection;
use App\Http\Resources\ClientResource;
use App\Models\Booking;
use App\Models\Client;
use App\Models\Journal;
use App\Services\ClientService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Traits\RespondsWithHttpStatus;

class ClientController extends Controller
{

    use RespondsWithHttpStatus;

    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        return $this->success('', new ClientCollection(Client::withCount('bookings')->get()));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  ClientRequest  $request
     * @param  ClientService $clientService
     * @return JsonResponse
     */
    public function store(ClientRequest $request, ClientService $clientService): JsonResponse
    {
        $client = $clientService->store($request);

        return $this->success('', new ClientResource($client), 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  Client $client
     * @param  ClientService $clientService
     * @return JsonResponse
     */
    public function show(Request $request, Client $client, ClientService $clientService): JsonResponse
    {
        $client = $clientService->show($request, $client);

        return $this->success('', new ClientResource($client));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  ClientRequest $request
     * @param  Client $client
     * @param  ClientService $clientService
     * @return JsonResponse
     */
    public function update(ClientRequest $request, Client $client, ClientService $clientService): JsonResponse
    {
        $client = $clientService->update($request, $client);

        return $this->success('', new ClientResource($client));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Client $client
     * @return JsonResponse
     */
    public function destroy(Client $client): JsonResponse
    {
        $client->delete();

        return $this->success('Record deleted');
    }

    /**
     * Delete a booking
     *
     * @param Booking $booking
     * @return JsonResponse
     */
    public function deleteBooking(Booking $booking): JsonResponse
    {
        $booking->delete();

        return $this->success('Record deleted');
    }

    /**
     * Store a journal
     *
     * @param JournalRequest $request
     * @param ClientService $clientService
     * @return JsonResponse
     */
    public function createJournal(JournalRequest $request, ClientService $clientService): JsonResponse
    {
        $client = $clientService->createJournal($request);

        return $this->success('', new ClientResource($client->load('bookings', 'journals')), 201);
    }

    /**
     * Delete a journal
     *
     * @param Journal $journal
     * @return JsonResponse
     */
    public function deleteJournal(Journal $journal): JsonResponse
    {
        $journal->delete();

        return $this->success('Record deleted');
    }
}
