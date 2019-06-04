<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder {
	/**
	 * Seed the application's database.
	 *
	 * @return void
	 */
	public function run() {
		$this->call(AdminSeeder::class);
		$this->call(SportSeeder::class);
		$this->call(CompetitorSeeder::class);
		$this->call(SettingsSeeder::class);
		$this->call(SportManagerSeeder::class);
	}
}
