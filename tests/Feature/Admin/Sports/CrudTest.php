<?php

namespace Tests\Feature\Admin\Sports;

use App\Models\Admin;
use App\Models\Sport;
use App\Models\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CrudTest extends TestCase {
	
	use RefreshDatabase;
	
	private $admin;
	private $sport;
	
	public function setUp(): void {
		parent::setUp();
		$this->admin = factory(User::class)->make();
		factory(Admin::class)->create()->user()->save($this->admin);
		
		$this->sport = factory(Sport::class)->create();
		
		
	}
	
	public function test_not_logged_in_cant_create_sport() {
		$this->post(action('Admin\SportsController@store'))->assertRedirect(action('Auth\LoginController@showLoginForm'));
	}
	
	public function test_not_logged_in_cant_view_create_sport_form() {
		$this->get(action('Admin\SportsController@edit'))->assertRedirect(action('Auth\LoginController@showLoginForm'));
	}
	
	public function test_admin_can_view_create_sport_form() {
		$this->actingAs($this->admin)->get(action('Admin\SportsController@edit'))->assertSuccessful()->assertJsonFragment([
			'name' => 'name',
		]);
	}
	
	public function test_admin_can_create_sport() {
		$this->withoutExceptionHandling();
		$this->actingAs($this->admin)->post(action('Admin\SportsController@store'), [
			'name' => 'name',
			'date' => '2020-01-01'
		])->assertSuccessful()->assertJson([
			'name' => 'name',
			'date' => '2020-01-01 00:00:00'
		]);
		
		$this->assertDatabaseHas('sports', [
			'name' => 'name',
			'date' => '2020-01-01 00:00:00'
		]);
	}
	
	public function test_admin_create_sport_validation() {
		$this->actingAs($this->admin)->post(action('Admin\SportsController@store'), [
			'name' => ''
		])->assertSessionHasErrors('name', 'date');
		
		$this->actingAs($this->admin)->post(action('Admin\SportsController@store'), [
			'name' => $this->sport->name
		])->assertSessionHasErrors('name');
		
	}
	
	
	public function test_not_logged_in_cant_view_edit_sport_form() {
		$this->get(action('Admin\SportsController@edit', $this->sport))->assertRedirect(action('Auth\LoginController@showLoginForm'));
	}
	
	public function test_admin_can_view_edit_sport_form() {
		$this->actingAs($this->admin)->get(action('Admin\SportsController@edit', $this->sport))->assertSuccessful()->assertJsonFragment([
			'name' => 'name',
			'value' => $this->sport->name
		])->assertJsonFragment([
			'name' => 'date',
			'value' => $this->sport->date->format('Y-m-d')
		]);
	}
	
	public function test_not_logged_in_cant_edit_sport() {
		$this->post(action('Admin\SportsController@store', $this->sport))->assertRedirect(action('Auth\LoginController@showLoginForm'));
	}
	
	public function test_admin_can_edit_sport() {
		$this->actingAs($this->admin)->patch(action('Admin\SportsController@update', $this->sport), [
			'name' => 'name',
			'date' => '2020-01-01 00:00:00'
		])->assertSuccessful()->assertJson([
			'name' => 'name',
			'date' => '2020-01-01 00:00:00'
		]);
		
		$this->assertDatabaseHas('sports', [
			'id' => $this->sport->id,
			'name' => 'name'
		]);
	}
	
	public function test_admin_edit_sport_validation() {
		$this->actingAs($this->admin)->post(action('Admin\SportsController@store', $this->sport), [
			'name' => ''
		])->assertSessionHasErrors('name');
		
		$sport = factory(Sport::class)->create();
		$this->actingAs($this->admin)->post(action('Admin\SportsController@store', $this->sport), [
			'name' => $sport->name
		])->assertSessionHasErrors('name');
		
	}
	
	public function test_not_logged_in_cant_delete_sport() {
		$this->delete(action('Admin\SportsController@destroy', $this->sport))->assertRedirect(action('Auth\LoginController@showLoginForm'));
	}
	
	
	public function test_admin_can_delete_sport() {
		$this->actingAs($this->admin)->delete(action('Admin\SportsController@destroy', $this->sport))->assertSuccessful();
		
		$this->assertDatabaseMissing('sports', [
			'id' => $this->sport->id
		]);
	}

	public function test_not_logged_cant_get_sport_page() {
		$this->get(action('Admin\SportsController@show', $this->sport))->assertRedirect(action('Auth\LoginController@login'));
	}

	public function test_admin_can_get_sport_page() {
		$this->actingAs($this->admin)->get(action('Admin\SportsController@show', $this->sport))->assertSuccessful()->assertSee($this->sport->name);
	}
}
