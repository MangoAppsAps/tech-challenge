<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateClientRequest extends FormRequest
{
    public function rules()
    {
        return [
            'name' => ['required', 'max:190'],
            'email' => ['sometimes', 'nullable', 'email:rfc,dns', 'required_without:phone'],
            'phone' => ['sometimes', 'nullable', 'regex:/^(?=.*[0-9])[- +()0-9]+$/', 'required_without:email'],
            'address' => [],
            'city' => [],
            'postcode' => []
        ];
    }
}
