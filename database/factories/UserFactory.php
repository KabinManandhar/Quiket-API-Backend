<?php

/** @var Factory $factory */

use App\Model\User;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;

$factory->define(User::class, function (Faker $faker) {
    return [
    'first_name'=> $faker->firstName,
        'last_name'=> $faker->lastName,
        'email'=> $faker->email,
        'password'=> $faker->password,
        'phone_no'=> $faker->phoneNumber,
    ];
});
