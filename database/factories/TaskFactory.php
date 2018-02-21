<?php

use Faker\Generator as Faker;

$factory->define(\App\Models\Task::class, function (Faker $faker) {
    return [
        'identifier' => $faker->unique()->word,
        'detail' => $faker->words(5, true),
        'start_date' => $faker->date(),
    ];
});
