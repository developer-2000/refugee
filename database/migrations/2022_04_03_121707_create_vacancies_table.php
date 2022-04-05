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
            $table->string('type_employment')->index()->nullable()->default(null)->comment('работа - полная / не полная / удаленка');

            $table->string('salary')->index()->comment('зарплата - одно значение, диапазон, договорная, в месяц/час, коментарий');
            $table->tinyInteger('work_experience')->index()->default(0)->comment('опыт работы');
            $table->tinyInteger('education')->index()->default(0)->comment('образование - перечень');
            $table->tinyInteger('vacancy_suitable')->index()->default(0)->comment('образование - перечень');
            $table->text('job_requirements')->nullable()->default(null)->comment('требования вакансии');
            $table->text('working_conditions')->nullable()->default(null)->comment('условия работы');
            $table->text('employee_responsibilities')->nullable()->default(null)->comment('обязанности работника');
            $table->string('contact_information')->nullable()->default(null)->comment('какие контакты связи показать соискателю');
            $table->tinyInteger('job_status')->index()->default(0)->comment('статус вакансии - стандарт, скрытая, горячая');
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
