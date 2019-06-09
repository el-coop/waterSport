<?php

namespace App\Http\Requests\Competitor;

use App\Models\Competitor;
use ElCoop\HasFields\Models\Field;
use Illuminate\Foundation\Http\FormRequest;

class UpdateCompetitorRequest extends FormRequest {
	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @return bool
	 */
	public function authorize() {
		return true;
	}
	
	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules() {
		$rules = collect([
			'name' => ['required', 'string', 'max:255'],
			'email' => ['required', 'string', 'email', 'max:255', "unique:users,email," . $this->user()->id],
			'language' => ['required', 'in:en,nl'],
			'sports.*.0' => 'required|exists:sports,id',
		 	'sports.*.practiceDay' => 'required|exists:practice_days,id',
			'sports.*' => 'array',
			'competitor' => 'required|array',
		]);
		if ($this->input('validate')){
			$requiredFields = Field::getRequiredFields(Competitor::class);
			$protectedFields = Field::getProtectedFields(Competitor::class);
			$rules = $rules->merge($requiredFields)->merge($protectedFields);
		}
		return $rules->toArray();
	}
	
	public function commit() {
		$user = $this->user();
		
		$user->name = $this->input('name');
		$user->email = $this->input('email');
		$user->language = $this->input('language');
		$sports = collect();
		foreach ($this->input('sports',[]) as $sport => $data) {
			$data = collect($data);
			$sports->put($sport, ['data' => $data->except('practiceDay', 0), 'practice_day_id' => $data->get('practiceDay')]);
		}
		$user->user->sports()->sync($sports);
		$user->user->data = array_filter($this->input('competitor'));
		$user->user->save();
		$user->save();
	}
}
