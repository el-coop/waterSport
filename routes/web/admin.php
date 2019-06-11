<?php

Route::group(['prefix' => 'admin', 'middleware' => ['auth', 'userType:' . \App\Models\Admin::class], 'namespace' => 'Admin'], function () {
	
	Route::group(['prefix' => 'sports'], function () {
		Route::get('/', 'SportsController@index');
		Route::group(['prefix' => 'edit'], function () {
			Route::get('/{sport?}', 'SportsController@edit');
			Route::post('/', 'SportsController@store');
			Route::patch('/{sport}', 'SportsController@update');
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

		Route::group(['prefix' => 'competition'], function (){
			Route::get('/{sport}', 'SportsController@getCompetitionDays');
			Route::post('/{sport}', 'CompetitionDayController@store');
			Route::patch('/{sport}/{competitionDay}', 'CompetitionDayController@update');
			Route::delete('/{sport}/{competitionDay}', 'CompetitionDayController@destroy');
		});
	});

	Route::group(['prefix' => 'competitors'], function (){
		Route::get('/', 'CompetitorController@index');
		Route::group(['prefix' => 'edit'], function () {
			Route::get('/{competitor?}', 'CompetitorController@edit');
			Route::post('/', 'CompetitorController@store');
			Route::patch('/{competitor}', 'CompetitorController@update');
		});
		Route::get('/{competitor}', 'CompetitorController@show');
		Route::patch('/{competitor}', 'CompetitorController@updateForm');
		Route::delete('/{competitor}', 'CompetitorController@destroy');
	});
	Route::group(['prefix' => 'field'], function () {
		Route::post('/', 'FieldController@create');
		Route::get('/{type}', 'FieldController@index');
		Route::delete('/{field}', 'FieldController@destroy');
		Route::patch('/order', 'FieldController@saveOrder');
		Route::patch('/{field}', 'FieldController@edit');
	});

	Route::group(['prefix' => 'settings'],  function (){
		Route::get('/' , 'SettingsController@show');
		Route::patch('/', 'SettingsController@update');
	});
	Route::group(['prefix' => 'sportManagers'], function (){
		Route::get('/', 'SportManagerController@index');
		Route::group(['prefix' => 'edit'], function () {
			Route::get('/{sportManager?}', 'SportManagerController@edit');
			Route::post('/', 'SportManagerController@store');
			Route::patch('/{sportManager}', 'SportManagerController@update');
		});
		Route::delete('/{sportManager}', 'SportManagerController@destroy');
	});

	Route::group(['prefix' => 'files'], function (){
		Route::get('/', 'PdfController@index');
		Route::post('/', 'PdfController@store');
		Route::patch('/{pdf}', 'PdfController@update');
		Route::delete('/{pdf}', 'PdfController@destroy');
	});
});
