<?php

use App\Model\GeographyLocal;
use App\Model\Position;
use Faker\Generator as Faker;
use Illuminate\Database\Seeder;

class VacancySeeder extends Seeder
{
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

                $local = json_decode('{"code":"AL","name":"Albania"}');
                $country_local = GeographyLocal::firstOrCreate(
                    ["local->code" => "AL"],
                    [
                        'local' => $local,
                        'alias' => mb_strtolower($local->name),
                        'type' => 0
                    ]
                );

                $local = json_decode('{"code":865732,"name":"Elbasan"}');
                $region_local = GeographyLocal::firstOrCreate(
                    ["local->code" => '865732'],
                    [
                        'local' => $local,
                        'alias' => mb_strtolower($local->name).'_reg',
                        'type' => 1
                    ]
                );

                $local = json_decode('{"code":783263,"geonamesCode":783263,"name":"Elbasan","latitude":41.1125,"longitude":20.08222,"population":100903,"capital":null}');
                $city_local = GeographyLocal::firstOrCreate(
                    ["local->code" => '783263'],
                    [
                        'local' => $local,
                        'alias' => mb_strtolower($local->name),
                        'type' => 2
                    ]
                );

                $data = [
                    'user_id' => $obj->id,
                    'position_id' => $position->id,
                    'categories' => '[0]',
                    'languages' => '[0]',

                    'country_id' => $country_local->id,
                    'region_id' => $region_local->id,
                    'city_id' => $city_local->id,

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
























