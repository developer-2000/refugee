<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;

class CountriesSeeder extends Seeder {

    private $countries = [
        "Польша",
        "Словакия",
        "Венгрия",
        "Румыния",
        "Молдова",
        "Литва",
        "Чехия",
        "Португалия",
        "Германия",
        ];

    /**
     * Run the database seeders.
     *
     * @return void
     */
    public function run()
    {
        foreach ($this->countries as $country) {
            $model = new \App\Model\Country();
            $model->name = $country;
            $model->save();
        }
    }
}
