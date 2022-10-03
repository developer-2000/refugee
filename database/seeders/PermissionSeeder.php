<?php
namespace Database\Seeders;

use App\Model\Permission;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    private static $permissions = [
        "admin",
        "user",
        "test",
    ];

    /**
     * Run the database seeders.
     *
     * @return void
     */
    public function run()
    {
        foreach (self::$permissions as $key => $value) {
            $model = new Permission();
            $model->name = $value;
            $model->save();
        }
    }
}
