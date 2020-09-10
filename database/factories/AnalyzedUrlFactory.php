<?php

/** @var Factory $factory */

use App\Models\AnalysedUrl;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;

$factory->define(AnalysedUrl::class, function (Faker $faker) {
    return [
        "url" => $faker->url,
        "article" => $faker->realText(200),
        "text_ru" => json_encode(["urls" => ["a" => $faker->url, "b" => $faker->url]]),
        "image_links" => [$faker->imageUrl()],
        "lng" => $faker->randomElement(["en", "ru"]),
        "adjectives_analyse" => [],
    ];
});
