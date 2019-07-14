<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Model;
use Faker\Generator as Faker;

$factory->define(\App\Models\CompetitorExportColumn::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
		'column' => $faker->name,
    ];
});
