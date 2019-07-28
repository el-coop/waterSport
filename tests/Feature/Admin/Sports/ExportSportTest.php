<?php

namespace Tests\Feature\Admin\Sports;

use App\Models\Admin;
use App\Models\CompetitionDay;
use App\Models\Competitor;
use App\Models\PracticeDay;
use App\Models\Sport;
use App\Models\SportManager;
use App\Models\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ExportSportTest extends TestCase {
	use RefreshDatabase;

	private $admin;
	private $competitor;
	private $sportManager;
	private $competitionDay;
	private $practiceDay;

	public function setUp(): void {
		parent::setUp();
		$this->admin = factory(User::class)->make();
		factory(Admin::class)->create()->user()->save($this->admin);
		$this->competitor = factory(User::class)->make();
		factory(Competitor::class)->create()->user()->save($this->competitor);
		$this->sportManager = factory(User::class)->make();
		factory(SportManager::class, 1)->make()->each(function ($manager) {
			$sport = factory(Sport::class)->create();
			$sport->sportManagers()->save($manager);
			$manager->user()->save($this->sportManager);
			$this->practiceDay = factory(PracticeDay::class)->create([
				'sport_id' => Sport::first()->id
			]);
			$this->competitionDay = factory(CompetitionDay::class)->create([
				'sport_id' => Sport::first()->id
			]);
		});
		$this->competitor->user->practiceDays()->attach($this->practiceDay->id);
		$this->competitor->user->competitionDays()->attach($this->competitionDay->id);
		$this->competitor->user->sports()->attach(Sport::first()->id, ['data' => 'test']);
	}


	public function test_guest_cant_export_sport() {
		$this->post(action('Admin\CompetitorExportColumnController@exportSportDate'))->assertRedirect(action('Auth\LoginController@login'));
	}

	public function test_competitor_cant_export_sport() {
		$this->actingAs($this->competitor)->post(action('Admin\CompetitorExportColumnController@exportSportDate'))->assertForbidden();
	}

	public function test_sport_manager_cant_export_sport() {
		$this->actingAs($this->sportManager)->post(action('Admin\CompetitorExportColumnController@exportSportDate'))->assertForbidden();
	}

	public function test_admin_can_export_sport() {
		$this->actingAs($this->admin)->post(action('Admin\CompetitorExportColumnController@exportSportDate'),[
			'sport' => Sport::first()->id,
			'dayType' => 1,
			$this->practiceDay->id
		])->assertRedirect();
	}

}
