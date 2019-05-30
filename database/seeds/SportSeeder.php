<?php

use App\Models\PracticeDay;
use App\Models\Sport;
use App\Models\SportField;
use Illuminate\Database\Seeder;

class SportSeeder extends Seeder {
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run() {
		factory(Sport::class, 10)->create()->each(function ($sport) {
			factory(PracticeDay::class,3)->create([
				'sport_id' => $sport->id
			]);
			factory(SportField::class, 4)->create([
				'sport_id' => $sport->id
			]);
		});
	}
}
