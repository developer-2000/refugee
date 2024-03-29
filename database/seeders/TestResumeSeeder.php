<?php
namespace Database\Seeders;

use App\Http\Traits\Geography\GeographyWorkSeparateEntryTraite;
use App\Model\Resume;
use App\Model\User;
use Illuminate\Database\Seeder;
use App\Model\Position;
use Faker\Generator as Faker;
use Illuminate\Support\Carbon;


class TestResumeSeeder extends Seeder {
    use GeographyWorkSeparateEntryTraite;

    /**
     * Run the database seeders.
     *
     * @param  Faker  $faker
     * @return void
     */
    public function run(Faker $faker)
    {
        $users = User::with('permission')->get();
        $users = $users->filter(function ($user, $key) {
            return $user->permission[0]["name"] == "test";
        });
        // сброс индексов
        $users = $users->values();

        foreach ($users as $key => $user) {

            for($i = 0; $i<5; $i++){

                $createdAt = $faker->dateTimeBetween('-3 months','-2 months');
                $position = Position::firstOrCreate([
                    'title' => $key."_Resume_$i"
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
                    'alias' => sha1(time()),
                    'country_id' => $country_id,
                    'region_id' => $local_id,
                    'city_id' => $city_id,
                    'data_birth' => '01/04/1977',
                    'categories' => [0],
                    'salary' => json_decode('{"radio_name":"range","inputs":{"from":0,"to":1000,"salary_sum":0},"comment":null}', true),
                    'type_employment' => rand(0,3),
                    'languages' => [0],
                    'education' => 4,
                    'experience' => 3,
                    'text_experience' => $faker->realText(rand(200,500)),
                    'text_wait' => $faker->realText(rand(200,500)),
                    'text_achievements' => $faker->realText(rand(200,500)),
                    'job_posting' => json_decode('{"status_name":"standard","create_time":"'.Carbon::now().'"}', true),
                    'published' => 1,
                    'check_admin' => 0,
                    'created_at' => $createdAt,
                    'updated_at' => $createdAt,
                ];

                sleep(1);
                Resume::create($data);
            }

        }

    }
}
