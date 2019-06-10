<?php

namespace App\Http\Requests\Admin\Pdf;

use Illuminate\Foundation\Http\FormRequest;

class DestroyPdfRequest extends FormRequest {
	protected $pdf;

	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @return bool
	 */

	public function authorize() {
		$this->pdf = $this->route('pdf');
		return $this->user()->can('delete', $this->pdf);
	}

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules() {
		return [
		];
	}

	public function commit() {
		$this->pdf->delete();
	}
}
