<?php

namespace App\Models;

use App;
use Illuminate\Database\Eloquent\Model;

class Sport extends Model {


	protected $appends = [
		'competitionDaysList'
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
                'name' => 'dayLimit',
                'label' => __('sports.dayLimit'),
                'type' => 'text',
                'subType' => 'number',
                'value' => $this->day_limit
            ],
            [
                'name' => 'competitionDayTitleNl',
                'label' => __('sports.competitionDayTitleNl'),
                'type' => 'text',
                'value' => $this->competition_day_title_nl
            ],
            [
                'name' => 'competitionDayTitleEn',
                'label' => __('sports.competitionDayTitleEn'),
                'type' => 'text',
                'value' => $this->competition_day_title_en
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
		return $this->belongsToMany(Competitor::class)->using(CompetitorSport::class)->withPivot('data');
	}

	public function sportManagers() {
		return $this->hasMany(SportManager::class);
	}

	static function registrationOptions() {
		return static::select('id', 'name', 'description', 'day_limit','competition_day_title_nl','competition_day_title_en', 'practice_day_title_nl', 'practice_day_title_en')->with(['practiceDays' => function ($query) {
			$query->select('id', 'sport_id', 'start_time','end_time','max_participants');
		}, 'fields' => function ($query) {
			$language = App::getLocale();
			$query->select('id', 'sport_id', 'type', "name_{$language} as title", "placeholder_{$language} as placeholder");
		}, 'competitionDays'])->get()->each(function ($sport) {
			$sport->formattedDescription = nl2br($sport->description);
			$sport->practiceDays->each(function ($practiceDay) {
				$practiceDay->formattedDate = $practiceDay->start_time->format('d/m/Y H:i');
                $practiceDay->isFull = $practiceDay->isFull;
			});

			$sport->competitionDays->each(function ($competitionDay) {
				$competitionDay->formattedDate = $competitionDay->start_time->format('d/m/Y H:i');
                $competitionDay->isFull = $competitionDay->isFull;
			});

		});
	}

	public function competitionDays() {
		return $this->hasMany(CompetitionDay::class);
	}

	public function getCompetitionDaysListAttribute() {
		return $this->competitionDays->map(function ($day) {
			return $day->start_time->format('d/m/Y H:i');
		})->implode(', ');
	}
}
