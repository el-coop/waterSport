<?php

return [
	'model' => \App\Models\Sport::class,
	'fields' => [
		[
			'name' => 'id',
			'visible' => false
		
		],
		[
			'name' => 'name',
			'title' => 'global.name',
		],
		[
			'name' => 'date',
			'title' => 'global.date',
			'callback' => 'date'
		]
	]
];
