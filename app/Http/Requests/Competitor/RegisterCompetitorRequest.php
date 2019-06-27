<?php

namespace App\Http\Requests\Competitor;

use App\Events\CompetitorSubmitted;
use App\Models\Competitor;
use App\Models\PracticeDay;
use App\Models\User;
use ElCoop\HasFields\Models\Field;
use Illuminate\Foundation\Http\FormRequest;
use Password;
use Str;

class RegisterCompetitorRequest extends FormRequest {
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
			'lastName' => ['required','string','max:255'],
			'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
			'language' => ['required', 'in:en,nl'],
			'sports.*.0' => 'required|exists:sports,id',
			'sports.*.practiceDays' => 'array',
			'sports.*.practiceDays.*' => 'exists:practice_days,id',
			'sports.*.competitionDays' => 'array',
			'sports.*.competitionDays.*' => 'exists:competition_days,id',
			'sports.*' => 'array',
		]);
		$rules['competitor'] = 'required|array';
		$requiredFields = Field::getRequiredFields(Competitor::class);
		$protectedFields = Field::getProtectedFields(Competitor::class);
		$rules = $rules->merge($requiredFields)->merge($protectedFields);
		return $rules->toArray();
	}
	
	public function commit() {
		$competitor = new Competitor;
		$competitor->data = array_filter($this->input('competitor'));
		$competitor->save();
		$user = new User;
		
		$sports = collect();
		foreach ($this->input('sports', []) as $sport => $data) {
			$data = collect($data);
			$sports->put($sport, ['data' => $data->except('practiceDays', 0,'competitionDays')]);
			$competitor->practiceDays()->sync($data->get('practiceDays'));
			$competitor->competitionDays()->sync($data->get('competitionDays'));
		}
		
		$competitor->sports()->sync($sports);
		$user->name = $this->input('name');
		$user->email = $this->input('email');
		$user->language = $this->input('language');
		$user->last_name = $this->input('lastName');
		$user->password = '';
		$competitor->user()->save($user);
		$competitor->save();
		
		event(new CompetitorSubmitted($competitor));
		
		Password::broker()->sendResetLink(
			['email' => $user->email]
		);
	}
}
