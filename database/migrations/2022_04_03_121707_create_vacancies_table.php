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
            $table->unsignedBigInteger('category_id')->comment('категория вакансии');
            $table->foreign('category_id')->references('id')->on('categories');
            $table->string('country')->index()->nullable()->default(null)->comment('страна');
            $table->string('region')->index()->nullable()->default(null)->comment('регион');
            $table->string('city')->index()->nullable()->default(null)->comment('город');
            $table->string('address')->index()->nullable()->default(null)->comment('адрес');
            $table->boolean('look_another_city')->default(false)->comment('поиск кандидатов в другом городе');
            $table->json('type_employment')->index()->nullable()->default(null)->comment('работа - полная / не полная / удаленка');
            $table->json('salary')->index()->comment('зарплата - одно значение, диапазон, договорная, в месяц/час, коментарий');

//            $table->string('work_experience')->index()->comment('опыт работы - перечень');
//            $table->string('education')->index()->comment('образование - перечень');
//            $table->string('vacancy_suitable')->index()->comment('вакансия подходит - перечень возраста и здоровья');
//            $table->string('job_requirements')->index()->comment('требования вакансии');
//            $table->string('working_conditions')->index()->comment('условия работы');
//            $table->string('employee_responsibilities')->index()->comment('обязанности работника');
//            $table->string('contact_information')->index()->comment('Контактная информация - перечень контактов о себе');
//            $table->string('how_respond')->index()->comment('Как можно откликнуться - с резюме или без');
//            $table->string('job_posting')->index()->comment('Размещение вакансии - стандарт, горячая, скрытая');
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
