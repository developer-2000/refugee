<?php

use Illuminate\Database\Seeder;

class LocationDbSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        (new \App\Services\MakeLocationDbServices());
    }
}
