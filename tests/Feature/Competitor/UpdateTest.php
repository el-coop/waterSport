<?php

namespace Tests\Feature\Competitor;

use App\Events\CompetitorSubmitted;
use App\Models\Admin;
use App\Models\CompetitionDay;
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
	private $competitionDays;
	
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
		$this->competitionDays = factory(CompetitionDay::class, 2)->create([
			'sport_id' => $this->sport->id
		]);
		$this->field = factory(SportField::class)->create([
			'sport_id' => $this->sport->id
		]);
		
		$this->competitor->user->sports()->sync([$this->sport->id => [
			'data' => [
				$this->field->id => 'gla'
			],
		]]);
		
		$this->competitor->user->practiceDays()->attach($this->practiceDays->first()->id);
		$this->competitor->user->competitionDays()->attach($this->competitionDays->last()->id);
		
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
					'competitionDays' => [$this->competitionDays->first()->id],
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
		
		
		$this->assertDatabaseHas('competitor_practice_day',[
			'competitor_id' =>  $this->competitor->user->id,
			'practice_day_id' => $this->practiceDays->last()->id
		]);
		
		$this->assertDatabaseHas('competition_day_competitor',[
			'competitor_id' =>  $this->competitor->user->id,
			'competition_day_id' => $this->competitionDays->first()->id
		]);
		
	}
	
	public function test_validates_update_form() {
		$this->actingAs($this->competitor)->patch(action('CompetitorController@update'), [
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
    
    public function test_cant_register_to_practice_day_over_the_limit() {
        $practiceDay = $this->practiceDays->last();
        $practiceDay->max_participants = 0;
        $practiceDay->save();
        $this->actingAs($this->competitor)->patch(action('CompetitorController@update'), [
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
                    'practiceDays' => [$practiceDay->id],
                    'competitionDays' => [$this->competitionDays->first()->id],
                    $this->field->id => 'yes'
                ]
            ]
        ])->assertRedirect()->assertSessionHasErrors(['fullDays']);
    }
    
    public function test_can_register_to_practice_day_over_the_limit_when_already_member() {
        $practiceDay = $this->practiceDays->last();
        $practiceDay->max_participants = 1;
        $practiceDay->save();
        $practiceDay->competitors()->attach($this->competitor->user);
        $this->actingAs($this->competitor)->patch(action('CompetitorController@update'), [
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
                    'practiceDays' => [$practiceDay->id],
                    'competitionDays' => [$this->competitionDays->first()->id],
                    $this->field->id => 'yes'
                ]
            ]
        ])->assertRedirect()->assertSessionHas('toast', [
            'type' => 'success',
            'title' => '',
            'message' => __('vue.updateSuccess', [], 'en')
        ]);
        
        $this->assertDatabaseHas('competitor_practice_day',[
            'competitor_id' =>  $this->competitor->user->id,
            'practice_day_id' => $practiceDay->id
        ]);
    }
    
    public function test_cant_register_to_competition_day_over_the_limit() {
        $competitionDay = $this->competitionDays->first();
        $competitionDay->max_participants = 0;
        $competitionDay->save();
        $this->actingAs($this->competitor)->patch(action('CompetitorController@update'), [
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
                    'competitionDays' => [$competitionDay->id],
                    $this->field->id => 'yes'
                ]
            ]
        ])->assertRedirect()->assertSessionHasErrors(['fullDays']);
    }
    
    public function test_can_register_to_competition_day_over_the_limit_when_already_member() {
        $competitionDay = $this->competitionDays->first();
        $competitionDay->max_participants = 0;
        $competitionDay->save();
        $competitionDay->competitors()->attach($this->competitor->user);
        $this->actingAs($this->competitor)->patch(action('CompetitorController@update'), [
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
                    'competitionDays' => [$competitionDay->id],
                    $this->field->id => 'yes'
                ]
            ]
        ])->assertRedirect()->assertSessionHas('toast', [
            'type' => 'success',
            'title' => '',
            'message' => __('vue.updateSuccess', [], 'en')
        ]);
        
        $this->assertDatabaseHas('competition_day_competitor',[
            'competitor_id' =>  $this->competitor->user->id,
            'competition_day_id' => $competitionDay->id
        ]);
    }
}
