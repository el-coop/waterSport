<?php

Route::group(['prefix' => 'admin', 'middleware' => ['auth', 'userType:' . \App\Models\Admin::class], 'namespace' => 'Admin'], function () {
	Route::get('sports', 'SportsController@index');
});
