<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreClientRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => 'required|max:190',
            'email' => 'required_without:phone|sometimes|nullable|email:rfc,dns|max:190',
            'phone' => 'required_without:email|sometimes|nullable|regex:/^([0-9\s\+]*)$/|min:10',
            'address' => 'string',
            'city' => 'string',
            'postcode' => 'string',
        ];
    }
}
