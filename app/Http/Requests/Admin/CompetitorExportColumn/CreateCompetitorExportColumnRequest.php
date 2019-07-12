<?php

namespace App\Http\Requests\Admin\CompetitorExportColumn;

use App\Models\CompetitorExportColumn;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CreateCompetitorExportColumnRequest extends FormRequest {
	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @return bool
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
		$columnOptions = array_keys(CompetitorExportColumn::options()->toArray());
		return [
			'column' => ['required', 'string', Rule::in($columnOptions)],
			'name' => 'required|string'
		];
	}

	public function commit() {
		$competitorExportColumn = new CompetitorExportColumn;
		$competitorExportColumn->column = $this->input('column');
		$competitorExportColumn->name = $this->input('name');
		$competitorExportColumn->order = CompetitorExportColumn::count();
		$competitorExportColumn->save();
		return [
			'id' => $competitorExportColumn->id,
			'column' => $competitorExportColumn->column,
			'name' => $competitorExportColumn->name
		];
	}
}
