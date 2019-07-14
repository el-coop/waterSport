<?php

namespace App\Http\Requests\Admin\CompetitorExportColumn;

use App\Models\CompetitorExportColumn;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateCompetitorExportColumnRequest extends FormRequest {

	private $competitorExportColumn;
	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @return bool
	 */
	public function authorize() {
		$this->competitorExportColumn = $this->route('competitorExportColumn');
		return $this->user()->can('update', $this->competitorExportColumn);
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
		$this->competitorExportColumn->name = $this->input('name');
		$this->competitorExportColumn->column = $this->input('column');
		$this->competitorExportColumn->save();
		return [
			'id' => $this->competitorExportColumn->id,
			'name' => $this->input('name'),
			'column' => $this->input('column')
		];
	}
}
