<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ClientStoreRequest extends FormRequest
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
            'name' => [
                'required',
                'max:190'
            ],
            'email' => [
                'nullable',
                'required_without:phone',
                'email:rfc,dns',
            ],
            'phone' => [
                'nullable',
                'required_without:email',
                'regex:/^[+]?[ ]*[0-9 ]*$/'
            ]
        ];
    }
}
