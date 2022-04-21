<?php
namespace App\Services;

use App\Models\Client;
use Carbon\Carbon;

class ClientService
{
    /**
     * Store client
     *
     * @param $request
     * @return Client
     */
    public function store($request): Client
    {
        $client = new Client();
        $client->fill($request->all());
        $client->save();

        return $client;
    }

    /**
     * Show client
     *
     * @param $request
     * @param $client
     * @return Client
     */
    public function show($request, $client)
    {
        $client = $client->load(['bookings' => function($q) use ($request) {
            if (in_array($request->filter, ['future', 'past'])) {
                $operator = match ($request->filter) {
                    'future' => '>',
                    'past' => '<',
                };

                $q->where('start', $operator, Carbon::now());
            }
        }, 'journals']);

        return $client;
    }

    /**
     * Update client
     *
     * @param $request
     * @param $client
     * @return Client
     */
    public function update($request, $client): Client
    {
        $client->fill($request->all());
        $client->save();

        return $client;
    }

    public function createJournal($request) {
        $client = Client::find($request->client_id);
        $journal = $client->journals()->make();
        $journal->fill([
            'journal_date' => Carbon::now(),
            'journal_content' => $request->journal_content
        ]);
        $journal->save();

        return $client;
    }
}
