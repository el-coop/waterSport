<?php

namespace Tests\Feature\Competitor;

use App\Events\CompetitorSubmitted;
use App\Models\Admin;
use App\Models\Competitor;
use App\Models\PracticeDay;
use App\Models\Sport;
use App\Models\SportField;
use App\Models\User;
use ElCoop\HasFields\Models\Field;
use Event;
use Notification;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UpdateTest extends TestCase {
	
	use RefreshDatabase;
	
	private $admin;
	private $competitor;
	private $sport;
	private $practiceDays;
	private $field;
	private $competitorField;
	
	public function setUp(): void {
		parent::setUp();
		$this->admin = factory(User::class)->make();
		factory(Admin::class)->create()->user()->save($this->admin);
		$this->competitor = factory(User::class)->make();
		factory(Competitor::class)->create()->user()->save($this->competitor);
		$this->sport = factory(Sport::class)->create();
		$this->practiceDays = factory(PracticeDay::class, 2)->create([
			'sport_id' => $this->sport->id
		]);
		$this->field = factory(SportField::class)->create([
			'sport_id' => $this->sport->id
		]);
		
		$this->competitor->user->sports()->sync([$this->sport->id => [
			'data' => [
				$this->field->id => 'gla'
			],
			'practice_day_id' => $this->practiceDays->first()->id
		]]);
		
		$this->competitorField = factory(Field::class)->create();
		
	}
	
	public function test_guest_cant_view_competitor_profile() {
		$this->get(action('CompetitorController@edit'))->assertRedirect(action('Auth\LoginController@showLoginForm'));
	}
	
	public function test_admin_cant_view_competitor_profile() {
		$this->actingAs($this->admin)->get(action('CompetitorController@edit'))->assertForbidden();
	}
	
	public function test_competitor_can_view_competitor_page() {
		$this->actingAs($this->competitor)->get(action('CompetitorController@edit'))->assertSuccessful()->assertViewIs('competitor.view');
	}
	
	
	public function test_guest_cant_update_competitor_profile() {
		$this->patch(action('CompetitorController@update'))->assertRedirect(action('Auth\LoginController@showLoginForm'));
	}
	
	public function test_admin_cant_post_registration_form() {
		$this->actingAs($this->admin)->patch(action('CompetitorController@update'))->assertForbidden();
	}
	
	public function test_competitor_can_update_himself() {
		$this->actingAs($this->competitor)->patch(action('CompetitorController@update'), [
			'name' => 'name',
			'email' => $this->competitor->email,
			'language' => 'en',
			'competitor' => [
				$this->competitorField->id => 'gla'
			],
			'sports' => [
				$this->sport->id => [
					$this->sport->id,
					'practiceDay' => $this->practiceDays->last()->id,
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
			'email' => $this->competitor->email,
			'language' => 'en',
			'user_type' => Competitor::class,
			'user_id' => $this->competitor->user->id
		]);
		
		$this->assertDatabaseHas('competitor_sport', [
			'sport_id' => $this->sport->id,
			'practice_day_id' => $this->practiceDays->last()->id,
			'competitor_id' => $this->competitor->user->id,
			'data' => json_encode([
				$this->field->id => 'yes'
			])
		]);
		
	}
	
	public function test_competitor_can_submit_himself() {
		Event::fake();
		$this->actingAs($this->competitor)->patch(action('CompetitorController@update'), [
			'name' => 'name',
			'email' => $this->competitor->email,
			'language' => 'en',
			'competitor' => [
				$this->competitorField->id => 'gla'
			],
			'validate' => true,
			'sports' => [
				$this->sport->id => [
					$this->sport->id,
					'practiceDay' => $this->practiceDays->last()->id,
					$this->field->id => 'yes'
				]
			
			]
		])->assertRedirect()->assertSessionHas('toast', [
			'type' => 'success',
			'title' => '',
			'message' => __('vue.updateSuccess', [], 'en')
		])->assertSessionHas('fireworks');
		
		$this->assertDatabaseHas('competitors', [
			'id' => $this->competitor->user->id,
			'data' => json_encode([
				$this->competitorField->id => 'gla'
			]),
			'submitted' => true
		]);
		
		$this->assertDatabaseHas('users', [
			'name' => 'name',
			'email' => $this->competitor->email,
			'language' => 'en',
			'user_type' => Competitor::class,
			'user_id' => $this->competitor->user->id
		]);
		
		$this->assertDatabaseHas('competitor_sport', [
			'sport_id' => $this->sport->id,
			'practice_day_id' => $this->practiceDays->last()->id,
			'competitor_id' => $this->competitor->user->id,
			'data' => json_encode([
				$this->field->id => 'yes'
			])
		]);
		
		Event::assertDispatched(CompetitorSubmitted::class, function ($event) {
			return $event->competitor->id == $this->competitor->user->id;
		});
	}
	
	public function test_competitor_submitted_email_sent() {
		Notification::fake();
		
		event(new CompetitorSubmitted($this->competitor->user));
		
		Notification::assertSentTo($this->competitor, \App\Notifications\Competitor\CompetitorSubmitted::class);
	}
	
	
	public function test_validates_update_form() {
		$this->actingAs($this->competitor)->patch(action('CompetitorController@update'), [
			'name' => '',
			'email' => "gla",
			'language' => 'dla',
			'sports' => [
				$this->sport->id => [
					0,
					'practiceDay' => 0,
					$this->field->id => 'yes'
				]
			]
		])->assertRedirect()->assertSessionHasErrors(['name', 'email', 'language', "sports.{$this->sport->id}.practiceDay", "sports.{$this->sport->id}.0"]);
	}
}
