<?php

return [
	'model' => \App\Models\Sport::class,
	'joins' => [['competition_days', 'sports.id', 'competition_days.sport_id']],
	'fields' => [
		[
			'name' => 'id',
			'table' => 'sports',
			'visible' => false
		
		],
		[
			'name' => 'name',
			'title' => 'global.name',
		],
		[
			'name' => 'competitionDaysList',
			'title' => 'sports.competitionDates',
			'noTable' => true,
		]
	]
];
