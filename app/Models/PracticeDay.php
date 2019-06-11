<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PracticeDay extends Model {
	
	protected $dates = [
		'date_time'
	];
	
	protected $appends = [
		'date',
		'time'
	];
	
	public function sport() {
		return $this->belongsTo(Sport::class);
	}
	
	public function getDateAttribute() {
		return $this->date_time->format('Y-m-d');
	}
	
	public function getTimeAttribute() {
		return $this->date_time->format('H:i');
	}
}
