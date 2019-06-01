<?php

namespace App\Http\Requests\Admin\Competitor;

use Illuminate\Foundation\Http\FormRequest;

class DestroyCompetitorRequest extends FormRequest {
	private $competitor;
	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @return bool
	 */
	public function authorize() {
		$this->competitor = $this->route('competitor');
		return $this->user()->can('delete', $this->competitor);
	}

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules() {
		return [
			//
		];
	}

	public function commit() {
		$this->competitor->delete();
	}
}
