<?php

/** @var Factory $factory */

use App\Model\Event;
use App\Model\Ticket;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;

$factory->define(Ticket::class, function (Faker $faker) {
    return [
        'name'=>$faker->name,
        'description'=>$faker->paragraph,
        'price'=>$faker->numberBetween(100,1000),
        'max_ticket_allowed_per_person'=>$faker->numberBetween(1,10),
        'min_ticket_allowed_per_person'=>$faker->numberBetween(1,10),
        'ticket_type'=>$faker->boolean,
        'status'=>$faker->boolean,
       // 'refundable'=>$faker->boolean,
       // 'promo_code'=>$faker->word,
        'event_id'=> Event::all()->pluck('id')->random(),
    ];
});
