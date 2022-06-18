<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * после создания новой seed в консоле - composer dumpautoload
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
         $this->call(CountriesSeeder::class);
         $this->call(LocationDbSeeder::class);
    }
}
