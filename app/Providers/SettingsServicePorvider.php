<?php

namespace App\Providers;

use ElCoop\Valuestore\Valuestore;
use Illuminate\Support\ServiceProvider;

class SettingsServicePorvider extends ServiceProvider {
	/**
	 * Register services.
	 *
	 * @return void
	 */
	public function register() {
		//
	}

	/**
	 * Bootstrap services.
	 *
	 * @return void
	 */
	public function boot() {
		$this->app->singleton('settings', function ($app) {
			return new Valuestore(database_path('settings.json'));
		});
	}
}
