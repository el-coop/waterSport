<?php

namespace App\Http\Requests\Admin\Competitor;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCompetitorRequest extends FormRequest {
	private $competitor;
	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @return bool
	 */
	public function authorize() {
		$this->competitor = $this->route('competitor');
		return $this->user()->can('update', $this->competitor);
	}

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules() {
		return [
			'name' => 'required|string',
			'email' => 'required|email|unique:users,email,' . $this->competitor->user->id,
			'language' => 'required|in:en,nl'
			];
	}

	public function commit() {
		$this->competitor->user->name = $this->input('name');
		$this->competitor->user->email = $this->input('email');
		$this->competitor->user->language = $this->input('language');
		$this->competitor->user->save();
		$this->competitor->save();
		return [
			'id' => $this->competitor->id,
			'name' => $this->competitor->user->name,
			'email' => $this->competitor->user->email,
			'sportsList' => $this->competitor->sportsList
		];
	}
}
