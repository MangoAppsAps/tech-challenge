<?php

namespace App\Http\Requests;

use App\Client;
use Illuminate\Support\Facades\Log;
use Illuminate\Foundation\Http\FormRequest;

class JournalStoreRequest extends FormRequest
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
	 * Prepare the data for validation.
	 *
	 * @return void
	 */
	protected function prepareForValidation()
	{
		$this->merge([
            'client_id' => intval($this->route('client')),
		]);
	}

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $client_ids = implode(',', Client::where('user_id', auth()->user()->id)->pluck('id')->toArray());
        return [
            'client_id' => ['required', 'in:' . $client_ids],
            'date' => ['required'],
            'text' => ['required', 'min:3'],
        ];
    }
}
