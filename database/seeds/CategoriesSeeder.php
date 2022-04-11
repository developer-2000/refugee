<?php

use Illuminate\Database\Seeder;

class CategoriesSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $arrCategories = config('site.settings_vacancy.categories');
        foreach ($arrCategories as $title) {
            $model = new \App\Model\Category();
            $model->title = $title;
            $model->active = 1;
            $model->save();
        }
    }
}
