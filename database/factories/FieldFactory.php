<?php

use Faker\Generator as Faker;

$factory->define(\ElCoop\HasFields\Models\Field::class, function (Faker $faker) {
	return [
		'name_en' => $faker->unique()->name,
		'name_nl' => $faker->name,
		'type' => $faker->randomElement(['text', 'textarea']),
		'form' => \App\Models\Competitor::class,
		'order' => $faker->unique()->numberBetween(0,100),
		'status' => 'protected',
	];
});
