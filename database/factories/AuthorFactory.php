<?php

use Faker\Generator as Faker;

$factory->define(App\Author::class, function (Faker $faker) {
    return [
        'full_name' => $faker->name(),
        'email' => $faker->email,
        'unique_id' => date('Y-m-d')
    ];
});
