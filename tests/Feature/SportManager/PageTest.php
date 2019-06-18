<?php

namespace Tests\Feature\SportManager;

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

class PageTest extends TestCase {
	
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
	
	public function test_guest_cant_get_sport_manager_page() {
		$this->get(action('SportManagerController@home'))->assertRedirect(action('Auth\LoginController@login'));
	}
	
	public function test_competitor_cant_get_sport_manager_page() {
		$this->actingAs($this->competitor)->get(action('SportManagerController@home'))->assertForbidden();
	}
	
	public function test_admin_cant_get_sport_manager_page() {
		$this->actingAs($this->admin)->get(action('SportManagerController@home'))->assertForbidden();
	}
	
	public function test_sport_manager_can_get_sport_manager_page() {
		$this->actingAs($this->sportManager)->get(action('SportManagerController@home'))->assertSuccessful();
	}
	
	public function test_guest_cant_get_practice_day_datatable() {
		$this->get(action('SportManagerController@practiceDayTable', $this->practiceDay))->assertRedirect(action('Auth\LoginController@login'));
	}
	
	public function test_competitor_cant_get_practice_day_datatable() {
		$this->actingAs($this->competitor)->get(action('SportManagerController@practiceDayTable', $this->practiceDay))->assertForbidden();
	}
	
	public function test_admin_cant_get_practice_day_datatable() {
		$this->actingAs($this->admin)->get(action('SportManagerController@practiceDayTable', $this->practiceDay))->assertForbidden();
	}
	
	public function test_sport_manager_can_get_practice_day_datatable() {
		$response = $this->actingAs($this->sportManager)->get(action('SportManagerController@practiceDayTable', [
			'practiceDay' => $this->practiceDay->id,
			'attribute' => 'competitorsForManager',
			'per_page' => 20,
			'sort' => 'name|asc'
		]))->assertSuccessful();
		$response->assertJsonFragment([
			'name' => $this->competitor->name
		]);
	}
	
	public function test_guest_cant_get_competition_day_datatable() {
		$this->get(action('SportManagerController@competitionDayTable', $this->competitionDay))->assertRedirect(action('Auth\LoginController@login'));
	}
	
	public function test_competitor_cant_get_competition_day_datatable() {
		$this->actingAs($this->competitor)->get(action('SportManagerController@competitionDayTable', $this->competitionDay))->assertForbidden();
	}
	
	public function test_admin_cant_get_competition_day_datatable() {
		$this->actingAs($this->admin)->get(action('SportManagerController@competitionDayTable', $this->competitionDay))->assertForbidden();
	}
	
	public function test_sport_manager_can_get_competition_day_datatable() {
		$response = $this->actingAs($this->sportManager)->get(action('SportManagerController@competitionDayTable', [
			'competitionDay' => $this->competitionDay->id,
			'attribute' => 'competitorsForManager',
			'per_page' => 20,
			'sort' => 'name|asc'
		]))->assertSuccessful();
		$response->assertJsonFragment([
			'name' => $this->competitor->name
		]);
	}
	
	public function test_guest_cant_update_sport_manager() {
		$this->patch(action('SportManagerController@update', $this->sportManager->user))->assertRedirect(action('Auth\LoginController@login'));
	}
	
	public function test_competitor_cant_update_sport_manager() {
		$this->actingAs($this->competitor)->patch(action('SportManagerController@update', $this->sportManager->user))->assertForbidden();
	}
	
	public function test_admin_cant_update_sport_manager() {
		$this->actingAs($this->admin)->patch(action('SportManagerController@update', $this->sportManager->user))->assertForbidden();
	}
	
	public function test_sport_manager_can_update_sport_manager() {
		$this->actingAs($this->sportManager)->patch(action('SportManagerController@update', $this->sportManager->user), [
			'name' => 'name',
			'lastName' => 'last',
			'email' => 'test@test.com',
			'language' => 'en'
		])->assertRedirect();
		$this->assertDatabaseHas('users', [
			'name' => 'name',
			'last_name' => 'last',
			'email' => 'test@test.com',
			'language' => 'en',
			'user_type' => SportManager::class,
			'id' => $this->sportManager->id
		]);
	}
}
