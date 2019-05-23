<?php

namespace App\Providers;

use App\Models\Admin;
use App\Models\PracticeDay;
use App\Models\Sport;
use App\Policies\PracticeDayPolicy;
use App\Policies\SportPolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider {
	/**
	 * The policy mappings for the application.
	 *
	 * @var array
	 */
	protected $policies = [
		Sport::class => SportPolicy::class,
		PracticeDay::class => PracticeDayPolicy::class
	];
	
	/**
	 * Register any authentication / authorization services.
	 *
	 * @return void
	 */
	public function boot() {
		$this->registerPolicies();
		
	}
}
