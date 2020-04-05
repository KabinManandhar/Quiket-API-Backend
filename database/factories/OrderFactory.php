<?php

/** @var Factory $factory */

use App\Model\Order;
use App\Model\Ticket;
use App\Model\User;
use App\Model\Event;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;

$factory->define(Order::class, function (Faker $faker) {
    return [
        'ticket_id'=> Ticket::all()->pluck('id')->random(),
        'user_id'=> User::all()->pluck('id')->random(),
//        'event_id'=>Event::all()->pluck('id')->random(),
        'status'=> $faker->boolean,
        //'refunded'=> $faker->boolean,
        //'refundable'=> Ticket::all()->pluck('refundable')->random(),
        'qr_code'=> $faker->word,
    ];
});
