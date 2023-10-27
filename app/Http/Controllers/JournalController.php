<?php

namespace App\Http\Controllers;

use App\Http\Requests\JournalDestroyRequest;
use App\Http\Requests\JournalStoreRequest;
use App\Journal;

class JournalController extends Controller
{
    public function store(JournalStoreRequest $request)
    {
        return Journal::create($request->validated());
    }

    public function destroy(JournalDestroyRequest $request)
    {
        return Journal::where('id', $request->id)->delete();
    }
}
