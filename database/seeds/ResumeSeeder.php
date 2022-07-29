<?php

use App\Http\Traits\Geography\GeographyWorkSeparateEntryTraite;
use App\Model\User;
use Illuminate\Database\Seeder;
use App\Model\UserResume;
use App\Model\Position;
use Faker\Generator as Faker;
use App\Model\GeographyLocal;

class ResumeSeeder extends Seeder {
    use GeographyWorkSeparateEntryTraite;

    /**
     * Run the database seeds.
     *
     * @param  Faker  $faker
     * @return void
     */
    public function run(Faker $faker)
    {
        $users = User::with('permission')->get();

        foreach ($users as $key => $obj) {

            // заполнить только обычным юзерам
            if($obj->permission->count()){
                continue;
            }

            for($i = 0; $i<5; $i++){

                $createdAt = $faker->dateTimeBetween('-3 months','-2 months');
                $position = Position::firstOrCreate([
                    'title' => $key."_Resume_$i"
                ]);

                $country = new stdClass();
$country->country = (Array) json_decode('{"prefix":"UA","original_index":"ukraine","translate_index":"ukraine","translate":"\u0423\u043a\u0440\u0430\u0438\u043d\u0430"}');
                $country_id = $this->createSpecifiedLocationRecord($country,'country', 0);

                $region = new stdClass();
$region->region = (Array) json_decode('{"original_index":"odessa","code_region":698738,"prefix":"ua","translate_index":"odessa","translate":"\u041e\u0434\u0435\u0441\u0441\u043a\u0430\u044f"}');
                $local_id = $this->createSpecifiedLocationRecord($region, 'region', 1);

                $city = new stdClass();
$city->city = (Array) json_decode('{"original_index":"odessa","prefix":"ua","translate_index":"odessa","translate":"Odessa","code_region":698738}');
                $city_id = $this->createSpecifiedLocationRecord($city, 'city', 2);

                $data = [
                    'user_id' => $obj->id,
                    'position_id' => $position->id,
                    'alias' => sha1(time()),

                    'country_id' => $country_id,
                    'region_id' => $local_id,
                    'city_id' => $city_id,

                    'data_birth' => '1977-01-04 00:00:00',
                    'categories' => '[0]',
                    'salary' => '{"radio_name":"range","inputs":{"from":0,"to":1000,"salary_sum":0},"comment":null}',
                    'type_employment' => rand(0,3),
                    'languages' => '[0]',
                    'education' => 4,
                    'experience' => 3,
                    'text_experience' => $faker->realText(rand(200,500)),
                    'text_wait' => $faker->realText(rand(200,500)),
                    'text_achievements' => $faker->realText(rand(200,500)),
                    'job_posting' => '{"status_name":"standard","create_time":"2022-06-21T19:50:32.955150Z"}',
                    'created_at' => $createdAt,
                    'updated_at' => $createdAt,
                ];

                sleep(1);
                UserResume::insert($data);
            }

        }

    }
}
