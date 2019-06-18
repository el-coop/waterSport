<?php

namespace App\Http\Requests\SportManager;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSportManagerRequest extends FormRequest {
	private $sportManager;
	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @return bool
	 */
	public function authorize() {
		$this->sportManager = $this->route('sportManager');
		return $this->user()->can('update', $this->sportManager);
	}

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules() {
		return [
			'name' => ['required', 'string', 'max:255'],
			'lastName' => ['required','string','max:255'],
			'email' => ['required', 'string', 'email', 'max:255', "unique:users,email," . $this->sportManager->user->id],
			'language' => ['required', 'in:en,nl'],
		];
	}

	public function commit() {
		$this->sportManager->user->name = $this->input('name');
		$this->sportManager->user->last_name = $this->input('lastName');
		$this->sportManager->user->email = $this->input('email');
		$this->sportManager->user->language = $this->input('language');
		$this->sportManager->user->save();
	}
}
