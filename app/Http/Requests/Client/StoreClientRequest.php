<?php

namespace App\Http\Requests\Client;

use Illuminate\Foundation\Http\FormRequest;

class StoreClientRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /** @return array<string, array<int, string>> */
    public function rules(): array
    {
        return [
            'name' => ['required', 'max:190'],
            'email' => ['nullable', 'required_without:phone', 'email:rfc,dns'],
            'phone' => ['nullable', 'required_without:email', 'regex:/^(?=.*[0-9])[ +0-9]+$/'],
        ];
    }
}
