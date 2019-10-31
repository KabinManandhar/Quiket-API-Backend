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
        factory(App\Model\User::class,50)->create();
        factory(App\Model\Organizer::class,50)->create();
        factory(App\Model\Event::class,25)->create();
        factory(App\Model\Ticket::class,25)->create();
        factory(App\Model\Order::class,25)->create();
        factory(App\Model\Bookmark::class,25)->create();    }
}
