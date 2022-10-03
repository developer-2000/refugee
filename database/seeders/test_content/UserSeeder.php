<?php
namespace Database\Seeders\TestContent;

use App\Model\Permission;
use App\Model\User;
use App\Model\UserPermission;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeders.
     *
     * @return void
     */
    public function run()
    {
        $permission = Permission::where("name", "user")->first();
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
            $user = User::create($data);

            UserPermission::create([
                "user_id"=>$user->id,
                "permission_id"=>$permission->id,
            ]);
        }

    }
}
