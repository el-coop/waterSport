<?php

namespace App\Providers;

use App\Models\Admin;
use App\Models\CompetitionDay;
use App\Models\Competitor;
use App\Models\CompetitorExportColumn;
use App\Models\Pdf;
use App\Models\PracticeDay;
use App\Models\Sport;
use App\Models\SportField;
use App\Models\SportManager;
use App\Policies\CompetitionDayPolicy;
use App\Policies\CompetitorExportColumnPolicy;
use App\Policies\CompetitorPolicy;
use App\Policies\FieldPolicy;
use App\Policies\PdfPolicy;
use App\Policies\PracticeDayPolicy;
use App\Policies\SportFieldPolicy;
use App\Policies\SportManagerPolicy;
use App\Policies\SportPolicy;
use ElCoop\HasFields\Models\Field;
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
		PracticeDay::class => PracticeDayPolicy::class,
		SportField::class => SportFieldPolicy::class,
		Competitor::class => CompetitorPolicy::class,
		Field::class => FieldPolicy::class,
		SportManager::class => SportManagerPolicy::class,
		Pdf::class => PdfPolicy::class,
		CompetitionDay::class => CompetitionDayPolicy::class,
		CompetitorExportColumn::class => CompetitorExportColumnPolicy::class
	];
	
	/**
	 * Register any authentication / authorization services.
	 *
	 * @return void
	 */
	public function boot() {
		$this->registerPolicies();
		Gate::define('update-settings', function ($user) {
			return $user->user_type == Admin::class;
		});
	}
}
