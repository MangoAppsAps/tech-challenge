<?php

namespace App\Http\Requests\Journal;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class IndexJournalRequest extends FormRequest
{
    public function authorize(Request $request): bool
    {
        $client = $request->route('client');

        return $client->user_id === $request->user()->id;
    }

    public function rules(): array
    {
        return [];
    }
}
