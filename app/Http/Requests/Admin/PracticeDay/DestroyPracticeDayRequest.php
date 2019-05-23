<?php

namespace App\Http\Requests\Admin\PracticeDay;

use Illuminate\Foundation\Http\FormRequest;

class DestroyPracticeDayRequest extends FormRequest {
	private $practiceDay;
	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @return bool
	 */
	public function authorize() {
		$this->practiceDay = $this->route('practiceDay');
		return $this->user()->can('delete', $this->practiceDay);
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
		$this->practiceDay->delete();
	}
}
