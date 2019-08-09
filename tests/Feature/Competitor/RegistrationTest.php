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
use App\Notifications\Competitor\CompetitorCreated;
use App\Notifications\SportManager\CompetitorRegistered;
use ElCoop\HasFields\Models\Field;
use Event;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Notifications\AnonymousNotifiable;
use Notification;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RegistrationTest extends TestCase {
    
    use RefreshDatabase;
    
    private $admin;
    private $competitor;
    private $field;
    private $sport;
    private $practiceDay;
    private $competitionDay;
    
    public function setUp(): void {
        parent::setUp();
        $this->admin = factory(User::class)->make();
        factory(Admin::class)->create()->user()->save($this->admin);
        $this->competitor = factory(User::class)->make();
        factory(Competitor::class)->create()->user()->save($this->competitor);
        
        $this->field = factory(Field::class)->create();
        $this->sport = factory(Sport::class)->create();
        $this->practiceDay = factory(PracticeDay::class)->create([
            'sport_id' => $this->sport->id
        ]);
        
        $this->competitionDay = factory(CompetitionDay::class)->create([
            'sport_id' => $this->sport->id
        ]);
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
        Event::fake();
        
        $field = factory(SportField::class)->create([
            'sport_id' => $this->sport->id
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
                $this->sport->id => [
                    $this->sport->id,
                    'practiceDays' => [$this->practiceDay->id],
                    'competitionDays' => [$this->competitionDay->id],
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
            'sport_id' => $this->sport->id,
            'competitor_id' => $competitor->id,
            'data' => json_encode([
                $field->id => 'yes'
            ])
        ]);
        
        $this->assertDatabaseHas('competitor_practice_day', [
            'competitor_id' => $competitor->id,
            'practice_day_id' => $this->practiceDay->id
        ]);
        
        $this->assertDatabaseHas('competition_day_competitor', [
            'competitor_id' => $competitor->id,
            'competition_day_id' => $this->competitionDay->id
        ]);
        
        Event::assertDispatched(CompetitorSubmitted::class, function ($event) use ($competitor) {
            return $event->competitor->id == $competitor->id;
        });
        Notification::assertSentTo(User::where('email', 'email@email.com')->first(), CompetitorCreated::class);
    }
    
    public function test_notification_sent_to_email_after_competitor_submitted_event() {
        Notification::fake();
        
        event(new CompetitorSubmitted($this->competitor->user));
        
        Notification::assertSentTo(new AnonymousNotifiable, CompetitorRegistered::class);
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
    
    public function test_cant_register_to_practice_day_over_the_limit() {
        
        $field = factory(SportField::class)->create([
            'sport_id' => $this->sport->id
        ]);
        
        $this->practiceDay->max_participants = 0;
        $this->practiceDay->save();
        $this->post(action('Auth\RegisterController@register'), [
            'name' => 'name',
            'lastName' => 'last',
            'email' => 'email@email.com',
            'language' => 'en',
            'competitor' => [
                $this->field->id => 'gla'
            ],
            'sports' => [
                $this->sport->id => [
                    $this->sport->id,
                    'practiceDays' => [$this->practiceDay->id],
                    'competitionDays' => [$this->competitionDay->id],
                    $field->id => 'yes'
                ]
            ]
        ])->assertRedirect()->assertSessionHasErrors(['fullDays']);
    }
    
    
    public function test_cant_register_to_competition_day_over_the_limit() {
        
        $field = factory(SportField::class)->create([
            'sport_id' => $this->sport->id
        ]);
        
        $this->competitionDay->max_participants = 0;
        $this->competitionDay->save();
        $this->post(action('Auth\RegisterController@register'), [
            'name' => 'name',
            'lastName' => 'last',
            'email' => 'email@email.com',
            'language' => 'en',
            'competitor' => [
                $this->field->id => 'gla'
            ],
            'sports' => [
                $this->sport->id => [
                    $this->sport->id,
                    'practiceDays' => [$this->practiceDay->id],
                    'competitionDays' => [$this->competitionDay->id],
                    $field->id => 'yes'
                ]
            ]
        ])->assertRedirect()->assertSessionHasErrors(['fullDays']);
    }
}
