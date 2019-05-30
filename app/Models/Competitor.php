<?php

namespace App\Models;

use ElCoop\HasFields\HasFields;
use Illuminate\Database\Eloquent\Model;

class Competitor extends Model {
	
	use HasFields;
	
	protected $casts = [
		'data' => 'array',
		'sports_day' => 'array'
	];
	
	
	public function user() {
		return $this->morphOne(User::class, 'user');
	}
	
}
