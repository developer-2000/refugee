<?php
namespace Database\Seeders\Test;

use App\Http\Traits\Geography\GeographyWorkSeparateEntryTraite;
use App\Model\Position;
use App\Model\User;
use App\Model\Vacancy;
use Faker\Generator as Faker;
use Illuminate\Database\Seeder;

class TestVacancySeeder extends Seeder {
    use GeographyWorkSeparateEntryTraite;

    /**
     * Run the database seeders.
     *
     * @param  Faker  $faker
     * @return void
     */
    public function run(Faker $faker) {

        $users = User::with('permission')->get();
        $users = $users->filter(function ($user, $key) {
            return $user->permission[0]["name"] == "test";
        });
        // сброс индексов
        $users = $users->values();

        foreach ($users as $key => $user) {

            for ($i = 0; $i < 5; $i++) {

                $createdAt = $faker->dateTimeBetween('-3 months', '-2 months');
                $position = Position::firstOrCreate([
                    'title' => $key."_Vacancy_$i"
                ]);

                $country = new \stdClass();
$country->country = (Array) json_decode('{"prefix":"UA","original_index":"ukraine","translate_index":"ukraine","translate":"\u0423\u043a\u0440\u0430\u0438\u043d\u0430"}');
                $country_id = $this->createSpecifiedLocationRecord($country,'country', 0);

                $region = new \stdClass();
$region->region = (Array) json_decode('{"original_index":"odessa","code_region":698738,"prefix":"ua","translate_index":"odessa","translate":"\u041e\u0434\u0435\u0441\u0441\u043a\u0430\u044f"}');
                $local_id = $this->createSpecifiedLocationRecord($region, 'region', 1);

                $city = new \stdClass();
$city->city = (Array) json_decode('{"original_index":"odessa","prefix":"ua","translate_index":"odessa","translate":"Odessa","code_region":698738}');
                $city_id = $this->createSpecifiedLocationRecord($city, 'city', 2);

                $data = [
                    'user_id' => $user->id,
                    'position_id' => $position->id,
                    'categories' => [0],
                    'languages' => [0],

                    'country_id' => $country_id,
                    'region_id' => $local_id,
                    'city_id' => $city_id,

                    'rest_address' => $faker->streetAddress(),
                    'type_employment' => rand(0, 3),
                    'salary' => json_decode('{"radio_name":"range","inputs":{"from":0,"to":1000,"salary_sum":0},"comment":null}', true),
                    'experience' => 3,
                    'education' => 4,
                    'text_description' => $faker->realText(rand(200, 500)),
                    'text_working' => $faker->realText(rand(200, 500)),
                    'text_responsibilities' => $faker->realText(rand(200, 500)),
                    'alias' => sha1(time()),
                    'vacancy_suitable' => json_decode('{"inputs":{"to":60,"from":18},"comment":null,"radio_name":"it_not_matter"}', true),
                    'how_respond' => 0,
                    'job_posting' => json_decode('{"status_name":"standard","create_time":"2022-06-21T19:50:32.955150Z"}', true),
                    'published' => 1,
                    'check_admin' => 0,
                    'created_at' => $createdAt,
                    'updated_at' => $createdAt,
                ];

                sleep(1);

                Vacancy::create($data);
            }

        }

    }

}
























