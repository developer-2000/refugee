<?php

use Illuminate\Database\Seeder;
use App\Model\UserResume;
use App\Model\Position;
use Faker\Generator as Faker;

class ResumeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        for($i = 0; $i<10; $i++){

            $createdAt = $faker->dateTimeBetween('-3 months','-2 months');
            $user_id = rand(1,2);
            $countResumeAtUser = UserResume::where('user_id',$user_id)->get()->count();
            $title_name = $user_id === 1 ? "First Resume_$countResumeAtUser" : "Two Resume_$countResumeAtUser";
            $position = Position::firstOrCreate([
                'title' => $title_name
            ]);

            $data = [
                'user_id' => $user_id,
                'position_id' => $position->id,
                'alias' => sha1(time()),
                'country' => '{"code":"AL","name":"Albania"}',
                'region' => '{"code":865732,"name":"Elbasan"}',
                'city' => '{"code":783263,"geonamesCode":783263,"name":"Elbasan","latitude":41.1125,"longitude":20.08222,"population":100903,"capital":null}',
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

            UserResume::insert($data);
        }
    }
}
