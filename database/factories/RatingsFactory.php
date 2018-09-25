<?php

use Faker\Generator as Faker;

$factory->define(App\Rating::class, function (Faker $faker) {
    return [
        'book_id' => App\Book::all()->pluck('id')->random(),
        'user_id' => App\User::all()->pluck('id')->random(),
        'star' => $faker->numberBetween(1,5),
        'comment' => $faker->sentence,
    ];
});