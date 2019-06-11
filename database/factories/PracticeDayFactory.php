<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Model;
use Faker\Generator as Faker;

$factory->define(\App\Models\PracticeDay::class, function (Faker $faker) {
    return [
        'date_time' => $faker->dateTime()
    ];
});
