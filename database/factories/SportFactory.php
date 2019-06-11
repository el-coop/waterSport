<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Models\Sport;
use Faker\Generator as Faker;

$factory->define(Sport::class, function (Faker $faker) {
	return [
		'name' => $faker->unique()->company(),
		'description' => $faker->paragraph,
	];
});
