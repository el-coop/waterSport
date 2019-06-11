<?php

namespace App\Models;

use App;
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
				'name' => 'description',
				'label' => __('sports.description'),
				'type' => 'textarea',
				'value' => $this->description
			],
			[
				'name' => 'date',
				'label' => __('sports.competitionDate'),
				'type' => 'text',
				'subType' => 'date',
				'value' => $this->date ? $this->date->format('Y-m-d') : null
			],
			[
				'name' => 'practiceDayTitleNl',
				'label' => __('sports.practiceDayTitleNl'),
				'type' => 'text',
				'value' => $this->practice_day_title_nl
			],
			[
				'name' => 'practiceDayTitleEn',
				'label' => __('sports.practiceDayTitleEn'),
				'type' => 'text',
				'value' => $this->practice_day_title_en
			],
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
	
	public function sportManagers() {
		return $this->hasMany(SportManager::class);
	}
	
	static function registrationOptions() {
		return static::select('id', 'name', 'date', 'description', 'practice_day_title_nl', 'practice_day_title_en')->with(['practiceDays' => function ($query) {
			$query->select('id', 'sport_id', 'date_time');
		}, 'fields' => function ($query) {
			$language = App::getLocale();
			$query->select('id', 'sport_id', 'type', "name_{$language} as title", "placeholder_{$language} as placeholder");
		}])->get()->each(function ($sport) {
			$sport->competition = $sport->date->format('d/m/Y');
			$sport->formattedDescription = nl2br($sport->description);
			$sport->practiceDays->each(function ($practiceDay) {
				$practiceDay->formattedDate = $practiceDay->date_time->format('d/m/Y H:i');
			});
		});
	}
}
