<?php

namespace Tests\Feature\Admin\SportManager;

use App\Models\Admin;
use App\Models\Competitor;
use App\Models\Sport;
use App\Models\SportManager;
use App\Models\User;
use Tests\TestCase;
use Illuminate\Auth\Notifications\ResetPassword;
use Notification;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CrudTest extends TestCase {

	use RefreshDatabase;

	private $admin;
	private $competitor;
	private $sportManager;

	public function setUp(): void {
		parent::setUp();
		$this->admin = factory(User::class)->make();
		factory(Admin::class)->create()->user()->save($this->admin);
		$this->competitor = factory(User::class)->make();
		factory(Competitor::class)->create()->user()->save($this->competitor);
		$this->sportManager = factory(User::class)->make();
		factory(SportManager::class,1)->make()->each(function ($manager){
			$sport = factory(Sport::class)->create();
			$sport->sportManagers()->save($manager);
			$manager->user()->save($this->sportManager);
		});
	}

	public function test_guest_cant_see_page() {
		$this->get(action('Admin\SportManagerController@index'))->assertRedirect(action('Auth\LoginController@login'));
	}

	public function test_competitor_cant_see_page() {
		$this->actingAs($this->competitor)->get(action('Admin\SportManagerController@index'))->assertForbidden();
	}

	public function test_sport_manager_cant_see_page() {
		$this->actingAs($this->sportManager)->get(action('Admin\SportManagerController@index'))->assertForbidden();
	}

	public function test_admin_can_see_page() {
		$this->actingAs($this->admin)->get(action('Admin\SportManagerController@index'))->assertSuccessful();
	}

	public function test_guest_cant_see_create_form() {
		$this->get(action('Admin\SportManagerController@edit'))->assertRedirect(action('Auth\LoginController@login'));
	}

	public function test_competitor_cant_see_create_form() {
		$this->actingAs($this->competitor)->get(action('Admin\SportManagerController@edit'))->assertForbidden();
	}

	public function test_sport_manager_cant_see_create_form() {
		$this->actingAs($this->sportManager)->get(action('Admin\SportManagerController@edit'))->assertForbidden();
	}

	public function test_admin_can_see_create_form() {
		$this->actingAs($this->admin)->get(action('Admin\SportManagerController@edit'))->assertSuccessful()->assertJsonFragment([
			'name' => 'name'
		]);
	}

	public function test_guest_cant_create_sport_manager() {
		$this->post(action('Admin\SportManagerController@store'))->assertRedirect(action('Auth\LoginController@login'));
	}

	public function test_competitor_cant_create_sport_manager() {
		$this->actingAs($this->competitor)->post(action('Admin\SportManagerController@store'))->assertForbidden();
	}

	public function test_sport_manager_cant_create_sport_manager() {
		$this->actingAs($this->sportManager)->post(action('Admin\SportManagerController@store'))->assertForbidden();
	}

	public function test_admin_can_create_sport_manager() {
		Notification::fake();
		$sport = Sport::first();
		$this->actingAs($this->admin)->post(action('Admin\SportManagerController@store'),[
			'name' => 'name',
			'email' => 'test@test.com',
			'language' => 'en',
			'sport' => $sport->id
		])->assertSuccessful()->assertJsonFragment([
			'name' => 'name',
			'email' => 'test@test.com',
			'sport' => $sport->name
		]);
		$this->assertDatabaseHas('users', [
			'name' => 'name',
			'email' => 'test@test.com',
			'language' => 'en',
			'user_type' => SportManager::class
		]);
		$manager = User::where('email', 'test@test.com')->first();
		Notification::assertSentTo($manager, ResetPassword::class);
		$this->assertDatabaseHas('sport_managers', [
			'sport_id' => $sport->id,
			'id' => $manager->user->id
		]);
	}

	public function test_create_validation() {
		$this->actingAs($this->admin)->post(action('Admin\SportManagerController@store'),[
			'name' => '',
			'email' => 'test',
			'language' => 'de',
			'sport' => 'g'
		])->assertSessionHasErrors(['name', 'email', 'language', 'sport']);
	}

	public function test_guest_cant_update_sport_manager() {
		$this->patch(action('Admin\SportManagerController@update', $this->sportManager->user))->assertRedirect(action('Auth\LoginController@login'));
	}

	public function test_competitor_cant_update_sport_manager() {
		$this->actingAs($this->competitor)->patch(action('Admin\SportManagerController@update', $this->sportManager->user))->assertForbidden();
	}

	public function test_sport_manager_cant_update_sport_manager() {
		$this->actingAs($this->sportManager)->patch(action('Admin\SportManagerController@update', $this->sportManager->user))->assertForbidden();
	}

	public function test_admin_can_update_sport_manager() {
		$sport = factory(Sport::class)->create();
		$this->actingAs($this->admin)->patch(action('Admin\SportManagerController@update', $this->sportManager->user),[
			'name' => 'name',
			'email' => 'test@test.com',
			'language' => 'en',
			'sport' => $sport->id
		])->assertSuccessful()->assertJsonFragment([
			'name' => 'name',
			'email' => 'test@test.com',
			'sport' => $sport->name
		]);
		$this->assertDatabaseHas('users', [
			'name' => 'name',
			'email' => 'test@test.com',
			'language' => 'en',
			'user_type' => SportManager::class,
			'id' => $this->sportManager->id
		]);
		$this->assertDatabaseHas('sport_managers', [
			'sport_id' => $sport->id,
			'id' => $this->sportManager->user->id
		]);
	}

	public function test_update_validation() {
		$this->actingAs($this->admin)->patch(action('Admin\SportManagerController@update', $this->sportManager->user),[
			'name' => '',
			'email' => 'test',
			'language' => 'de',
			'sport' => 'g'
		])->assertSessionHasErrors(['name', 'email', 'language', 'sport']);
	}


	public function test_guest_cant_delete_sport_manager() {
		$this->delete(action('Admin\SportManagerController@destroy', $this->sportManager->user))->assertRedirect(action('Auth\LoginController@login'));
	}

	public function test_competitor_cant_delete_sport_manager() {
		$this->actingAs($this->competitor)->delete(action('Admin\SportManagerController@destroy', $this->sportManager->user))->assertForbidden();
	}

	public function test_sport_manager_cant_delete_sport_manager() {
		$this->actingAs($this->sportManager)->delete(action('Admin\SportManagerController@destroy', $this->sportManager->user))->assertForbidden();
	}

	public function test_admin_can_delete_sport_manager() {
		$sport = factory(Sport::class)->create();
		$this->actingAs($this->admin)->delete(action('Admin\SportManagerController@destroy', $this->sportManager->user))->assertSuccessful();
		$this->assertDatabaseMissing('users', [
			'id' => $this->sportManager->id
		]);
		$this->assertDatabaseMissing('sport_managers', [
			'id' => $this->sportManager->user->id
		]);
	}
}
