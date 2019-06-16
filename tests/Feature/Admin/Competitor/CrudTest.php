<?php

namespace Tests\Feature\Admin\Competitor;

use App\Models\Admin;
use App\Models\Competitor;
use App\Models\PracticeDay;
use App\Models\Sport;
use App\Models\SportField;
use App\Models\User;
use App\Notifications\Competitor\CompetitorCreated;
use ElCoop\HasFields\Models\Field;
use Illuminate\Auth\Notifications\ResetPassword;
use Notification;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CrudTest extends TestCase {
	use RefreshDatabase;
	
	private $admin;
	private $competitor;
	private $competitorField;
	private $practiceDays;
	private $sport;
	private $field;
	
	public function setUp(): void {
		parent::setUp();
		$this->admin = factory(User::class)->make();
		factory(Admin::class)->create()->user()->save($this->admin);
		$this->competitor = factory(User::class)->make();
		factory(Competitor::class)->create()->user()->save($this->competitor);
		$this->sport = factory(Sport::class)->create();
		$this->field = factory(SportField::class)->create([
			'sport_id' => $this->sport->id
		]);
		$this->practiceDays = factory(PracticeDay::class, 2)->create([
			'sport_id' => $this->sport->id
		]);
		
		$this->competitor->user->practiceDays()->attach($this->practiceDays->first()->id);
		
		$this->competitorField = factory(Field::class)->create();
	}
	
	public function test_not_logged_in_cant_create_competitor() {
		$this->post(action('Admin\CompetitorController@store'))->assertRedirect(action('Auth\LoginController@showLoginForm'));
	}
	
	public function test_not_logged_in_cant_view_create_sport_form() {
		$this->get(action('Admin\CompetitorController@edit'))->assertRedirect(action('Auth\LoginController@showLoginForm'));
	}
	
	public function test_competitor_cant_create_competitor() {
		$this->actingAs($this->competitor)->post(action('Admin\CompetitorController@store'))->assertForbidden();
	}
	
	public function test_competitor_cant_view_create_competitor_form() {
		$this->actingAs($this->competitor)->get(action('Admin\CompetitorController@edit'))->assertForbidden();
	}
	
	public function test_admin_can_view_create_competitor_form() {
		$this->actingAs($this->admin)->get(action('Admin\CompetitorController@edit'))->assertSuccessful()->assertJsonFragment([
			'name' => 'name',
		]);
	}
	
	public function test_admin_can_create_competitor() {
		Notification::fake();
		$this->actingAs($this->admin)->post(action('Admin\CompetitorController@store'), [
			'name' => 'name',
			'lastName' => 'last',
			'email' => 'test@test.com',
			'language' => 'en'
		])->assertSuccessful()->assertJson([
			'name' => 'name',
			'last_name' => 'last',
			'email' => 'test@test.com',
		]);
		
		$this->assertDatabaseHas('users', [
			'name' => 'name',
			'last_name' => 'last',
			'email' => 'test@test.com',
			'user_type' => Competitor::class
		]);
		Notification::assertSentTo(User::where('email', 'test@test.com')->first(), CompetitorCreated::class);
	}
	
	public function test_create_competitor_validation() {
		$this->actingAs($this->admin)->post(action('Admin\CompetitorController@store'), [
			'name' => '',
			'email' => 'test',
			'language' => 'de'
		])->assertSessionHasErrors(['name', 'email', 'language']);
	}
	
	public function test_not_logged_in_cant_update_competitor() {
		$this->patch(action('Admin\CompetitorController@update', $this->competitor->user))->assertRedirect(action('Auth\LoginController@showLoginForm'));
	}
	
	
	public function test_competitor_cant_update_competitor() {
		$this->actingAs($this->competitor)->patch(action('Admin\CompetitorController@update', $this->competitor->user))->assertForbidden();
	}
	
	
	public function test_admin_can_update_competitor() {
		$this->actingAs($this->admin)->patch(action('Admin\CompetitorController@update', $this->competitor->user), [
			'name' => 'name',
			'lastName' => 'last',
			'email' => 'test@test.com',
			'language' => 'en',
			'competitor' => ['data' => 'test']
		])->assertSuccessful()->assertJson([
			'name' => 'name',
			'last_name' => 'last',
			'email' => 'test@test.com',
		]);
		
		$this->assertDatabaseHas('users', [
			'name' => 'name',
			'last_name' => 'last',
			'email' => 'test@test.com',
			'user_type' => Competitor::class,
			'id' => $this->competitor->id
		]);
		
		$this->assertDatabaseHas('competitors', [
			'id' => $this->competitor->user->id,
			'data' => json_encode([
				'data' => 'test'
			])
		]);
	}
	
	public function test_update_competitor_validation() {
		$this->actingAs($this->admin)->patch(action('Admin\CompetitorController@update', $this->competitor->user), [
			'name' => '',
			'email' => 'test',
			'language' => 'de',
			'competitor' => 'test'
		])->assertSessionHasErrors(['name', 'email', 'language', 'competitor']);
	}
	
	public function test_not_logged_in_cant_update_competitor_form() {
		$this->patch(action('Admin\CompetitorController@updateForm', $this->competitor->user))->assertRedirect(action('Auth\LoginController@showLoginForm'));
	}
	
	
	public function test_competitor_cant_update_competitor_form() {
		$this->actingAs($this->competitor)->patch(action('Admin\CompetitorController@updateForm', $this->competitor->user))->assertForbidden();
	}
	
	
	public function test_admin_can_update_competitor_form() {
		$this->actingAs($this->admin)->patch(action('Admin\CompetitorController@updateForm', $this->competitor->user), [
			'name' => 'name',
			'lastName' => 'last',
			'email' => $this->competitor->email,
			'language' => 'en',
			'competitor' => [
				$this->competitorField->id => 'gla'
			],
			'sports' => [
				$this->sport->id => [
					$this->sport->id,
					'practiceDays' => [$this->practiceDays->last()->id],
					$this->field->id => 'yes'
				]
			
			]
		])->assertRedirect()->assertSessionHas('toast', [
			'type' => 'success',
			'title' => '',
			'message' => __('vue.updateSuccess', [], 'en')
		]);
		
		$this->assertDatabaseHas('competitors', [
			'id' => $this->competitor->user->id,
			'data' => json_encode([
				$this->competitorField->id => 'gla'
			])
		]);
		
		$this->assertDatabaseHas('users', [
			'name' => 'name',
			'last_name' => 'last',
			'email' => $this->competitor->email,
			'language' => 'en',
			'user_type' => Competitor::class,
			'user_id' => $this->competitor->user->id
		]);
		
		$this->assertDatabaseHas('competitor_sport', [
			'sport_id' => $this->sport->id,
			'competitor_id' => $this->competitor->user->id,
			'data' => json_encode([
				$this->field->id => 'yes'
			])
		]);
		
		
		$this->assertDatabaseHas('competitor_practice_day', [
			'competitor_id' => $this->competitor->user->id,
			'practice_day_id' => $this->practiceDays->last()->id
		]);
	}
	
	public function test_update_competitor_validation_form() {
		$this->actingAs($this->admin)->patch(action('Admin\CompetitorController@updateForm', $this->competitor->user), [
			'name' => '',
			'email' => "gla",
			'language' => 'dla',
			'sports' => [
				$this->sport->id => [
					0,
					'practiceDays' => [0],
					$this->field->id => 'yes'
				]
			]
		])->assertRedirect()->assertSessionHasErrors(['name', 'email', 'language', "sports.{$this->sport->id}.practiceDays.0", "sports.{$this->sport->id}.0"]);
	}
	
	public function test_not_logged_in_cant_delete_competitor() {
		$this->delete(action('Admin\CompetitorController@destroy', $this->competitor->user))->assertRedirect(action('Auth\LoginController@showLoginForm'));
	}
	
	
	public function test_competitor_cant_delete_competitor() {
		$this->actingAs($this->competitor)->delete(action('Admin\CompetitorController@destroy', $this->competitor->user))->assertForbidden();
	}
	
	
	public function test_admin_can_delete_competitor() {
		$this->actingAs($this->admin)->delete(action('Admin\CompetitorController@destroy', $this->competitor->user))->assertSuccessful();
		
		$this->assertDatabaseMissing('users', [
			'user_type' => Competitor::class,
			'id' => $this->competitor->id
		]);
		
		$this->assertDatabaseMissing('competitors', [
			'id' => $this->competitor->user->id,
		]);
	}
}
