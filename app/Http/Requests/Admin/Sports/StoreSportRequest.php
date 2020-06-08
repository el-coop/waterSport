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
		$nameRule = 'required|unique:sports';
		if ($this->sport->name){
			$nameRule .= ',name,' . $this->sport->id;
		}
		return [
			'name' => $nameRule,
			'description' => 'required|string',
            'practiceDayTitleNl' => 'required|string',
            'practiceDayTitleEn' => 'required|string',
            'competitionDayTitleNl' => 'required|string',
            'competitionDayTitleEn' => 'required|string',
		];
	}

	public function commit() {
		$this->sport->name = $this->input('name');
		$this->sport->description = $this->input('description');
        $this->sport->practice_day_title_nl = $this->input('practiceDayTitleNl');
        $this->sport->practice_day_title_en = $this->input('practiceDayTitleEn');
        $this->sport->competition_day_title_nl = $this->input('competitionDayTitleNl');
        $this->sport->competition_day_title_en = $this->input('competitionDayTitleEn');
		$this->sport->save();

		return $this->sport;
	}
}
