<?php

namespace App\Http\Requests\Admin\CompetitorExportColumn;

use Illuminate\Foundation\Http\FormRequest;

class DestroyCompetitorExportColumnRequest extends FormRequest {
	private $competitorExportColumn;
	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @return bool
	 */
	public function authorize() {
		$this->competitorExportColumn = $this->route('competitorExportColumn');
		return $this->user()->can('delete', $this->competitorExportColumn);
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
		return $this->competitorExportColumn->delete();
	}
}
