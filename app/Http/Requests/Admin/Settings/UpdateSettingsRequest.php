<?php

namespace App\Http\Requests\Admin\Settings;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Http\FormRequest;

class UpdateSettingsRequest extends FormRequest {
	private $fields;
	private $settings;

	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @return bool
	 */
	public function authorize() {
		return Gate::allows('update-settings');
	}

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules() {
		$this->settings = app('settings');
		$this->fields = array_keys($this->settings->all());

		$rules = [];
		foreach ($this->fields as $field) {
			$rules[$field] = 'required|string';
		};
		return $rules;
	}

	public function commit() {
		foreach ($this->fields as $field) {
			$value = $this->input($field);
			$this->settings->put($field, $value);
		}
	}
}
