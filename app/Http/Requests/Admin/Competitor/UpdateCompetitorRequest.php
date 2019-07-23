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
			'lastName' => 'required|string',
			'email' => 'required|email|unique:users,email,' . $this->competitor->user->id,
			'language' => 'required|in:en,nl',
			'competitor' => 'required|array'
		];
	}

	public function commit() {
		$this->competitor->user->name = $this->input('name');
		$this->competitor->user->last_name = $this->input('lastName');
		$this->competitor->user->email = $this->input('email');
		$this->competitor->user->language = $this->input('language');
		$this->competitor->data = array_filter($this->input('competitor'));
		if ($this->input('sports')){
			foreach ($this->input('sports') as $sportId => $sportData) {
				$this->competitor->sports()->updateExistingPivot($sportId, ['data' => $sportData]);
			}
		}
		$this->competitor->user->save();
		$this->competitor->save();
		return [
			'id' => $this->competitor->id,
			'name' => $this->competitor->user->name,
			'last_name' => $this->competitor->user->last_name,
			'email' => $this->competitor->user->email,
			'sportsList' => $this->competitor->sportsList
		];
	}
}
