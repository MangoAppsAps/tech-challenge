<?php

namespace App\Http\Requests;

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
                'name' => 'required|string|max:190',
                'email' => 'nullable|email',
                'phone' => 'nullable|regex:/^[0-9\+ ]+$/',
                'email_or_phone' => 'required_without_all:email,phone',
            ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Please enter a name.',
            'name.string' => 'Please enter a valid name.',
            'name.max' => 'Please enter a name with less than 190 characters.',
            'email.email' => 'Please enter a valid email address.',
            'phone.regex' => 'A phone number can only contain numbers, spaces and the + sign.',
            'email_or_phone.required_without_all' => 'Please enter either an email address or a phone number.',
        ];
    }
}
