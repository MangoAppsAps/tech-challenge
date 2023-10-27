<?php

namespace App\Http\Requests;

use App\Client;
use App\Journal;
use Illuminate\Foundation\Http\FormRequest;

class JournalDestroyRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $client_id = intval($this->route('client'));
        $journal_id = intval($this->route('journal'));
        $clients = Client::where('user_id', auth()->user()->id)->pluck('id')->toArray();
        $journals = Journal::where('client_id', $client_id)->pluck('id')->toArray();

        return in_array($client_id, $clients) && in_array($journal_id, $journals);
    }

	/**
	 * Prepare the data for validation.
	 *
	 * @return void
	 */
	protected function prepareForValidation()
	{
		$this->merge([
            'id' => intval($this->route('journal')),
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
            'id' => ['required']
        ];
    }
}
