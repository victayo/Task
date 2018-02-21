<?php

use Faker\Generator as Faker;

$factory->define(\App\Models\Task::class, function (Faker $faker) {
    $stage_ids = \App\Models\Stage::get()->pluck('id')->toArray();
    return [
        'identifier' => $faker->unique()->word,
        'detail' => $faker->words(5, true),
        'start_date' => $faker->date(),
        'stage_id' => $faker->randomElement($stage_ids)
    ];
});
