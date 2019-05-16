<?php

namespace App\Models;

use ElCoop\HasFields\HasFields;
use Illuminate\Database\Eloquent\Model;

class Admin extends Model {
	use HasFields;
	public function user() {
		return $this->morphOne(User::class, 'user');
	}
}