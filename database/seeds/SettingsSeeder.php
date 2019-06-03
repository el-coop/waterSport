<?php

use Illuminate\Database\Seeder;
use Faker\Generator as Faker;

class SettingsSeeder extends Seeder {
	/**
	 * Run the database seeds.
	 *
	 * @param Faker $faker
	 * @return void
	 */
	public function run(Faker $faker) {
		$this->settingsFakeNoOverwrite('login_text_en', $faker->paragraph);
		$this->settingsFakeNoOverwrite('login_text_nl', $faker->paragraph);
		$this->settingsFakeNoOverwrite('registration_success_en', $faker->paragraph);
		$this->settingsFakeNoOverwrite('registration_success_nl', $faker->paragraph);
		$this->settingsFakeNoOverwrite('registration_email_subject_en', $faker->text);
		$this->settingsFakeNoOverwrite('registration_email_subject_nl', $faker->text);
		$this->settingsFakeNoOverwrite('registration_email_body_en', $faker->paragraph);
		$this->settingsFakeNoOverwrite('registration_email_body_nl', $faker->paragraph);
		$this->settingsFakeNoOverwrite('information_submitted_email_subject_en', $faker->text);
		$this->settingsFakeNoOverwrite('information_submitted_subject_nl', $faker->text);
		$this->settingsFakeNoOverwrite('information_submitted_email_body_en', $faker->paragraph);
		$this->settingsFakeNoOverwrite('information_submitted_email_body_nl', $faker->paragraph);


	}

	protected function settingsFakeNoOverwrite($key, $value) {
		$settings = app('settings');

		if ($settings->get($key) === null) {
			$settings->put($key, $value);
		}
	}
}
