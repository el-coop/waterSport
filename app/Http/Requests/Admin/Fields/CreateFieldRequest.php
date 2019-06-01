<?php

namespace App\Http\Requests\Admin\Fields;


use App\Models\Competitor;
use App\Models\Sport;
use ElCoop\HasFields\Models\Field;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CreateFieldRequest extends FormRequest {
	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @return bool
	 */
	public function authorize() {
		return $this->user()->can('create', Field::class);
	}
	
	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules() {
		return [
			'name_en' => 'required|string|' . Rule::unique('fields')->where('form', $this->input('form')),
			'type' => 'required|string|in:text,textarea,checkbox',
			'form' => 'required|string|in:' . Competitor::class . ',' . Sport::class,
			'options' => 'required_if:type,checkbox|array',
			'status' => 'required|string|in:protected,required,encrypted,none',
			'name_nl' => 'required|string|' . Rule::unique('fields')->where('form', $this->input('form')),
			'placeholder_nl' => 'nullable|string',
			'placeholder_en' => 'nullable|string'
		];
	}
	
	public function commit() {
		$field = new Field;
		$field->form = $this->input('form');
		$field->name_en = $this->input('name_en');
		$field->type = $this->input('type');
		$field->name_nl = $this->input('name_nl');
		$field->status = $this->input('status');
		$field->placeholder_nl = $this->input('placeholder_nl');
		$field->placeholder_en = $this->input('placeholder_en');
		switch ($this->input('form')) {
			case Sport::class:
				$field->order = Sport::getLastFieldOrder() + 1;
				break;
			case Competitor::class:
				$field->order = Competitor::getLastFieldOrder() + 1;
				break;
		}
		if ($field->type == 'checkbox') {
			$field->options = $this->input('options');
		}
		$field->save();
		return $field;
	}
}
