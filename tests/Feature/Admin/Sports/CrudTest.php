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
	
	public function setUp(): void {
		parent::setUp();
		$this->admin = factory(User::class)->make();
		factory(Admin::class)->create()->user()->save($this->admin);
		
	}
	
	public function test_not_logged_in_cant_create_sport() {
		$this->post(action('Admin\SportsController@store'))->assertRedirect(action('Auth\LoginController@showLoginForm'));
	}
	
	
	public function test_admin_can_create_sport() {
		$this->actingAs($this->admin)->post(action('Admin\SportsController@store'), [
			'name' => 'name'
		])->assertSuccessful()->assertJson([
			'name' => 'name'
		]);
		
		$this->assertDatabaseHas('sports', [
			'name' => 'name'
		]);
	}
	
	public function test_admin_create_sport_validation() {
		$this->actingAs($this->admin)->post(action('Admin\SportsController@store'), [
			'name' => ''
		])->assertSessionHasErrors('name');
		
		$sport = factory(Sport::class)->create();
		$this->actingAs($this->admin)->post(action('Admin\SportsController@store'), [
			'name' => $sport->name
		])->assertSessionHasErrors('name');
		
	}
}
