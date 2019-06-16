<?php

namespace App\Http\Requests\Admin\SportManager;

use App\Models\Sport;
use App\Models\SportManager;
use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Password;

class StoreSportManagerRequest extends FormRequest {
	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @return bool
	 */
	public function authorize() {
		return $this->user()->can('create', SportManager::class);
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
			'email' => 'required|email|unique:users',
			'language' => 'required|in:en,nl',
			'sport' => 'required|exists:sports,id'
		];
	}

	public function commit() {
		$sportManager = new SportManager;
		$sport = Sport::find($this->input('sport'));
		$sport->sportManagers()->save($sportManager);
		$user = new User;
		$user->name = $this->input('name');
		$user->last_name = $this->input('lastName');
		$user->email = $this->input('email');
		$user->language = $this->input('language');
		$user->password = '';
		$sportManager->user()->save($user);
		Password::broker()->sendResetLink(
			['email' => $user->email]
		);
		return [
			'id' => $sportManager->id,
			'name' => $this->input('name'),
			'last_name' => $this->input('lastName'),
			'email' => $this->input('email'),
			'sport' => $sport->name
		];
	}
}
