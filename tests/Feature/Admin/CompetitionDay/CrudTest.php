<?php

namespace Tests\Feature\Admin\CompetitionDay;

use App\Models\Admin;
use App\Models\CompetitionDay;
use App\Models\Competitor;
use App\Models\Sport;
use App\Models\SportManager;
use App\Models\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CrudTest extends TestCase {
	use WithFaker;
	use RefreshDatabase;

	private $admin;
	private $competitor;
	private $sportManager;
	private $sport;
	private $competitionDay;

	public function setUp(): void {
		parent::setUp();
		$this->admin = factory(User::class)->make();
		factory(Admin::class)->create()->user()->save($this->admin);
		$this->competitor = factory(User::class)->make();
		factory(Competitor::class)->create()->user()->save($this->competitor);
		$this->sportManager = factory(User::class)->make();
		factory(SportManager::class, 1)->make()->each(function ($manager) {
			$this->sport = factory(Sport::class)->create();
			$this->sport->sportManagers()->save($manager);
			$manager->user()->save($this->sportManager);
		});
		$this->competitionDay = factory(CompetitionDay::class)->make();
		$this->sport->competitionDays()->save($this->competitionDay);
	}

	public function test_guest_cant_create_competition_day() {
		$this->post(action('Admin\CompetitionDayController@store', $this->sport))->assertRedirect(action('Auth\LoginController@login'));
	}

	public function test_competitor_cant_create_competition_day() {
		$this->actingAs($this->competitor)->post(action('Admin\CompetitionDayController@store', $this->sport))->assertForbidden();
	}

	public function test_sports_manager_cant_create_competition_day() {
		$this->actingAs($this->competitor)->post(action('Admin\CompetitionDayController@store', $this->sport))->assertForbidden();
	}

	public function test_admin_can_create_competition_day() {
		$competitionDate = $this->faker->date;
		$this->actingAs($this->admin)->post(action('Admin\CompetitionDayController@store', $this->sport), [
			'date' => $competitionDate,
			'startHour' => '10:00',
			'endHour' => '12:00'
		])->assertSuccessful();
		$this->assertDatabaseHas('competition_days', [
			'sport_id' => $this->sport->id,
			'start_time' => $competitionDate . ' 10:00:00',
			'end_time' => $competitionDate . ' 12:00:00'
		]);
	}

	public function test_admin_create_competition_day_validation() {
		$this->actingAs($this->admin)->post(action('Admin\CompetitionDayController@store', $this->sport), [
			'date' => 'tst'
		])->assertSessionHasErrors('date');
	}

	public function test_guest_cant_update_competition_day() {
		$this->patch(action('Admin\CompetitionDayController@update', [$this->sport, $this->competitionDay]))->assertRedirect(action('Auth\LoginController@login'));
	}

	public function test_competitor_cant_update_competition_day() {
		$this->actingAs($this->competitor)->patch(action('Admin\CompetitionDayController@update', [$this->sport, $this->competitionDay]))->assertForbidden();
	}

	public function test_sports_manager_cant_update_competition_day() {
		$this->actingAs($this->competitor)->patch(action('Admin\CompetitionDayController@update', [$this->sport, $this->competitionDay]))->assertForbidden();
	}

	public function test_admin_can_update_competition_day() {
		$competitionDate = $this->faker->date;

		$this->actingAs($this->admin)->patch(action('Admin\CompetitionDayController@update', [$this->sport, $this->competitionDay]), [
			'date' => $competitionDate,
			'startHour' => '10:00',
			'endHour' => '12:00'
		])->assertSuccessful();
		$this->assertDatabaseHas('competition_days', [
			'sport_id' => $this->sport->id,
			'start_time' => $competitionDate . ' 10:00:00',
			'end_time' => $competitionDate . ' 12:00:00',
			'id' => $this->competitionDay->id
		]);
	}

	public function test_admin_update_competition_day_validation() {
		$this->actingAs($this->admin)->patch(action('Admin\CompetitionDayController@update', [$this->sport, $this->competitionDay]), [
			'date' => ''
		])->assertSessionHasErrors('date');
	}

	public function test_guest_cant_delete_competition_day() {
		$this->delete(action('Admin\CompetitionDayController@destroy', [$this->sport, $this->competitionDay]))->assertRedirect(action('Auth\LoginController@login'));
	}

	public function test_competitor_cant_delete_competition_day() {
		$this->actingAs($this->competitor)->delete(action('Admin\CompetitionDayController@update', [$this->sport, $this->competitionDay]))->assertForbidden();
	}

	public function test_sports_manager_cant_delete_competition_day() {
		$this->actingAs($this->competitor)->delete(action('Admin\CompetitionDayController@update', [$this->sport, $this->competitionDay]))->assertForbidden();
	}

	public function test_admin_can_delete_competition_day() {
		$this->actingAs($this->admin)->delete(action('Admin\CompetitionDayController@destroy', [$this->sport, $this->competitionDay]))->assertSuccessful();
		$this->assertDatabaseMissing('competition_days', [
			'id' => $this->competitionDay->id
		]);
	}
}
