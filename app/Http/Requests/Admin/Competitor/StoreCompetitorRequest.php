<?php

namespace App\Http\Requests\Admin\Competitor;

use App\Models\Competitor;
use App\Models\User;
use Str;
use Password;
use Illuminate\Foundation\Http\FormRequest;

class StoreCompetitorRequest extends FormRequest {
	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @return bool
	 */
	public function authorize() {
		return $this->user()->can('create', Competitor::class);
	}

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules() {
		return [
			'name' => 'required|string',
			'email' => 'required|email|unique:users',
			'language' => 'required|in:en,nl',
		];
	}

	public function commit() {
		$competitor = new Competitor;
		$user = New User;
		$user->name = $this->input('name');
		$user->email = $this->input('email');
		$user->language = $this->input('language');
		$user->password = '';
		$competitor->save();
		$competitor->user()->save($user);
		Password::broker()->sendResetLink(
			['email' => $user->email]
		);
		return [
			'id' => $competitor->id,
			'name' => $this->input('name'),
			'email' => $this->input('email'),
			'sportsList' => ''
		];
	}
}
