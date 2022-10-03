<?php
namespace Database\Seeders;

use Database\Seeders\TestContent\UserSeeder;
use Database\Seeders\TestContent\ContactSeeder;
use Database\Seeders\TestContent\ResumeSeeder;
use Database\Seeders\TestContent\VacancySeeder;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

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
         $this->call(PermissionSeeder::class);
         $this->call(LocationDbSeeder::class);
         $this->call(AdminSeeder::class);



//         $this->call(UserSeeder::class);
//         $this->call(ContactSeeder::class);
//        $this->call(ResumeSeeder::class);
//         $this->call(VacancySeeder::class);
    }
}
