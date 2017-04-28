<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Task::class, function (Faker\Generator $faker) {
    return [
        'category' => $faker->numberBetween(0, 100),
        'title' => $faker->title,
        'user_id' => $faker->numberBetween(0, 100),
        'start_time' => $faker->dateTime,
        'plan' => $faker->numberBetween(0, 100),
        'email' => $faker->email,
        'phone' => $faker->phoneNumber,
        'content' => $faker->text,
    ];
});
