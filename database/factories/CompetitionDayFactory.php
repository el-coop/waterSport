<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Model;
use Faker\Generator as Faker;

$factory->define(\App\Models\CompetitionDay::class, function (Faker $faker) {
	$date = $faker->dateTime();
    return [
		'start_time' => $date,
		'end_time' => $date->add(new DateInterval('PT10H30S'))
	];
});
