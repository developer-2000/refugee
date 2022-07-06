<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * после создания новой seed в консоле, при ошибке - composer dumpautoload
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
         $this->call(LocationDbSeeder::class);
         $this->call(UserSeeder::class);
         $this->call(ContactSeeder::class);
         $this->call(AdminSeeder::class);
         $this->call(ResumeSeeder::class);
         $this->call(VacancySeeder::class);
    }
}
