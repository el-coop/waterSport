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


	public function user() {
		return $this->morphOne(User::class, 'user');
	}

	public function sports() {
		return $this->belongsToMany(Sport::class)->withPivot('data');
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
		if ($this->exists) {
			$fullData = $fullData->concat($this->getFieldsData());
		}
		return $fullData;
	}

}
