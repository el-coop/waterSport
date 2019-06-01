<?php

namespace App\Models;

use ElCoop\HasFields\HasFields;
use Illuminate\Database\Eloquent\Model;

class Competitor extends Model {
	
	use HasFields;
	
	protected $casts = [
		'data' => 'array',
	];

	protected $appends = [
		'sportsList'
	];
	
	
	public function user() {
		return $this->morphOne(User::class, 'user');
	}

	public function sports() {
		return $this->belongsToMany(Sport::class)->withPivot('data');
	}

	public function getSportsListAttribute() {
		return $this->sports->implode('name', ', ');

	}
	
}
