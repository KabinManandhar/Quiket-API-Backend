<?php

/** @var Factory $factory */

use App\Model\User;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;

$factory->define(User::class, function (Faker $faker) {
    return [
    'name'=> $faker->name,
        'email'=> $faker->email,
        'password'=> bcrypt('secret'),
        'phone_no'=> $faker->phoneNumber,
        'picture'=>$faker->word
    ];
});
