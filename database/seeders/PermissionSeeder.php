<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    private static $permissions = [
        "user",
        "admin",
    ];

    /**
     * Run the database seeders.
     *
     * @return void
     */
    public function run()
    {
        foreach (self::$permissions as $key => $value) {
            $model = new \App\Model\Permission();
            $model->name = $value;
            $model->save();
        }
    }
}
