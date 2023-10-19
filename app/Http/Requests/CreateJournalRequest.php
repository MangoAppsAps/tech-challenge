<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateJournalRequest extends FormRequest
{
    public function rules()
    {
        return [
            'date' => ['required', 'date'],
            'description' => ['required']
        ];
    }
}
