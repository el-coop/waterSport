<?php

Route::group(['prefix' => 'admin', 'middleware' => ['auth', 'userType:' . \App\Models\Admin::class], 'namespace' => 'Admin'], function () {
	
	Route::group(['prefix' => 'sports'], function () {
		Route::get('/', 'SportsController@index');
		Route::group(['prefix' => 'edit'], function () {
			Route::get('/{sport?}', 'SportsController@edit');
			Route::post('/{sport?}', 'SportsController@store');
		});
		Route::delete('/{sport}', 'SportsController@destroy');
		
	});
});
