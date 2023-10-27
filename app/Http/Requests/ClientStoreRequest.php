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
	 * Get the validation messages that apply to the request.
	 *
	 * @return array
	 */
	public function messages()
	{
		return [
            // TODO: Implement better messaging with frontend
            // 'email.required_if' => 'Either email or phone is required'
            // 'phone.regex' => 'Phone numbers can only contain digits, spaces, and plusses'
		];
	}

	/**
	 * Prepare the data for validation.
	 *
	 * @return void
	 */
	protected function prepareForValidation()
	{
		$this->merge([
            'user_id' => auth()->user()->id,
		]);
	}

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'user_id'  => ['required'],
            'name'     => ['required', 'max:190'],
            'email'    => ['nullable', 'email', 'required_if:phone,=,null'],
            'phone'    => ['nullable', 'regex:/^[\d\s\+]+$/', 'required_if:email,=,null'], // Only digits, spaces, and pluses
            'address'  => ['nullable'],
            'city'     => ['nullable'],
            'postcode' => ['nullable']
        ];
    }
}
