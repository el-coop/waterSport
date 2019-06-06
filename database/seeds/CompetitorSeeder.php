<?php

use Illuminate\Database\Seeder;

class CompetitorSeeder extends Seeder {
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run() {
		factory(\App\Models\Competitor::class,10)->create()->each(function ($competitor){
			$user = factory(\App\Models\User::class)->make();
			$competitor->user()->save($user);
			$sports = \App\Models\Sport::inRandomOrder()->limit(2)->get();
			$competitor->sports()->attach($sports,['data' => '[]']);
		});
		factory(\App\Models\Competitor::class,1)->create()->each(function ($competitor){
			$user = factory(\App\Models\User::class)->make([
				'email' => 'competitor@elcoop.io',
				'password' => bcrypt(123456)
			]);
			$competitor->user()->save($user);
			$sports = \App\Models\Sport::inRandomOrder()->limit(2)->get();
			$competitor->sports()->attach($sports,['data' => '[]']);

		});
	}
}
