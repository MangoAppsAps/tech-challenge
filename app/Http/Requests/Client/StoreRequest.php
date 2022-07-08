<?php

namespace App\Http\Requests\Client;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|max:190',
            'email' => 'nullable|required_without:phone|email:rfc,dns',
            'phone' => 'nullable|required_without:email|min:10|regex:/^(?:\s*\+)?[\d\s\.\-]+$/',
            'address' => 'required|max:255',
            'city' => 'required|max:255',
            'postcode' => 'required|numeric'
        ];
    }
}
