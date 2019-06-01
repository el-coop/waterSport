<?php

namespace App\Http\Requests\Competitor;

use App\Models\Competitor;
use App\Models\PracticeDay;
use App\Models\User;
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
		return [
			'name' => ['required', 'string', 'max:255'],
			'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
			'language' => ['required', 'in:en,nl'],
			'sports.*.0' => 'exists:sports,id',
			'sports.*.practiceDay' => 'exists:practice_days,id',
			'sports.*' => 'array'
		];
	}
	
	public function commit() {
		$competitor = new Competitor;
		$competitor->data = [];
		$competitor->save();
		$user = new User;
		
		$sports = collect();
		foreach ($this->input('sports') as $sport => $data) {
			$data = collect($data);
			$competitor->practiceDays()->attach(PracticeDay::find($data->get('practiceDay')), ['sport_id' => $sport]);
			$sports->put($sport, ['data' => $data->except('practiceDay', 0)]);
		}
		$competitor->sports()->sync($sports);
		$user->name = $this->input('name');
		$user->email = $this->input('email');
		$user->language = $this->input('language');
		$user->password = bcrypt(Str::random(18));
		$competitor->user()->save($user);
		
		Password::broker()->sendResetLink(
			['email' => $user->email]
		);
	}
}
