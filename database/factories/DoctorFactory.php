<?php

use Faker\Generator as Faker;
use App\User;

$factory->define(App\Doctor::class, function (Faker $faker) {
    return [
        'user_id' => User::all()->random()->id,
        'name' => $faker->name,
        'certificate' => $faker->name,
        'dateofbirth' => $faker->date,
        'cost' => $faker->numberBetween($min = 1000, $max = 9000),
        'description' => $faker->text,
        'rating' => $faker->randomFloat($nbMaxDecimals = 1, $min = 0, $max = 5),
    ];
});
