<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserResumesTable extends Migration
{
    /**
     * type=0 (site. задействует position_id)
     * type=1 (file. задействует title, url)
     *
     * Run the migrations.
     * @return void
     */
    public function up()
    {
        Schema::create('user_resumes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            $table->string('title', 100)->nullable()->default(null)->comment('название file');
            $table->unsignedBigInteger('position_id')->nullable()->default(null)->comment('должность');
            $table->tinyInteger('type')->default(0)->comment('0=site, 1=file');
            $table->string('url')->nullable()->default(null)->comment('url file');

            $table->string('alias', 100)->unique()->comment('url resume');

            $table->unsignedBigInteger('country_id');
            $table->unsignedBigInteger('region_id')->nullable()->default(null);
            $table->unsignedBigInteger('city_id')->nullable()->default(null);

            $table->timestamp('data_birth')->nullable()->default(null)->comment('дата рождения');
            $table->string('categories')->index()->nullable()->default(null)->comment('категории резюме');
            $table->text('salary')->nullable()->default(null)->comment('зарплата - одно значение, диапазон, коментарий');
            $table->tinyInteger('type_employment')->index()->nullable()->default(null)->comment('работа - полная / не полная / удаленка');
            $table->string('languages')->index()->nullable()->default(null)->comment('языки работника');
            $table->tinyInteger('education')->index()->nullable()->default(null)->comment('образование');
            $table->tinyInteger('experience')->index()->nullable()->default(null)->comment('опыт работы');
            $table->text('text_experience')->nullable()->default(null)->comment('описание опыта');
            $table->text('text_wait')->nullable()->default(null)->comment('ожидания от вакансии');
            $table->text('text_achievements')->nullable()->default(null)->comment('свои достижения');
            $table->string('job_posting')->nullable()->default(null)->comment('статус вакансии - стандарт, скрытая');
            $table->tinyInteger('published')->default(0)->comment('0=close, 1=open - проверка админом');

            $table->timestamps();
        });

        Schema::table('user_resumes', function(Blueprint $table)
        {
            $table->foreign('country_id')->references('id')->on('geography_locals')->onDelete('cascade');
            $table->foreign('region_id')->references('id')->on('geography_locals')->onDelete('cascade');
            $table->foreign('city_id')->references('id')->on('geography_locals')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_resumes');
    }
}
