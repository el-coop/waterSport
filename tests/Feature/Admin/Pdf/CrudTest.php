<?php

namespace Tests\Feature\Admin\Pdf;

use App\Models\Admin;
use App\Models\Competitor;
use App\Models\Pdf;
use App\Models\Sport;
use App\Models\SportManager;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CrudTest extends TestCase {
	use RefreshDatabase;
	
	private $admin;
	private $competitor;
	private $sportManager;
	protected $pdf;
	
	
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
		});
		Storage::fake('local');
		$pdf = UploadedFile::fake()->create('first.pdf');
		$path = $pdf->store('public/pdf');
		$this->pdf = factory(Pdf::class)->create([
			'name' => 'first',
			'file' => basename($path),
		]);
	}
	
	public function test_guest_cant_see_page() {
		$this->get(action('Admin\PdfController@index'))->assertRedirect(action('Auth\LoginController@login'));
	}
	
	public function test_competitor_cant_see_page() {
		$this->actingAs($this->competitor)->get(action('Admin\PdfController@index'))->assertForbidden();
	}
	
	public function test_sport_manager_cant_see_page() {
		$this->actingAs($this->sportManager)->get(action('Admin\PdfController@index'))->assertForbidden();
	}
	
	public function test_admin_can_see_page() {
		$this->actingAs($this->admin)->get(action('Admin\PdfController@index'))->assertSuccessful();
	}
	
	public function test_guest_cant_create_pdf() {
		$this->post(action('Admin\PdfController@store'))->assertRedirect(action('Auth\LoginController@login'));
	}
	
	public function test_competitor_cant_create_pdf() {
		$this->actingAs($this->competitor)->post(action('Admin\PdfController@store'))->assertForbidden();
	}
	
	public function test_sport_manager_cant_create_pdf() {
		$this->actingAs($this->sportManager)->post(action('Admin\PdfController@store'))->assertForbidden();
	}
	
	public function test_admin_can_upload_pdf() {
		$pdf = UploadedFile::fake()->create('test.pdf');
		$this->actingAs($this->admin)->post(action('Admin\PdfController@store'), [
			'name' => 'newPDF',
			'file' => $pdf,
			'use' => 'registrationEmailPdf'
		])->assertSuccessful();
		
		$this->assertDatabaseHas('pdfs', [
			'name' => 'newPDF',
			'use' => 'registrationEmailPdf'
		]);
		$pdf = Pdf::where('name', 'newPDF')->first();
		Storage::disk('local')->assertExists('public/pdf/' . $pdf->file);
	}
	
	public function test_guest_cant_update_pdf() {
		$this->patch(action('Admin\PdfController@update', $this->pdf))->assertRedirect(action('Auth\LoginController@login'));
	}
	
	public function test_competitor_cant_update_pdf() {
		$this->actingAs($this->competitor)->patch(action('Admin\PdfController@update', $this->pdf))->assertForbidden();
	}
	
	public function test_sport_manager_cant_update_pdf() {
		$this->actingAs($this->sportManager)->patch(action('Admin\PdfController@update', $this->pdf))->assertForbidden();
	}
	
	public function test_admin_can_update_pdf_keeping_same_name() {
		$this->actingAs($this->admin)->patch(action('Admin\PdfController@update', $this->pdf), [
			'name' => 'name',
			'use' => 'homepagePdf'
		])->assertSuccessful();
		$this->assertDatabaseHas('pdfs', [
			'name' => 'name',
			'use' => 'homepagePdf'
		]);
	}
	
	public function test_guest_cant_delete_pdf() {
		$this->delete(action('Admin\PdfController@destroy', $this->pdf))->assertRedirect(action('Auth\LoginController@login'));
	}
	
	public function test_competitor_cant_delete_pdf() {
		$this->actingAs($this->competitor)->delete(action('Admin\PdfController@destroy', $this->pdf))->assertForbidden();
	}
	
	public function test_sport_manager_cant_delete_pdf() {
		$this->actingAs($this->sportManager)->delete(action('Admin\PdfController@destroy', $this->pdf))->assertForbidden();
	}
	
	public function test_admin_can_delete_pdf() {
		$path = $this->pdf->file;
		$this->actingAs($this->admin)->delete(action('Admin\PdfController@destroy', $this->pdf))->assertSuccessful();
		$this->assertDatabaseMissing('pdfs', ['name' => 'first']);
		Storage::disk('local')->assertMissing($path);
	}
	
}
