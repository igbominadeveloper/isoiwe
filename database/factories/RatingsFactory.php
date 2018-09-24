<?php

use Faker\Generator as Faker;

$factory->define(App\BookRating::class, function (Faker $faker) {
    return [
        'book_id' => App\Book::all()->pluck('id')->random(),
        'rating_id' => App\Rating::all()->pluck('id')->random(),
        'user_id' => App\User::all()->pluck('id')->random(),
    ];
});
