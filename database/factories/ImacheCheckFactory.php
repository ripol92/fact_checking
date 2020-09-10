<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\ImageCheck;
use Faker\Generator as Faker;

$factory->define(ImageCheck::class, function (Faker $faker) {
    return [
        "identifier" => $faker->uuid,
        "image_path" => $faker->imageUrl(),
        "message" => $faker->realText(20),
        "results_path" => uniqid(),
    ];
});
