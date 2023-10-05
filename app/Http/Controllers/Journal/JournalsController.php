<?php

namespace App\Http\Controllers\Journal;

use App\Client;
use App\Http\Controllers\Controller;
use App\Http\Requests\Journal\StoreJournalRequest;
use App\Http\Resources\Journal as JournalResource;
use App\Journal;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class JournalsController extends Controller
{
    public function index(Client $client): AnonymousResourceCollection
    {
        $this->authorize('viewAny', [Journal::class, $client]);

        return JournalResource::collection(
            $client->journals
        );
    }

    public function store(StoreJournalRequest $request, Client $client): JournalResource
    {
        return new JournalResource(
            Journal::create([
                'client_id' => $client->id,
                'date' => $request->get('date'),
                'text' => $request->get('text'),
            ])
        );
    }

    public function destroy(Client $client, Journal $journal): JsonResponse
    {
        $this->authorize('destroy', [$journal, $client]);

        return response()->json(
            $journal->delete()
        );
    }
}
