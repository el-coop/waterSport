<?php

return [
	'model' => \App\Models\SportManager::class,
	'where' => [['users.user_type' , \App\Models\SportManager::class]],
	'joins' => [
		['users', 'users.user_id', 'sport_managers.id'],
		['sports', 'sport_managers.sport_id', 'sports.id']
	],
	'fields' => [
		[
			'name' => 'id',
			'table' => 'sport_managers',
			'title' => 'id',
			'visible' => false
		],
		[
			'name' => 'name',
			'title' => 'global.name',
			'table' => 'users',
			'sortField' => 'name',
		],[
			'name' => 'last_name',
			'title' => 'global.lastName',
			'table' => 'users',
			'sortField' => 'last_name',
		], [
			'name' => 'email',
			'title' => 'global.email',
			'sortField' => 'email',
		], [
			'name' => 'sport',
			'title' => 'sports.sport',
			'table' => 'sports',
			'raw' => 'sports.name as sport'
		]
	]
];