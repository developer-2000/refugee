<?php
namespace Database\Seeders\Test;

use App\Model\Permission;
use App\Model\Position;
use App\Model\User;
use App\Model\UserContact;
use App\Model\UserPermission;
use App\Model\Vacancy;
use Faker\Generator as Faker;
use Illuminate\Database\Seeder;

class TestUserSeeder extends Seeder
{
    /**
     * Run the database seeders.
     *
     * @param  Faker  $faker
     * @return void
     */
    public function run(Faker $faker)
    {
        $permission = Permission::where("name", "test")->first();
        $data = [
            'email' => 'test@test.test',
            'email_verified_at' => now(),
            'password' => '$2y$10$zK2JKadQuvJqu7tkY6MH5.DTl9kr5dreaXACXevCHcsSyoLY3ZDOq', // testtest
            'remember_token' => \Illuminate\Support\Str::random(10),
        ];
        // 1
        $user = User::create($data);
        // 2
        UserPermission::create([
            "user_id"=>$user->id,
            "permission_id"=>$permission->id,
        ]);
        // 3 contact
        $gender = $faker->randomElements(['male', 'female'])[0];
        UserContact::insert([
            'user_id' => $user->id,
            'name' => $faker->firstName($gender),
            'surname' => $faker->lastName($gender),
            'default_avatar_url' => "img/avatars/default/man.jpg",
        ]);
    }
}
