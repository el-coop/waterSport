<?php

return [
	'sports.sports' => [
		'sports.index' => 'Admin\SportsController@index',
		'sportManagers.sportManagers' => 'Admin\SportManagerController@index'
	],
	'competitors.competitors' => [
		'sports.index' => 'Admin\CompetitorController@index'
	],
	'global.general' => [
		'admin/settings.settings' => 'Admin\SettingsController@show',
		'admin/settings.files' => 'Admin\PdfController@index'
	]
];
