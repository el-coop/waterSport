<?php

namespace App\Http\Requests\Admin\CompetitionDay;

use App\Models\CompetitionDay;
use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;

class StoreCompetitionDayRequest extends FormRequest {
	private $sport;
	private $competitionDay;

	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @return bool
	 */
	public function authorize() {
		$this->sport = $this->route('sport');
		if ($this->competitionDay = $this->route('competitionDay')) {
			return $this->user()->can('update', $this->competitionDay);
		}

		$this->competitionDay = new CompetitionDay();
		return $this->user()->can('create', CompetitionDay::class);
	}

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules() {
		return [
			'date' => 'required|date',
			'time' => 'required|date_format:H:i',
		];
	}

	public function commit() {
		$this->competitionDay->date_time = Carbon::createFromFormat('Y-m-d H:i',$this->input('date') . ' ' .$this->input('time'));
		$this->sport->competitionDays()->save($this->competitionDay);

		return $this->competitionDay;
	}
}
