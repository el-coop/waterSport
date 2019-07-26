<?php

namespace App\Http\Requests\Admin\CompetitorExportColumn;

use App\Models\Admin;
use App\Models\CompetitorExportColumn;
use Illuminate\Foundation\Http\FormRequest;

class ExportSportByDateRequest extends FormRequest {
	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @return bool
	 */
	public function authorize() {
		return $this->user()->can('create', CompetitorExportColumn::class);
	}

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules() {
		if ($this->input('dateType') == 0){
			$class = 'competition_days';
		} else {
			$class = 'practice_days';
		}
		return [
			'sport' => 'required|exists:sports,id',
			'dateType' => 'required|in:0,1',
			'date' => 'required|exists:' . $class . ',id'

		];
	}
}
