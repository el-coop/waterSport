<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class CompetitorSport extends Pivot {
	protected $casts = [
		'data' => 'array'
	];
}
