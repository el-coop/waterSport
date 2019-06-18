<?php

Route::group(['prefix' => 'sportManager'], function () {

	Route::get('password/{token}', 'SportManagerController@showResetForm')->middleware('guest');

	Route::group(['middleware' => ['auth', 'userType:' . \App\Models\SportManager::class]], function () {
		Route::get('/', 'SportManagerController@home');
		Route::get('competitions/{competitionDay}/datatable/list', 'SportManagerController@competitionDayTable');
		Route::get('practices/{practiceDay}/datatable/list', 'SportManagerController@practiceDayTable');
		Route::patch('{sportManager}', 'SportManagerController@update');
	});
});