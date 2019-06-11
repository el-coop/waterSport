<?php

use ElCoop\HasFields\Models\Field;
use Illuminate\Database\Seeder;

class CompetitorFieldSeeder extends Seeder {
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run() {
		
		factory(Field::class,2)->create();
		
	}
}
