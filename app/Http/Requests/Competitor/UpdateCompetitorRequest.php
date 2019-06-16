<?php

namespace App\Http\Requests\Competitor;

use App\Events\CompetitorSubmitted;
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
		$user = $this->user();
		if ($this->route('competitor')) {
			$user = $this->route('competitor')->user;
		}
		
		$rules = collect([
			'name' => ['required', 'string', 'max:255'],
			'lastName' => ['required','string','max:255'],
			'email' => ['required', 'string', 'email', 'max:255', "unique:users,email," . $user->id],
			'language' => ['required', 'in:en,nl'],
			'sports.*.0' => 'required|exists:sports,id',
			'sports.*.practiceDays' => 'array',
			'sports.*.practiceDays.*' => 'exists:practice_days,id',
			'sports.*' => 'array',
		]);
		
		$rules['competitor'] = 'required|array';
		$requiredFields = Field::getRequiredFields(Competitor::class);
		$protectedFields = Field::getProtectedFields(Competitor::class);
		$rules = $rules->merge($requiredFields)->merge($protectedFields);
		return $rules->toArray();
	}
	
	public function commit() {
		$user = $this->user();
		if ($this->route('competitor')) {
			$user = $this->route('competitor')->user;
		}
		
		$user->name = $this->input('name');
		$user->last_name = $this->input('lastName');
		$user->email = $this->input('email');
		$user->language = $this->input('language');
		$sports = collect();
		$user->user->practiceDays()->detach();
		foreach ($this->input('sports', []) as $sport => $data) {
			$data = collect($data);
			$sports->put($sport, ['data' => $data->except('practiceDays', 0)]);
			$user->user->practiceDays()->attach($data->get('practiceDays'));
		}
		$user->user->sports()->sync($sports);
		$user->user->data = array_filter($this->input('competitor'));
		
		event(new CompetitorSubmitted($user->user));
		$this->session()->flash('fireworks', true);
		
		$user->user->save();
		$user->save();
	}
}
