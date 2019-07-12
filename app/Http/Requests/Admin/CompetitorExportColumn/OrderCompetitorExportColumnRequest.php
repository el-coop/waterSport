<?php

namespace App\Http\Requests\Admin\CompetitorExportColumn;

use App\Models\CompetitorExportColumn;
use Illuminate\Foundation\Http\FormRequest;

class OrderCompetitorExportColumnRequest extends FormRequest {
	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @return bool
	 */
	public function authorize() {
		return $this->user()->can('order', CompetitorExportColumn::class);
	}

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules() {
		return [
			'order' => 'required|array'
		];
	}

	public function commit() {
		$newOrder = $this->input('order');
		for ($i = 1; $i <= count($newOrder); $i++) {
			$BandPaymentColumn = CompetitorExportColumn::find($newOrder[$i - 1]);
			$BandPaymentColumn->order = $i;
			$BandPaymentColumn->save();
		}
	}
}
