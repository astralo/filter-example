<?php

/** @var Factory $factory */

use App\Models\Book;
use App\Models\User;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;

$factory->define(Book::class, static function (Faker $faker) {
    return [
        'title' => $faker->words(2, true),
        'description' => $faker->sentences(5, true),
        'author_id' => static function () {
            return factory(User::class)->create()->id;
        },
        'rating' => $faker->numberBetween(1, 10),
        'published_year' => $faker->numberBetween(1900, 2019),
        'price' => $faker->numberBetween(100, 1000)
    ];
});
