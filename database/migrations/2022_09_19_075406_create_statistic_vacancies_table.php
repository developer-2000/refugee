<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStatisticVacanciesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('statistic_vacancies', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('vacancy_id');
            $table->foreign('vacancy_id')->references('id')->on('vacancies')->onDelete('cascade');

            $table->mediumInteger('respond')->nullable()->default(0)->comment('отклики');
            $table->mediumInteger('show')->nullable()->default(0)->comment('показы');
            $table->mediumInteger('update')->nullable()->default(0)->comment('обновления документа');
            $table->mediumInteger('view')->nullable()->default(0)->comment('просмотры документа');
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
        Schema::dropIfExists('statistic_vacancies');
    }
}
