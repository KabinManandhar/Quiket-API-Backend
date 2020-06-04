<?php

/** @var Factory $factory */

use App\Model\Bookmark;
use App\Model\Event;
use App\Model\User;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;

$factory->define(Bookmark::class, function (Faker $faker) {
    return [
        'user_id'=> User::all()->pluck('id')->random(),
        'event_id'=> Event::all()->pluck('id')->random(),

    ];
});
