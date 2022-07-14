<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserCompaniesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_companies', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            $table->unsignedBigInteger('logo_id')->nullable()->default(null)->comment('логотип компании');

            $table->string('title', 100)->nullable()->default(null);
            $table->string('alias', 100)->unique()->comment('уникальный url');

            $table->unsignedBigInteger('country_id')->index();
            $table->unsignedBigInteger('region_id')->index()->nullable()->default(null);
            $table->unsignedBigInteger('city_id')->index()->nullable()->default(null);

            $table->string('rest_address', 100)->nullable()->default(null)->comment('остальной адрес');
            $table->string('categories', 100)->nullable()->default(null)->comment('категории компании');
            $table->text('youtube_links')->nullable()->default(null)->comment('видео компании');
            $table->string('tax_number', 100)->nullable()->default(null)->comment('налоговый номер');
            $table->string('founding_date', 10)->nullable()->default(null)->comment('дата основания');
            $table->string('facebook_social', 150)->nullable()->default(null)->comment('акаунт компании');
            $table->string('instagram_social', 150)->nullable()->default(null)->comment('акаунт компании');
            $table->string('telegram_social', 150)->nullable()->default(null)->comment('акаунт компании');
            $table->string('twitter_social', 150)->nullable()->default(null)->comment('акаунт компании');
            $table->string('site_company', 150)->nullable()->default(null);
            // шаблон из \config\site\company.php
            $table->tinyInteger('count_working_company')->default(0)->comment('количество сотрудников');
            $table->text('about_company')->nullable()->default(null)->comment('описание компании');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_companies');
    }
}
