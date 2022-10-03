<?php
namespace Database\Seeders;

use App\Model\GeographyLocal;
use App\Model\Image;
use App\Model\Permission;
use App\Model\Position;
use App\Model\User;
use App\Model\UserCompany;
use App\Model\UserContact;
use App\Model\UserPermission;
use App\Model\Vacancy;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeders.
     *
     * @return void
     */
    public function run()
    {

        $password = "J3sFy98UBn52eVe";
        // 1 создать юзера
        $user = User::create([
            'email' => 'thwglobal2000@gmail.com',
            'email_verified_at' => now(),
            'password' => Hash::make($password),
            'remember_token' => Str::random(10),
        ]);
        $permission = Permission::where("name", "admin")->first();
        // 2 добавить права
        UserPermission::create([
            "user_id"=>$user->id,
            "permission_id"=>$permission->id,
        ]);
        // 3 должность
        $position = Position::create([
            "title"=>"Project Manager",
            "active"=>1,
        ]);
        // 4 avatar
        $image = Image::create([
            "title"=>"avatar-bagalov-shamil.jpg",
            "url"=>"img/custom/avatar-bagalov-shamil.jpg",
            "type"=>1,
        ]);
        // 5 контактные данные юзера Project Manager
        UserContact::create([
            'user_id' => $user->id,
            'name' => "Shamil",
            'surname' => "Bagalov",
            'position_id' => $position->id,
            'email' => "thwglobal2000@gmail.com",
            'skype' => "runa_ua",
            'phone' => "+38(073)4932092",
            'check_phone' => 1,
            'messengers' => [0,1],
            'avatar_id' => $image->id,
            'default_avatar_url' => "img/avatars/default/man.jpg",
        ]);
        // 5 логотип компании
        $image = Image::create([
            "title"=>"logotype-work-ukraine.jpg",
            "url"=>"img/custom/logotype-work-ukraine.jpg",
            "type"=>0,
        ]);
        // 6 country
        $country = GeographyLocal::create([
            "local"=>json_decode("{\"prefix\":\"UA\",\"original_index\":\"ukraine\",\"translate_index\":\"ukraine\",\"translate\":\"\u0423\u043a\u0440\u0430\u0438\u043d\u0430\"}", true),
            "alias"=>"ukraine",
            "type"=>0,
        ]);
        $region = GeographyLocal::create([
            "local"=>json_decode("{\"original_index\":\"odessa\",\"code_region\":698738,\"prefix\":\"ua\",\"translate_index\":\"odessa\",\"translate\":\"\u041e\u0434\u0435\u0441\u0441\u043a\u0430\u044f\"}", true),
            "alias"=>"odessa",
            "type"=>1,
        ]);
        $city = GeographyLocal::create([
            "local"=>json_decode("{\"original_index\":\"odessa\",\"prefix\":\"ua\",\"translate_index\":\"odessa\",\"translate\":\"Odessa\",\"code_region\":698738}", true),
            "alias"=>"odessa",
            "type"=>2,
        ]);
        // 7 компания
        UserCompany::create([
            'user_id' => $user->id,
            'logo_id' => $image->id,
            'title' => "Work Ukraine",
            'alias' => "work-ukraine",
            'country_id' => $country->id,
            'region_id' => $region->id,
            'city_id' => $city->id,
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
        // 8 вакансия
        $position = Position::create([
            "title"=>"best friend",
            "active"=>1,
        ]);
        Vacancy::create([
            'user_id' => $user->id,
            'position_id' => $position->id,
            'categories' => [0,1,4,8,11,13,18,21,23,25,26,28],
            'languages' => [0,1,2],
            'country_id' => $country->id,
            'region_id' => $region->id,
            'city_id' => $city->id,
            'rest_address' => "Internet",
            'vacancy_suitable' => json_decode("{\"inputs\":{\"to\":60,\"from\":18},\"comment\":null,\"radio_name\":\"it_not_matter\"}", true),
            'type_employment' => 3,
            'salary' => json_decode("{\"radio_name\":\"dont_specify\",\"inputs\":{\"from\":0,\"to\":1000,\"salary_sum\":0},\"comment\":\"Charity, assistance\"}", true),
            'experience' => 0,
            'education' => 0,
            'text_description' => "
<p>
I'm looking for anyone who has the ability, the ability to make the world a better place. Everyone who has the profession of a designer, programmer, system administrator,
cybersecurity specialist - point out shortcomings and errors in the work and implementation of the service
<a href='https://work-ukraine.com'>work-ukraine.com</a>
</p>
<p>I am looking for managers of you company who provide vacancies for their employer. I will be happy to provide a platform for additional recruitment of employees in your company.</p>
<p>&nbsp;</p>",
            'text_working' => null,
            'text_responsibilities' => null,
            'how_respond' => 0,
            'alias' => "e3da1daa5d58725afab8fced2f35ab116bef8e21",
            'job_posting' => json_decode("{\"status_name\":\"standard\",\"create_time\":\"2022-10-03T18:05:45.061853Z\"}", true),
            'published' => 1,
            'check_admin' => 1,
        ]);

    }
}


