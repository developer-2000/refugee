<?php
namespace Database\Seeders;

use App\Model\Permission;
use App\Model\Position;
use App\Model\User;
use App\Model\UserCompany;
use App\Model\UserContact;
use App\Model\UserPermission;
use App\Model\Vacancy;
use Faker\Generator as Faker;
use Illuminate\Database\Seeder;

class TestUserSeeder extends Seeder
{
    /**
     * Run the database seeders.
     *
     * @param  Faker  $faker
     * @return void
     */
    public function run(Faker $faker)
    {
        $permission = Permission::where("name", "test")->first();
        $data = [
            'email' => 'test@test.test',
            'email_verified_at' => now(),
            'password' => '$2y$10$zK2JKadQuvJqu7tkY6MH5.DTl9kr5dreaXACXevCHcsSyoLY3ZDOq', // testtest
            'remember_token' => \Illuminate\Support\Str::random(10),
        ];
        // 1
        $user = User::create($data);
        // 2
        UserPermission::create([
            "user_id"=>$user->id,
            "permission_id"=>$permission->id,
        ]);
        // 3 contact
        $gender = $faker->randomElements(['male', 'female'])[0];
        UserContact::insert([
            'user_id' => $user->id,
            'name' => $faker->firstName($gender),
            'surname' => $faker->lastName($gender),
            'default_avatar_url' => "img/avatars/default/man.jpg",
        ]);
        // 7 компания
        UserCompany::create([
            'user_id' => $user->id,
            'title' => "Test Company",
            'alias' => "test-company",
            'country_id' => 1,
            'region_id' => 2,
            'city_id' => 3,
            'rest_address' => "Internet",
            'categories' => [0,1,25],
            'youtube_links' => [],
            'tax_number' => null,
            'founding_date' => "01/24/2022",
            'facebook_social' => null,
            'instagram_social' => null,
            'telegram_social' => null,
            'twitter_social' => null,
            'site_company' => "https://work-ukraine.com",
            'count_working_company' => 0,
            'about_company' => "<p>Employment service - providing the opportunity to post vacancies and resumes of job seekers on our platform. We are developing service functionality, ease and convenience of using platform resources. Searching and conducting advertising sessions, introductory events that help expand the client base. </p>",
        ]);
    }
}
