<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SportManager extends Model {

	protected static function boot() {
		parent::boot();
		static::deleted(function ($sportManager) {
			$sportManager->user->delete();
		});
	}

//	protected $appends = [
//		'sportName'
//	];

//	public function homePage() {
//	}

	public function user() {
		return $this->morphOne(User::class, 'user');
	}

	public function sport() {
		return $this->belongsTo(Sport::class);
	}

	public function getFullDataAttribute() {
		$sportValues = Sport::all()->mapWithKeys(function ($sport){
			return [$sport->id => $sport->name];
		});
		return collect([
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
			],
			[
				'name' => 'sport',
				'label' => __('sports.sport'),
				'type' => 'select',
				'options' => $sportValues->toArray(),
				'value' => $this->sport->id ?? ''
			]
		]);
	}
}
