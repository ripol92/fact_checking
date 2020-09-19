<?php

/** @var Factory $factory */

use App\Models\MarkedItem;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;

$factory->define(MarkedItem::class, function (Faker $faker) {
    return [
        "link" => $faker->url,
        "lang" => $faker->randomElement(["ru", "en"]),
        "description" => $faker->realText(200),
        "title" => $faker->realText(64),
        "date" => $faker->date("Y-m-d"),
        "is_analyzed" => $faker->randomElement([1, 0]),
        "html_encoded" => $faker->randomHtml(2),
        "source" => $faker->url,
        "img" => $faker->imageUrl(),
        "fact_check_url" => $faker->url,
    ];
});
