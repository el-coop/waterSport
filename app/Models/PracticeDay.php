<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PracticeDay extends Model {
	
	protected $dates = [
		'date'
	];
	
	public function sport() {
		return $this->belongsTo(Sport::class);
	}
	
	public function competitors() {
		$this->belongsToMany(Competitor::class);
	}
}
