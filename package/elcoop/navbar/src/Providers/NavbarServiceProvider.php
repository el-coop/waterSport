<?php

namespace ElCoop\Navbar\Providers;

use Illuminate\Support\ServiceProvider;

class NavbarServiceProvider extends ServiceProvider {
	/**
	 * Register services.
	 *
	 * @return void
	 */
	public function register() {

	}

	/**
	 * Bootstrap services.
	 *
	 * @return void
	 */
	public function boot() {

		$this->loadViewsFrom(__DIR__ . '/../Views', 'elcoop:navbar');
		$this->publishes([
			__DIR__ . '/../../resources/js' => resource_path('js/vendor/elcoop/navbar'),
			__DIR__ . '/../../resources/style' => resource_path('sass')
		]);
	}
}
