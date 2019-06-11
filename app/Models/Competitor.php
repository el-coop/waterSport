<?php

namespace App\Models;

use ElCoop\HasFields\HasFields;
use Illuminate\Database\Eloquent\Model;

class Competitor extends Model {
	
	use HasFields;
	
	protected static function boot() {
		parent::boot();
		static::deleted(function ($competitor) {
			$competitor->user->delete();
		});
	}
	
	
	protected $casts = [
		'data' => 'array',
	];
	
	protected $appends = [
		'sportsList'
	];
	
	public function homePage() {
		return action('CompetitorController@edit');
	}
	
	public function user() {
		return $this->morphOne(User::class, 'user');
	}
	
	public function sports() {
		return $this->belongsToMany(Sport::class)->using(CompetitorSport::class)->withPivot('data');
	}
	
	public function practiceDays() {
		return $this->belongsToMany(PracticeDay::class);
	}
	
	public function getSportsListAttribute() {
		return $this->sports->implode('name', ', ');
	}
	
	public function getFullDataAttribute() {
		$fullData = collect([
			[
				'name' => 'name',
				'label' => __('global.name'),
				'type' => 'text',
				'value' => $this->user->name ?? '',
			], [
				'name' => 'email',
				'label' => __('global.email'),
				'type' => 'text',
				'value' => $this->user->email ?? '',
			], [
				'name' => 'language',
				'label' => __('global.language'),
				'type' => 'select',
				'options' => [
					'nl' => __('global.nl'),
					'en' => __('global.en'),
				],
				'value' => $this->user->language ?? 'nl',
			]
		]);
		return $fullData->concat($this->getFieldsData());
	}
	
	static function indexPage() {
		return action('Admin\CompetitorController@index', [], false);
	}

	public function getScheduleAttribute() {
		$sports = $this->sports;
		return $sports->map(function ($sport){
			$practiceDay = $sport->pivot->practice_day_id;
			return [
				'sport' => 	$sport->name,
				'practiceDay' => $practiceDay ? PracticeDay::find($practiceDay)->date: '',
				'competition' => $sport->date->format('Y-m-d')
			];
		});
	}
	
}
