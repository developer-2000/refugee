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
            $table->unsignedBigInteger('position_id')->comment('должность');
            $table->foreign('position_id')->references('id')->on('positions');
            $table->string('categories')->index()->nullable()->default("[]")->comment('категории вакансии');
            $table->string('country')->index()->comment('страна');
            $table->string('region')->index()->nullable()->default(null)->comment('регион');
            $table->string('city')->index()->nullable()->default(null)->comment('город');
            $table->string('rest_address')->index()->comment('остальной адрес');
            $table->string('vacancy_suitable')->index()->default(null)->comment('возраст вакансии');
            $table->tinyInteger('type_employment')->index()->comment('работа - полная / не полная / удаленка');
            $table->string('salary')->index()->comment('зарплата - одно значение, диапазон, не указано, коментарий');
            $table->tinyInteger('experience')->index()->comment('опыт работы');
            $table->tinyInteger('education')->index()->comment('образование');
            $table->string('search_city')->index()->comment('поиск кандидатов в другом городе');
            $table->text('text_requirements')->nullable()->default(null)->comment('требования вакансии');
            $table->text('text_working')->nullable()->default(null)->comment('условия работы');
            $table->text('text_responsibilities')->nullable()->default(null)->comment('обязанности работника');
            $table->string('contacts')->index()->nullable()->default("[]")->comment('какие контакты связи показать соискателю');
            $table->tinyInteger('how_respond')->index()->default(0)->comment('как откликнуться');
            $table->tinyInteger('job_posting')->index()->default(0)->comment('статус вакансии - стандарт, скрытая');
            $table->integer('alias')->unique()->comment('url вакансии');
            $table->boolean('published')->default(false)->comment('опубликованность');
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
        Schema::dropIfExists('vacancies');
    }
}
