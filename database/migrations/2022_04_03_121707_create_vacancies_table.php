<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVacanciesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vacancies', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            $table->unsignedBigInteger('position_id')->comment('должность');

            $table->string('categories')->index()->nullable()->default(null)->comment('категории вакансии');
            $table->string('languages')->index()->nullable()->default(null)->comment('языки вакансии');

            $table->unsignedBigInteger('country_id')->index();
            $table->unsignedBigInteger('region_id')->index()->nullable()->default(null);
            $table->unsignedBigInteger('city_id')->index()->nullable()->default(null);

            $table->string('rest_address')->index()->comment('остальной адрес');
            $table->json('vacancy_suitable')->nullable()->default(null)->comment('возраст вакансии');
            $table->tinyInteger('type_employment')->index()->comment('работа - полная / не полная / удаленка');
            $table->text('salary')->nullable()->default(null)->comment('зарплата - одно значение, диапазон, не указано, коментарий');
            $table->tinyInteger('experience')->index()->comment('опыт работы');
            $table->tinyInteger('education')->index()->comment('образование');
            $table->text('text_description')->nullable()->default(null)->comment('описание вакансии');
            $table->text('text_working')->nullable()->default(null)->comment('условия работы');
            $table->text('text_responsibilities')->nullable()->default(null)->comment('обязанности работника');
            $table->tinyInteger('how_respond')->index()->default(0)->comment('как откликнуться');
            $table->string('alias', 100)->unique()->comment('url вакансии');
            $table->string('job_posting')->nullable()->default(null)->comment('статус вакансии - стандарт, скрытая');
            $table->boolean('published')->default(false)->comment('доступ к показам');
            $table->boolean('check_admin')->default(false)->comment('проверен админом');
            $table->boolean('blocked')->default(false)->comment('блокировка документа 0-off, 1-on');

            $table->timestamps();
        });

        Schema::table('vacancies', function(Blueprint $table)
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
        Schema::dropIfExists('vacancies');
    }
}
