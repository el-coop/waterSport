<?php

namespace Tests\Feature\Admin\Settings;

use App\Models\Admin;
use App\Models\Competitor;
use App\Models\User;
use ElCoop\Valuestore\Valuestore;
use Tests\TestCase;
use Illuminate\Support\Facades\Storage;

use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SettingsTest extends TestCase {

	use WithFaker;
	private $admin;
	private $competitor;

	public function setUp(): void {
		parent::setUp();
		$this->admin = factory(User::class)->make();
		factory(Admin::class)->create()->user()->save($this->admin);
		$this->competitor = factory(User::class)->make();
		factory(Competitor::class)->create()->user()->save($this->competitor);
		Storage::fake('local');
		Storage::disk('local')->put('test.valuestore.json', '');
		$path = Storage::path('test.valuestore.json');
		$this->app->singleton('settings', function ($app) use ($path) {
			return new Valuestore($path);
		});
		$faker = $this->faker;
		$settings = app('settings');
		$settings->put('login_text_en', $faker->paragraph);
		$settings->put('login_text_nl', $faker->paragraph);
	}


	public function test_guest_cant_see_settings_page() {
		$this->get(action('Admin\SettingsController@show'))->assertRedirect(action('Auth\LoginController@login'));
	}

	public function test_competitor_cant_see_settings_page() {
		$this->actingAs($this->competitor)->get(action('Admin\SettingsController@show'))->assertForbidden();
	}

	public function test_admin_can_see_settings_page() {
		$this->actingAs($this->admin)->get(action('Admin\SettingsController@show'))->assertSuccessful();
	}

	public function test_guest_cant_update_settings() {
		$this->patch(action('Admin\SettingsController@update'))->assertRedirect(action('Auth\LoginController@login'));
	}

	public function test_competitor_cant_update_settings() {
		$this->actingAs($this->competitor)->patch(action('Admin\SettingsController@update'))->assertForbidden();
	}

	public function test_admin_can_update_settings() {
		$settings = app('settings');
		$this->actingAs($this->admin)->patch(action('Admin\SettingsController@show'), [
			'login_text_en' => 'test text',
			'login_text_nl' => 'test text nl'
		])->assertRedirect();
		$this->assertEquals('test text', $settings->get('login_text_en'));
		$this->assertEquals('test text nl', $settings->get('login_text_nl'));
	}

	public function test_update_settings_validation() {
		$settings = app('settings');
		$this->actingAs($this->admin)->patch(action('Admin\SettingsController@show'), [
		])->assertSessionHasErrors(['login_text_nl', 'login_text_en']);
	}

}
