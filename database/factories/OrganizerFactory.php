<?php

/** @var Factory $factory */

use App\Model\Organizer;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;

$factory->define(Organizer::class, function (Faker $faker) {
    return [
        'name'=> $faker->name,
        'description'=> $faker->sentence,
        'email'=> $faker->email,
        'password'=> bcrypt("secret"),
        'picture'=> $faker->sentence,
        'phone_no'=> $faker->phoneNumber,
    ];
});
