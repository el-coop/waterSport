<?php

Route::group(['prefix' => 'competitor', 'middleware' => ['auth', 'userType:' . \App\Models\Competitor::class]], function () {
	
	Route::get('/', 'CompetitorController@edit');
	Route::patch('/', 'CompetitorController@update');
});
