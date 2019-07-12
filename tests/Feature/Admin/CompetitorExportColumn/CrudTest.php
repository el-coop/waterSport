<?php

namespace Tests\Feature\Admin\CompetitorExportColumn;

use App\Models\Admin;
use App\Models\CompetitionDay;
use App\Models\Competitor;
use App\Models\CompetitorExportColumn;
use App\Models\PracticeDay;
use App\Models\Sport;
use App\Models\SportManager;
use App\Models\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CrudTest extends TestCase {
	use RefreshDatabase;

	private $admin;
	private $competitor;
	private $sportManager;
	private $competitionDay;
	private $practiceDay;
	private $exportColumns;

	public function setUp(): void {
		parent::setUp();
		$this->admin = factory(User::class)->make();
		factory(Admin::class)->create()->user()->save($this->admin);
		$this->competitor = factory(User::class)->make();
		factory(Competitor::class)->create()->user()->save($this->competitor);
		$this->sportManager = factory(User::class)->make();
		factory(SportManager::class, 1)->make()->each(function ($manager) {
			$sport = factory(Sport::class)->create();
			$sport->sportManagers()->save($manager);
			$manager->user()->save($this->sportManager);
			$this->practiceDay = factory(PracticeDay::class)->create([
				'sport_id' => Sport::first()->id
			]);
			$this->competitionDay = factory(CompetitionDay::class)->create([
				'sport_id' => Sport::first()->id
			]);
		});
		$this->competitor->user->practiceDays()->attach($this->practiceDay->id);
		$this->competitor->user->competitionDays()->attach($this->competitionDay->id);
		$this->competitor->user->sports()->attach(Sport::first()->id, ['data' => 'test']);
		$i = 1;
		$this->exportColumns = factory(CompetitorExportColumn::class,3)->make()->each(function ($exportColumn) use (&$i){
			$exportColumn->order = $i;
			$i +=1;
			$exportColumn->save();
		});
	}


	public function test_guest_cant_get_page() {
		$this->get(action('Admin\CompetitorExportColumnController@show'))->assertRedirect(action('Auth\LoginController@login'));
	}

	public function test_competitor_cant_get_page() {
		$this->actingAs($this->competitor)->get(action('Admin\CompetitorExportColumnController@show'))->assertForbidden();
	}

	public function test_sport_manager_cant_get_page() {
		$this->actingAs($this->sportManager)->get(action('Admin\CompetitorExportColumnController@show'))->assertForbidden();
	}

	public function test_admin_can_get_page() {
		$this->actingAs($this->admin)->get(action('Admin\CompetitorExportColumnController@show'))->assertSuccessful();
	}

	public function test_guest_cant_create_export_column() {
		$this->post(action('Admin\CompetitorExportColumnController@create'))->assertRedirect(action('Auth\LoginController@login'));
	}

	public function test_competitor_cant_create_export_column() {
		$this->actingAs($this->competitor)->post(action('Admin\CompetitorExportColumnController@create'))->assertForbidden();
	}

	public function test_sport_manager_cant_create_export_column() {
		$this->actingAs($this->sportManager)->post(action('Admin\CompetitorExportColumnController@create'))->assertForbidden();
	}

	public function test_admin_can_create_export_column() {
		$this->actingAs($this->admin)->post(action('Admin\CompetitorExportColumnController@create'), [
			'name' => 'name',
			'column' => 'user.name'
		])->assertSuccessful();
		$this->assertDatabaseHas('competitor_export_columns', [
			'name' => 'name',
			'column' => 'user.name'
		]);
	}

	public function test_guest_cant_update_export_column() {
		$this->patch(action('Admin\CompetitorExportColumnController@update', $this->exportColumns->first()))->assertRedirect(action('Auth\LoginController@login'));
	}

	public function test_competitor_cant_update_export_column() {
		$this->actingAs($this->competitor)->patch(action('Admin\CompetitorExportColumnController@update', $this->exportColumns->first()))->assertForbidden();
	}

	public function test_sport_manager_cant_update_export_column() {
		$this->actingAs($this->sportManager)->patch(action('Admin\CompetitorExportColumnController@update', $this->exportColumns->first()))->assertForbidden();
	}

	public function test_admin_can_update_export_column() {
		$this->actingAs($this->admin)->patch(action('Admin\CompetitorExportColumnController@update', $this->exportColumns->first()), [
			'name' => 'name',
			'column' => 'user.name'
		])->assertSuccessful();
		$this->assertDatabaseHas('competitor_export_columns', [
			'name' => 'name',
			'column' => 'user.name',
			'id' => $this->exportColumns->first()->id
		]);
	}

	public function test_guest_cant_delete_export_column() {
		$this->delete(action('Admin\CompetitorExportColumnController@destroy', $this->exportColumns->first()))->assertRedirect(action('Auth\LoginController@login'));
	}

	public function test_competitor_cant_delete_export_column() {
		$this->actingAs($this->competitor)->delete(action('Admin\CompetitorExportColumnController@destroy', $this->exportColumns->first()))->assertForbidden();
	}

	public function test_sport_manager_cant_delete_export_column() {
		$this->actingAs($this->sportManager)->delete(action('Admin\CompetitorExportColumnController@destroy', $this->exportColumns->first()))->assertForbidden();
	}

	public function test_admin_can_delete_export_column() {
		$this->actingAs($this->admin)->delete(action('Admin\CompetitorExportColumnController@destroy', $this->exportColumns->first()))->assertSuccessful();
		$this->assertDatabaseMissing('competitor_export_columns', [
			'id' => $this->exportColumns->first()->id
		]);
	}

	public function test_guest_cant_order_export_columns() {
		$this->patch(action('Admin\CompetitorExportColumnController@saveOrder'))->assertRedirect(action('Auth\LoginController@login'));
	}

	public function test_competitor_cant_order_export_columns() {
		$this->actingAs($this->competitor)->patch(action('Admin\CompetitorExportColumnController@saveOrder'))->assertForbidden();
	}

	public function test_sport_manager_cant_order_export_columns() {
		$this->actingAs($this->sportManager)->patch(action('Admin\CompetitorExportColumnController@saveOrder'))->assertForbidden();
	}

	public function test_admin_can_order_export_columns() {
		$newOrder = $this->exportColumns->pluck('id')->shuffle()->toArray();
		$this->actingAs($this->admin)->patch(action('Admin\CompetitorExportColumnController@saveOrder'),[
			'order' => $newOrder
		])->assertSuccessful();
		$order = CompetitorExportColumn::orderBy('order')->get()->pluck('id')->toArray();
		$this->assertEquals($newOrder,$order);
	}
}
