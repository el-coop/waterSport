<?php

namespace App\Http\Requests\Admin\PracticeDay;

use App\Models\PracticeDay;
use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;

class StorePracticeDayRequest extends FormRequest {
	private $sport;
	private $practiceDay;
	
	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @return bool
	 */
	public function authorize() {
		$this->sport = $this->route('sport');
		if ($this->practiceDay = $this->route('practiceDay')) {
			return $this->user()->can('update', $this->practiceDay);
		}
		
		$this->practiceDay = new PracticeDay;
		return $this->user()->can('create', PracticeDay::class);
	}
	
	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules() {
		return [
			'date' => 'required|date|before:' . $this->sport->date,
			'time' => 'required|date_format:H:i',
		];
	}
	
	public function commit() {
		$this->practiceDay->date_time = Carbon::createFromFormat('Y-m-d H:i',$this->input('date') . ' ' .$this->input('time'));
		$this->sport->practiceDays()->save($this->practiceDay);
		
		return $this->practiceDay;
	}
}
