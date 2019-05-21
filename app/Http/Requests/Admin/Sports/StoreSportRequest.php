<?php

namespace App\Http\Requests\Admin\Sports;

use App\Models\Sport;
use Illuminate\Foundation\Http\FormRequest;

class StoreSportRequest extends FormRequest {
	private $sport;
	
	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @return bool
	 */
	public function authorize() {
		if($this->sport = $this->route('sport')){
			return $this->user()->can('update', $this->sport);
		}
		
		$this->sport = new Sport;
		return $this->user()->can('create', Sport::class);
	}
	
	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules() {
		return [
			'name' => 'required|unique:sports',
			'date' => 'required|date'
		];
	}
	
	public function commit() {
		$this->sport->name = $this->input('name');
		$this->sport->date = $this->input('date');
		$this->sport->save();
		
		return $this->sport;
	}
}
