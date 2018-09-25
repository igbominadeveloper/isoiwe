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
         factory(App\User::class,50)->create();
         factory(App\Author::class,10)->create();
         factory(App\Book::class,50)->create();
         factory(App\Rating::class,100)->create();
    }
}
