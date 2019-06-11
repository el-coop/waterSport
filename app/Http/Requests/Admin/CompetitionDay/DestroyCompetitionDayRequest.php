<?php

namespace App\Http\Requests\Admin\CompetitionDay;

use Illuminate\Foundation\Http\FormRequest;

class DestroyCompetitionDayRequest extends FormRequest {
	private $competitionDay;
	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @return bool
	 */
	public function authorize() {
		$this->competitionDay = $this->route('competitionDay');
		return $this->user()->can('delete', $this->competitionDay);
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
		$this->competitionDay->delete();
	}
}
