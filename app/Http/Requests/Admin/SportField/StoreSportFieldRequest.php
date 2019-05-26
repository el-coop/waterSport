<?php

namespace App\Http\Requests\Admin\SportField;

use App\Models\SportField;
use Illuminate\Foundation\Http\FormRequest;

class StoreSportFieldRequest extends FormRequest {
	private $sport;
	private $sportField;

	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @return bool
	 */
	public function authorize() {
		$this->sport = $this->route('sport');
		if ($this->sportField = $this->route('sportField')) {
			return $this->user()->can('update', $this->sportField);
		}

		$this->sportField = new SportField();
		return $this->user()->can('create', SportField::class);
	}

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules() {
		return [
			'name_en' => 'required|string',
			'name_nl' => 'required|string',
			'type' => 'required|string|in:text,textarea,checkbox',
			'placeholder_en' => 'required|string',
			'placeholder_nl' => 'required|string'
		];
	}

	public function commit() {
		$this->sportField->name_en = $this->input('name_en');
		$this->sportField->name_nl = $this->input('name_nl');
		$this->sportField->placeholder_en = $this->input('placeholder_en');
		$this->sportField->placeholder_nl = $this->input('placeholder_nl');
		$this->sportField->type = $this->input('type');
		$this->sport->fields()->save($this->sportField);
		return $this->sportField;
	}
}
