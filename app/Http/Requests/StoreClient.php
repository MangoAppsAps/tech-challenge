<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreClient extends FormRequest
{
    public function rules()
    {
        return [
            'name' => 'required|max:190',
            'email' => 'sometimes|nullable|email',
            'phone' => 'sometimes|nullable|regex:/^[0-9+ ]+$/i',
            'address' => '',
            'city' => '',
            'postcode' => '',
        ];
    }
}
