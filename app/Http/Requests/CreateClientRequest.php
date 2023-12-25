<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateClientRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|max:190',
            'email' => 'required_without:phone|sometimes|nullable|email:dns|unique:App\User,email',
            'phone' => 'required_without:email|regex:/^[0-9+\s]+$/|min:6',
            'address' => 'sometimes|nullable',
            'city' => 'sometimes|nullable',
            'postcode' => 'sometimes|nullable',
        ];
    }
}
