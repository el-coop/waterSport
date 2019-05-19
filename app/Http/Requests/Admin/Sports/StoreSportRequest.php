<?php

namespace App\Http\Requests\Admin\Sports;

use App\Models\Sport;
use Illuminate\Foundation\Http\FormRequest;

class StoreSportRequest extends FormRequest {
	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @return bool
	 */
	public function authorize() {
		return $this->user()->can('create', Sport::class);
	}
	
	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules() {
		return [
			'name' => 'required|unique:sports'
		];
	}
	
	public function commit() {
		$sport = new Sport;
		$sport->name = $this->input('name');
		$sport->save();
		
		return $sport;
	}
}
