<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sport extends Model {

	protected $dates = [
		'date'
	];
	
	public function getFullDataAttribute() {
		return collect([
			[
				'name' => 'name',
				'label' => __('global.name'),
				'type' => 'text',
				'value' => $this->name
			],
			[
				'name' => 'date',
				'label' => __('global.date'),
				'type' => 'text',
				'subType' => 'date',
				'value' => $this->date ? $this->date->format('Y-m-d') : null
			]
		]);
	}
	
}
