<?php

use App\Models\Competitor;
use App\Models\Sport;
use App\Models\User;
use Illuminate\Database\Seeder;

class CompetitorSeeder extends Seeder {
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run() {
		factory(Competitor::class, 10)->create()->each(function ($competitor) {
			$user = factory(User::class)->make();
			$competitor->user()->save($user);
			$sports = Sport::inRandomOrder()->limit(2)->get();
			foreach ($sports as $sport) {
				$competitor->sports()->attach($sport, ['data' => '[]']);
				foreach ($sport->practiceDays as $practiceDay) {
					$competitor->practiceDays()->save($practiceDay);
				}
			}
		});
		factory(Competitor::class, 1)->create()->each(function ($competitor) {
			$user = factory(User::class)->make([
				'email' => 'competitor@elcoop.io',
				'password' => bcrypt(123456)
			]);
			$competitor->user()->save($user);
			$sports = Sport::inRandomOrder()->limit(2)->get();
			foreach ($sports as $sport) {
				$competitor->sports()->attach($sport, ['data' => '[]']);
				foreach ($sport->practiceDays as $practiceDay) {
					$competitor->practiceDays()->save($practiceDay);
				}
			}
		});
	}
}
