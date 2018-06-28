<?php

use Faker\Generator as Faker;
use App\models\Bookmark;

/*
  |--------------------------------------------------------------------------
  | Model Factories
  |--------------------------------------------------------------------------
  |
  | This directory should contain each of the model factory definitions for
  | your application. Factories provide a convenient way to generate new
  | model instances for testing / seeding your application's database.
  |
 */

$factory->define(Bookmark::class,
                 function (Faker $faker) {
    return [
        'url' => $faker->unique()->url,
        'title' => $faker->text,
        'description' => $faker->text,
        'image' => $faker->imageUrl(),
        'domain' => $faker->tld,
        'is_dead' => false,
        'http_code' => 200,
        'http_message' => 'Ok',
        'last_availability_check_at' => $faker->dateTimeBetween("-1 month", "now"),
        'is_adult' => $faker->boolean,
        'metatags' => null
    ];
});
