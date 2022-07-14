<?php

use App\Http\Traits\Geography\GeographyWorkSeparateEntryTraite;
use App\Model\Position;
use Faker\Generator as Faker;
use Illuminate\Database\Seeder;

class VacancySeeder extends Seeder {
    use GeographyWorkSeparateEntryTraite;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {

        $users = \App\Model\User::get();

        foreach ($users as $key => $obj) {

            for ($i = 0; $i < 5; $i++) {

                $createdAt = $faker->dateTimeBetween('-3 months', '-2 months');
                $position = Position::firstOrCreate([
                    'title' => $key."_Vacancy_$i"
                ]);

                $country = new stdClass();
                $country->country = (Array) json_decode('{"prefix":"US","original_index":"united-states","translate_index":"united-states","translate":"\u0421\u043e\u0435\u0434\u0438\u043d\u0435\u043d\u043d\u044b\u0435 \u0428\u0442\u0430\u0442\u044b"}');
                $country_id = $this->createSpecifiedLocationRecord($country,'country', 0);

                $region = new stdClass();
                $region->region = (Array) json_decode('{"original_index":"new-york","code_region":5128638,"prefix":"us","translate_index":"new-york","translate":"\u041d\u044c\u044e-\u0419\u043e\u0440\u043a"}');
                $local_id = $this->createSpecifiedLocationRecord($region, 'region', 1);

                $city = new stdClass();
                $city->city = (Array) json_decode('{"original_index":"new-york-city","prefix":"us","translate_index":"new-york-city","translate":"New York City","code_region":5128638}');
                $city_id = $this->createSpecifiedLocationRecord($city, 'city', 2);

                $data = [
                    'user_id' => $obj->id,
                    'position_id' => $position->id,
                    'categories' => '[0]',
                    'languages' => '[0]',

                    'country_id' => $country_id,
                    'region_id' => $local_id,
                    'city_id' => $city_id,

                    'rest_address' => $faker->streetAddress(),
                    'type_employment' => rand(0, 3),
                    'salary' => '{"radio_name":"range","inputs":{"from":0,"to":1000,"salary_sum":0},"comment":null}',
                    'experience' => 3,
                    'education' => 4,
                    'text_description' => $faker->realText(rand(200, 500)),
                    'text_working' => $faker->realText(rand(200, 500)),
                    'text_responsibilities' => $faker->realText(rand(200, 500)),
                    'job_posting' => '{"status_name":"standard","create_time":"2022-06-21T19:50:32.955150Z"}',
                    'alias' => sha1(time()),
                    'vacancy_suitable' => '{"inputs":{"to":60,"from":18},"comment":null,"radio_name":"it_not_matter"}',
                    'how_respond' => 0,
                    'created_at' => $createdAt,
                    'updated_at' => $createdAt,
                ];

                sleep(1);

                \App\Model\Vacancy::insert($data);
            }

        }

    }

}
























