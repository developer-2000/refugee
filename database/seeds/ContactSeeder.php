<?php

use Faker\Generator as Faker;
use Illuminate\Database\Seeder;

class ContactSeeder extends Seeder
{

    public function run(Faker $faker)
    {
        $gender = $faker->randomElements(['male', 'female'])[0];

        $companies = [
            [
                'name' => $faker->firstName($gender),
                'surname' => $faker->lastName($gender),
                'default_avatar_url' => "img/avatars/default/man.jpg",
            ],
            [
                'name' => $faker->firstName($gender),
                'surname' => $faker->lastName($gender),
                'default_avatar_url' => "img/avatars/default/man.jpg",
            ],
        ];

        for($i = 1; $i<=2; $i++){
            $companies[($i-1)]['user_id'] = $i;
        }

        \App\Model\UserContact::insert($companies);
    }
}
