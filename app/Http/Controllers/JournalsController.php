<?php

namespace App\Http\Controllers;

use App\Client;
use App\Http\Requests\Journal\DestroyJournalRequest;
use App\Http\Requests\Journal\IndexJournalRequest;
use App\Http\Requests\Journal\StoreJournalRequest;
use App\Http\Resources\Journal as JournalResource;
use App\Journal as JournalEloquentModel;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class JournalsController extends Controller
{
    public function index(IndexJournalRequest $request, Client $client): AnonymousResourceCollection
    {
        return JournalResource::collection(
            JournalEloquentModel::where('client_id', $client->id)->get()
        );
    }

    public function store(StoreJournalRequest $request, Client $client): JournalResource
    {
        return new JournalResource(
            JournalEloquentModel::create([
                'client_id' => $client->id,
                'date' => $request->get('date'),
                'text' => $request->get('text'),
            ])
        );
    }

    public function destroy(DestroyJournalRequest $request, Client $client, JournalEloquentModel $journal): JsonResponse
    {
        return response()->json(
            $journal->delete()
        );
    }
}
