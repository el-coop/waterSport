<?php

namespace Tests\Feature\Admin\SportFields;

use App\Models\Admin;
use App\Models\Sport;
use App\Models\SportField;
use App\Models\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CrudTest extends TestCase {
	use RefreshDatabase;

	private $admin;
	private $sport;
	private $sportField;

	public function setUp(): void {
		parent::setUp();
		$this->admin = factory(User::class)->make();
		factory(Admin::class)->create()->user()->save($this->admin);
		$this->sport = factory(Sport::class)->create();
		$this->sportField = factory(SportField::class)->make();
		$this->sport->fields()->save($this->sportField);
	}

	public function test_not_logged_cant_create_sport_field() {
		$this->post(action('Admin\SportFieldsController@store', $this->sport))->assertRedirect(action('Auth\LoginController@login'));
	}

	public function test_admin_can_create_sport_field() {
		$this->actingAs($this->admin)->post(action('Admin\SportFieldsController@store', $this->sport), [
			'name_en' => 'name en',
			'name_nl' => 'name nl',
			'type' => 'text'
		])->assertSuccessful()->assertJsonFragment([
			'name_en' => 'name en',
		]);
		$this->assertDatabaseHas('sport_fields', [
			'name_en' => 'name en',
			'name_nl' => 'name nl',
			'type' => 'text',
			'sport_id' => $this->sport->id
		]);
	}

	public function test_not_logged_cant_delete_sport_field() {
		$this->delete(action('Admin\SportFieldsController@destroy', [$this->sport, $this->sportField]))->assertRedirect(action('Auth\LoginController@login'));
	}

	public function test_admin_can_delete_sport_field() {
		$this->actingAs($this->admin)->delete(action('Admin\SportFieldsController@destroy', [$this->sport, $this->sportField]))->assertSuccessful();
		$this->assertDatabaseMissing('sport_fields', [
			'id' => $this->sportField->id
		]);
	}

	public function test_not_logged_cant_update_sport_field() {
		$this->patch(action('Admin\SportFieldsController@update', [$this->sport, $this->sportField]))->assertRedirect(action('Auth\LoginController@login'));
	}

	public function test_admin_can_update_sport_field() {
		$this->actingAs($this->admin)->patch(action('Admin\SportFieldsController@update', [$this->sport, $this->sportField]), [
			'name_en' => 'name en',
			'name_nl' => 'name nl',
			'type' => 'checkbox'
		])->assertSuccessful()->assertJsonFragment([
			'name_en' => 'name en',
		]);
		$this->assertDatabaseHas('sport_fields', [
			'name_en' => 'name en',
			'name_nl' => 'name nl',
			'type' => 'checkbox',
			'id' => $this->sportField->id,
			'sport_id' => $this->sport->id
		]);
	}

	public function test_create_sport_field_validation() {
		$this->actingAs($this->admin)->post(action('Admin\SportFieldsController@store', $this->sport), [
			'name_en' => '',
			'name_nl' => '',
			'type' => 'test'
		])->assertSessionHasErrors(['name_en', 'name_nl', 'type']);
	}
}
