<?php

use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            'email' => 'admin@admin.admin',
            'email_verified_at' => now(),
            'password' => '$2y$10$gsJb/tpc/X8ppY5N9t5jt.Me/HHrS.bnZWuPQ1Ug4d947rDmjbBhq', // adminadmin
            'remember_token' => \Illuminate\Support\Str::random(10),
        ];

        $user = \App\Model\User::create($data);
        $permission = \App\Model\Permission::create([
            "name"=>"admin",
        ]);
        \App\Model\UserPermission::create([
            "user_id"=>$user->id,
            "permission_id"=>$permission->id,
        ]);

    }
}
