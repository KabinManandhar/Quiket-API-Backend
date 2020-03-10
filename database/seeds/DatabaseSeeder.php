<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Model\User::class,5)->create();
        factory(App\Model\Organizer::class,5)->create();
        factory(App\Model\Event::class,10)->create();
        factory(App\Model\Ticket::class,20)->create();
        factory(App\Model\Order::class,20)->create();
        factory(App\Model\Bookmark::class,5)->create();    }
}
