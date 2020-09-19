<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\FirebaseNotification;
use Faker\Generator as Faker;

$factory->define(FirebaseNotification::class, function (Faker $faker) {
    return [
        "title" => $faker->realText(64),
        "text" => $faker->text,
    ];
});
