<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sport extends Model {
	
	public function getFullDataAttribute() {
		return collect([
			[
				'name' => 'name',
				'label' => __('global.name'),
				'type' => 'text',
				'value' => $this->name
			],
		]);
	}
	
}
