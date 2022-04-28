<?php

namespace App\Services;

class JournalService
{
    public function store($request, $client)
    {
        $request->merge(['user_id' => Auth()->id()]);
        $client->journals()->create($request->all());

        return "created successfully";
    }

    public function destroy($journal)
    {
        $journal->delete();
        return 'deleted successfully';
    }

}
