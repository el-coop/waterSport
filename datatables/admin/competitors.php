<?php

return [
	'model' => \App\Models\Competitor::class,
	'where' => [['users.user_type' , \App\Models\Competitor::class]],
	'joins' => [
		['users', 'users.user_id', 'competitors.id'],
		['competitor_sport', 'competitors.id', 'competitor_sport.competitor_id'],
		['sports', 'competitor_sport.sport_id', 'sports.id']
	],
	'fields' => [
		[
			'name' => 'id',
			'table' => 'competitors',
			'title' => 'id',
			'visible' => false
		],
		[
			'name' => 'name',
			'title' => 'global.name',
			'table' => 'users',
			'sortField' => 'name',
		], [
			'name' => 'email',
			'title' => 'global.email',
			'sortField' => 'email',
		], [
			'name' => 'sportsList',
			'noTable' => true,
			'filterFields' => ['sports.name'],
			'filter' => function () {
				return \App\Models\Sport::all()->pluck('name', 'name');
			},
			'title' => 'sports.sports',
		]
	]
];