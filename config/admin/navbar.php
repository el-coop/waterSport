<?php

return [
	'sports.sports' => [
		'sports.index' => 'Admin\SportsController@index',
		'sports.managers' => 'Admin\SportManagerController@index'
	],
	'competitors.competitors' => [
		'sports.index' => 'Admin\CompetitorController@index'
	],
	'global.general' => [
		'global.settings' => 'Admin\SettingsController@show'
	]
];
