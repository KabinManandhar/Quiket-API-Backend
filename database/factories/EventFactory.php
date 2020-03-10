<?php

/** @var Factory $factory */

use App\Model\Event;
use App\Model\Organizer;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;

$factory->define(Event::class, function (Faker $faker) {
    return [
        'name'=>$faker->name,
        'description'=>$faker->paragraph,
        'venue'=>$faker->address,
        'category'=>$faker->word,
        'type'=>$faker->word,
        'picture'=>$faker->sentence,
        'status'=>$faker->boolean,
        'start_datetime'=>$faker->dateTime,
        'end_datetime'=>$faker->dateTime,
        'organizer_id'=> Organizer::all()->pluck('id')->random(),
    ];
});
