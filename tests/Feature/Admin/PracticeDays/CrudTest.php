<?php

namespace Tests\Feature\Admin\PracticeDays;

use App\Models\Admin;
use App\Models\PracticeDay;
use App\Models\Sport;
use App\Models\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CrudTest extends TestCase {
	use WithFaker;
	use RefreshDatabase;
	
	private $admin;
	private $sport;
	private $practiceDay;
	
	public function setUp(): void {
		parent::setUp();
		$this->admin = factory(User::class)->make();
		factory(Admin::class)->create()->user()->save($this->admin);
		$this->sport = factory(Sport::class)->create();
		$this->practiceDay = factory(PracticeDay::class)->make();
		$this->sport->practiceDays()->save($this->practiceDay);
	}
	
	public function test_guest_cant_create_practice_day() {
		$this->post(action('Admin\PracticeDaysController@store', $this->sport))->assertRedirect(action('Auth\LoginController@login'));
	}
	
	public function test_admin_can_create_practice_day() {
		$practiceDate = $this->faker->date;
		$this->actingAs($this->admin)->post(action('Admin\PracticeDaysController@store', $this->sport), [
			'date' => $practiceDate,
			'time' => '10:00',
		])->assertSuccessful();
		$this->assertDatabaseHas('practice_days', [
			'sport_id' => $this->sport->id,
			'date_time' => $practiceDate . ' 10:00:00'
		]);
	}
	
	public function test_admin_create_practice_day_validation() {
		$this->actingAs($this->admin)->post(action('Admin\PracticeDaysController@store', $this->sport), [
			'date' => 'tst'
		])->assertSessionHasErrors('date');
	}
	
	public function test_guest_cant_update_practice_day() {
		$this->patch(action('Admin\PracticeDaysController@update', [$this->sport, $this->practiceDay]))->assertRedirect(action('Auth\LoginController@login'));
	}
	
	public function test_admin_can_update_practice_day() {
		$practiceDate = $this->faker->date;
		
		$this->actingAs($this->admin)->patch(action('Admin\PracticeDaysController@update', [$this->sport, $this->practiceDay]), [
			'date' => $practiceDate,
			'time' => '10:00',
		])->assertSuccessful();
		$this->assertDatabaseHas('practice_days', [
			'sport_id' => $this->sport->id,
			'date_time' => $practiceDate . ' 10:00:00',
			'id' => $this->practiceDay->id
		]);
	}
	
	public function test_admin_update_practice_day_validation() {
		$this->actingAs($this->admin)->patch(action('Admin\PracticeDaysController@update', [$this->sport, $this->practiceDay]), [
			'date' => ''
		])->assertSessionHasErrors('date');
	}
	
	public function test_guest_cant_delete_practice_day() {
		$this->delete(action('Admin\PracticeDaysController@destroy', [$this->sport, $this->practiceDay]))->assertRedirect(action('Auth\LoginController@login'));
	}
	
	public function test_admin_can_delete_practice_day() {
		$this->actingAs($this->admin)->delete(action('Admin\PracticeDaysController@destroy', [$this->sport, $this->practiceDay]))->assertSuccessful();
		$this->assertDatabaseMissing('practice_days', [
			'id' => $this->practiceDay->id
		]);
	}
	
	
}
