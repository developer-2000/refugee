<?php

use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            'email' => 'thwglobal2000@gmail.com',
            'email_verified_at' => now(),
            'password' => '$2y$10$cvH43yr8/K7gckTc7D3uwOHSe65cjybXdnYnyVMVuLD4fH4qU7YAm', // thwglobal2000
            'remember_token' => \Illuminate\Support\Str::random(10),
        ];

        for($i = 0; $i<3; $i++){
            if($i >= 1){
                $data["email"] = "thwglobal200$i@gmail.com";
            }
            \Illuminate\Support\Facades\DB::table('users')->insert($data);
        }

    }
}
