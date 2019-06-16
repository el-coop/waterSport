<?php

namespace Tests\Feature\Competitor;

use App\Events\CompetitorSubmitted;
use App\Models\Admin;
use App\Models\Competitor;
use App\Models\PracticeDay;
use App\Models\Sport;
use App\Models\SportField;
use App\Models\User;
use App\Notifications\Competitor\CompetitorCreated;
use ElCoop\HasFields\Models\Field;
use Event;
use Illuminate\Auth\Notifications\ResetPassword;
use Notification;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RegistrationTest extends TestCase {
	
	use RefreshDatabase;
	
	private $admin;
	private $competitor;
	private $field;
	
	public function setUp(): void {
		parent::setUp();
		$this->admin = factory(User::class)->make();
		factory(Admin::class)->create()->user()->save($this->admin);
		$this->competitor = factory(User::class)->make();
		factory(Competitor::class)->create()->user()->save($this->competitor);
		
		$this->field = factory(Field::class)->create();
	}
	
	
	public function test_admin_cant_view_registration_form() {
		$this->actingAs($this->admin)->get(action('Auth\RegisterController@showRegistrationForm'))->assertRedirect(action('Admin\SportsController@index'));
	}
	
	public function test_competitor_cant_view_registration_form() {
		$this->actingAs($this->competitor)->get(action('Auth\RegisterController@showRegistrationForm'))->assertRedirect(action('CompetitorController@edit'));
	}
	
	public function test_guest_can_view_registration_form() {
		$this->get(action('Auth\RegisterController@showRegistrationForm'))->assertSuccessful()
			->assertViewIs('auth.register');
	}
	
	public function test_admin_cant_post_registration_form() {
		$this->actingAs($this->admin)->post(action('Auth\RegisterController@register'))->assertRedirect(action('Admin\SportsController@index'));
	}
	
	public function test_competitor_cant_post_registration_form() {
		$this->actingAs($this->competitor)->post(action('Auth\RegisterController@register'))->assertRedirect(action('CompetitorController@edit'));
	}
	
	public function test_guest_can_post_registration_form() {
		Notification::fake();
		$sport = factory(Sport::class)->create();
		$practiceDay = factory(PracticeDay::class)->create([
			'sport_id' => $sport->id
		]);
		$field = factory(SportField::class)->create([
			'sport_id' => $sport->id
		]);
		$this->post(action('Auth\RegisterController@register'), [
			'name' => 'name',
			'lastName' => 'last',
			'email' => 'email@email.com',
			'language' => 'en',
			'competitor' => [
				$this->field->id => 'gla'
			],
			'sports' => [
				$sport->id => [
					$sport->id,
					'practiceDays' => [$practiceDay->id],
					$field->id => 'yes'
				]
			
			]
		])->assertRedirect(action('Auth\LoginController@showLoginForm'));
		
		$competitor = Competitor::find(Competitor::max('id'));
		
		$this->assertDatabaseHas('competitors', [
			'id' => $competitor->id,
			'data' => json_encode([
				$this->field->id => 'gla'
			])
		]);
		
		$this->assertDatabaseHas('users', [
			'name' => 'name',
			'last_name' => 'last',
			'email' => 'email@email.com',
			'language' => 'en',
			'user_type' => Competitor::class
		]);
		
		$this->assertDatabaseHas('competitor_sport', [
			'sport_id' => $sport->id,
			'competitor_id' => $competitor->id,
			'data' => json_encode([
				$field->id => 'yes'
			])
		]);
		
		$this->assertDatabaseHas('competitor_practice_day',[
			'competitor_id' => $competitor->id,
			'practice_day_id' => $practiceDay->id
		]);
		
		Notification::assertSentTo(User::where('email', 'email@email.com')->first(), CompetitorCreated::class);
	}
	
	public function test_validates_registration_form() {
		$sport = factory(Sport::class)->create();
		
		$this->post(action('Auth\RegisterController@register'), [
			'name' => '',
			'email' => 'email',
			'language' => 'gla',
			'sports' => [
				$sport->id => [
					'practiceDays' => [0]
				]
			]
		])->assertRedirect()->assertSessionHasErrors(['name', 'email', 'language', "sports.{$sport->id}.practiceDays.0", "sports.{$sport->id}.0"]);
	}
	
}
