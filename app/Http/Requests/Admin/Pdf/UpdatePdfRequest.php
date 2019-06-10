<?php

namespace App\Http\Requests\Admin\Pdf;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePdfRequest extends FormRequest {
	protected $pdf;
	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @return bool
	 */
	public function authorize() {
		$this->pdf = $this->route('pdf');
		return $this->user()->can('update', $this->pdf);
	}

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules() {
		return [
			'name' => 'required|string|unique:pdfs,name,' . $this->pdf->id,
		];
	}

	public function commit() {
		$this->pdf->name = $this->input('name');
		$this->pdf->save();
		return $this->pdf;
	}
}
