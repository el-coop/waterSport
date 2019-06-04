<?php

use Illuminate\Database\Seeder;

class SportManagerSeeder extends Seeder {
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run() {
		factory(\App\Models\SportManager::class,10)->make()->each(function ($sportManager){
			$sport = \App\Models\Sport::inRandomOrder()->limit(1)->get()->first();
			$sport->sportManagers()->save($sportManager);
			$sportManager->save();
			$user = factory(\App\Models\User::class)->make();
			$sportManager->user()->save($user);
		});
	}
}
