<?php

Route::group(['prefix' => 'admin', 'middleware' => ['auth', 'userType:' . \App\Models\Admin::class], 'namespace' => 'Admin'], function () {
	
	Route::group(['prefix' => 'sports'], function () {
		Route::get('/', 'SportsController@index');
		Route::group(['prefix' => 'edit'], function () {
			Route::get('/{sport?}', 'SportsController@edit');
			Route::post('/{sport?}', 'SportsController@store');
		});
		Route::get('/{sport}', 'SportsController@show');
		Route::delete('/{sport}', 'SportsController@destroy');
		Route::group(['prefix' => '{sport}'], function (){
			Route::post('/', 'SportFieldsController@store');
			Route::patch('/{sportField}', 'SportFieldsController@update');
			Route::delete('/{sportField}', 'SportFieldsController@destroy');
		});
		Route::group(['prefix' => 'practice'], function (){
			Route::get('/{sport}', 'SportsController@getPracticeDays');
			Route::post('/{sport}', 'PracticeDaysController@store');
			Route::patch('/{sport}/{practiceDay}', 'PracticeDaysController@update');
			Route::delete('/{sport}/{practiceDay}', 'PracticeDaysController@destroy');
		});
	});

	Route::group(['prefix' => 'competitors'], function (){
		Route::get('/', 'CompetitorController@index');
	});
});
