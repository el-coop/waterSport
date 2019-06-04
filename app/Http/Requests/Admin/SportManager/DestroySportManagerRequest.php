<?php

namespace App\Http\Requests\Admin\SportManager;

use Illuminate\Foundation\Http\FormRequest;

class DestroySportManagerRequest extends FormRequest {
	private $sportManager;
	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @return bool
	 */
	public function authorize() {
		$this->sportManager = $this->route('sportManager');
		return $this->user()->can('delete', $this->sportManager);
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
		$this->sportManager->delete();
	}
}
