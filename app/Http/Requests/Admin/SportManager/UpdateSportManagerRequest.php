<?php

namespace App\Http\Requests\Admin\SportManager;

use App\Models\Sport;
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
			'name' => 'required|string',
			'lastName' => 'required|string',
			'email' => 'required|email|unique:users,email,' . $this->sportManager->user->id,
			'language' => 'required|in:en,nl',
			'sport' => 'required|exists:sports,id'
		];
	}

	public function commit() {
		if ($this->sportManager->sport->id != $this->input('sport')) {
			$this->sportManager->sport()->dissociate();
			$sport = Sport::find($this->input('sport'));
			$sport->sportManagers()->save($this->sportManager);
		}
		$this->sportManager->user->name = $this->input('name');
		$this->sportManager->user->last_name = $this->input('lastName');
		$this->sportManager->user->email = $this->input('email');
		$this->sportManager->user->language = $this->input('language');
		$this->sportManager->user->save();
		$this->sportManager->load('sport');
		return [
			'id' => $this->sportManager->id,
			'name' => $this->input('name'),
			'last_name' => $this->input('lastName'),
			'email' => $this->input('email'),
			'sport' => $this->sportManager->sport->name
		];
	}
}
