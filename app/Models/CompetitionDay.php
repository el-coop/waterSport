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
	
	public function competitors() {
		return $this->belongsToMany(Competitor::class);
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
	
	public function getCompetitorsForManagerAttribute() {
		return [
			'model' => Competitor::class,
			'where' => [
				['competitor_sport.sport_id', $this->sport->id],
				['users.user_type', Competitor::class],
				['competition_day_competitor.competition_day_id', $this->id]
			],
			'joins' => [
				['users', 'users.user_id', 'competitors.id'],
				['competitor_sport', 'competitor_sport.competitor_id', 'competitors.id'],
				['competition_day_competitor', 'competition_day_competitor.competitor_id', 'competitors.id']
			],
			'fields' => [[
				'name' => 'name',
				'title' => __('global.firstName'),
				'sortField' => 'name'
			], [
				'name' => 'last_name',
				'title' => __('global.lastName'),
				'sortField' => 'last_name'
			], [
				'name' => 'email',
				'title' => __('global.email'),
				'sortField' => 'email'
			]]
		];
	}
}
