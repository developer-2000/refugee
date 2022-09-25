<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;

class LocationDbSeeder extends Seeder {

    /**
     * Run the database seeders.
     *
     * @return void
     */
    public function run()
    {
        (new \App\Services\MakeLocationDbServices());
    }
}
