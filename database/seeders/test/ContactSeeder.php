<?php
namespace Database\Seeders\Test;

use Faker\Generator as Faker;
use Illuminate\Database\Seeder;

class ContactSeeder extends Seeder
{

    public function run(Faker $faker)
    {
        $gender = $faker->randomElements(['male', 'female'])[0];

        $users = \App\Model\User::get();

        foreach ($users as $key => $obj) {
            \App\Model\UserContact::insert([
                'user_id' => $obj->id,
                'name' => $faker->firstName($gender),
                'surname' => $faker->lastName($gender),
                'default_avatar_url' => "img/avatars/default/man.jpg",
            ]);
        }

    }
}
