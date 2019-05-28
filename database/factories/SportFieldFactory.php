<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Model;
use Faker\Generator as Faker;

$factory->define(\App\Models\SportField::class, function (Faker $faker) {
    return [
        'name_en' => $faker->name,
		'name_nl' => $faker->name,
		'type' => 'text',
		'placeholder_en' => $faker->name,
		'placeholder_nl' => $faker->name
    ];
});
