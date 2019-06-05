<?php

Route::group(['prefix' => 'sportManager'], function () {

	Route::get('password/{token}', 'SportManagerController@showResetForm')->middleware('guest');

	Route::group(['middleware' => ['auth', 'userType:' . \App\Models\SportManager::class]], function () {
	});
});