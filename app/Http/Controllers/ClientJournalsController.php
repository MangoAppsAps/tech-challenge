<?php

namespace App\Http\Controllers;

use App\Client;
use App\Http\Requests\JournalStoreRequest;
use App\Http\Resources\JournalResource;
use App\Journal;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;

class ClientJournalsController extends Controller
{
    public function index(Client $client): JsonResource
    {
        $this->authorize('view', [Journal::class, $client]);

        $journals = $client->journals()->latest()->paginate();

        return JournalResource::collection($journals);
    }

    public function store(Client $client, JournalStoreRequest $request): JsonResource
    {
        return JournalResource::make(
            Journal::create([
                'client_id' => $client->getKey(),
                'date' => $request->input('date'),
                'content' => $request->input('content'),
            ])
        );
    }

    public function destroy(Client $client, Journal $journal): JsonResponse
    {
        $this->authorize('delete', $journal);

        $journal->delete();

        return response()->json();
    }
}
