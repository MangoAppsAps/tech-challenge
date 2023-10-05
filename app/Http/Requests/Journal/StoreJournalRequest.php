<?php

namespace App\Http\Requests\Journal;

use App\Journal;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class StoreJournalRequest extends FormRequest
{
    public function authorize(Request $request): bool
    {
        return $request->user()->can('store', [Journal::class, $request->route('client')]);
    }

    /** @return array<string, array<int,string>> */
    public function rules(): array
    {
        return [
            'date' => ['required', 'date'],
            'text' => ['required', 'string'],
        ];
    }
}
