<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', 'Auth\RegisterController@showRegistrationForm');
Route::post('/', 'Auth\RegisterController@register');

Route::middleware(['auth', 'userType:' . \App\Models\Admin::class])->group(function () {
	Route::get('datatable/list', '\ElCoop\Datatable\Controllers\DatatableController@list');
	Route::get('datatable/export', '\ElCoop\Datatable\Controllers\DatatableController@export');
});

Auth::routes(['verify' => false, 'register' => false]);

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/language/{language}', 'LocaleController@set');
Route::get('/pdf/{pdf}', 'ResourceController@view');


foreach (\File::allFiles(__DIR__ . "/web") as $routeFile) {
	include $routeFile;
}
