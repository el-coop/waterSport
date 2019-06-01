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
				'label' => __('sports.competitionDate'),
				'type' => 'text',
				'subType' => 'date',
				'value' => $this->date ? $this->date->format('Y-m-d') : null
			]
		]);
	}
	
	public function practiceDays() {
		return $this->hasMany(PracticeDay::class);
	}
	
	public function fields() {
		return $this->hasMany(SportField::class);
	}
	
	public function competitors() {
		return $this->belongsToMany(Competitor::class)->using(CompetitorSport::class)->withPivot('data', 'practiceDay');
	}
}
