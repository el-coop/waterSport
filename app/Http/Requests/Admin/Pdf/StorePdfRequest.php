<?php

namespace App\Http\Requests\Admin\Pdf;

use App\Models\Pdf;
use Illuminate\Foundation\Http\FormRequest;

class StorePdfRequest extends FormRequest {
	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @return bool
	 */
	public function authorize() {
		return $this->user()->can('create', Pdf::class);
	}
	
	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules() {
		return [
			'file' => 'required|file',
			'name' => 'required|string|unique:pdfs',
			'use' => 'required|string|in:registrationEmailPdf,homepagePdf',
		];
	}
	
	public function commit() {
		$path = $this->file('file')->store('public/pdf');
		$pdf = new Pdf;
		$pdf->file = basename($path);
		$pdf->name = $this->input('name');
		$pdf->use = $this->input('use');
		$pdf->save();
		return $pdf;
	}
}
