<?php

namespace App\Http\Requests\Admin\Sports;

use Illuminate\Foundation\Http\FormRequest;

class DestroySportRequest extends FormRequest {
	/**
	 * @var \Illuminate\Routing\Route|object|string
	 */
	private $sport;
	
	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @return bool
	 */
	public function authorize() {
		$this->sport = $this->route('sport');
		return $this->user()->can('delete', $this->sport);
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
		$this->sport->delete();
	}
}
