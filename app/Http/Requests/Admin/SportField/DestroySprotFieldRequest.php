<?php

namespace App\Http\Requests\Admin\SportField;

use Illuminate\Foundation\Http\FormRequest;

class DestroySprotFieldRequest extends FormRequest {

	private $sportField;
	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @return bool
	 */
	public function authorize() {
		$this->sportField = $this->route('sportField');
		return $this->user()->can('delete', $this->sportField);
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
		$this->sportField->delete();
	}
}
