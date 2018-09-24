<?php

use Faker\Generator as Faker;

$factory->define(App\Book::class, function (Faker $faker) {
    return [
        'user_id' => \App\User::all()->pluck('id')->random(),
        'title' => $faker->word.''.$faker->word,
        'description' => $faker->sentence,
        'published_at' => $faker->date('Y-m-d'),
        'author_id' => \App\Author::all()->pluck('id')->random(),
        'unique_id' => date('Y-m-d')
    ];
});
