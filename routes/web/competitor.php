<?php

Route::group(['prefix' => 'competitor'], function () {
	
	Route::get('password/{token}', 'CompetitorController@showResetForm')->middleware('guest');
	
	Route::group(['middleware' => ['auth', 'userType:' . \App\Models\Competitor::class]], function () {
		Route::get('/', 'CompetitorController@edit');
		Route::patch('/', 'CompetitorController@update');
	});
});
