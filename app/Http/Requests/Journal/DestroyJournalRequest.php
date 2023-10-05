<?php

namespace App\Http\Requests\Journal;

use App\Client;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class DestroyJournalRequest extends FormRequest
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
