<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CompetitionDay extends Model {

	protected $dates = [
		'start_time',
		'end_time'
	];

	protected $appends = [
		'date',
		'startHour',
		'endHour'
	];

	public function sport() {
		return $this->belongsTo(Sport::class);
	}

	public function getDateAttribute() {
		return $this->start_time->format('Y-m-d');
	}

	public function getStartHourAttribute() {
		return $this->start_time->format('H:i');
	}


	public function getEndHourAttribute() {
		return $this->end_time->format('H:i');
	}
}
