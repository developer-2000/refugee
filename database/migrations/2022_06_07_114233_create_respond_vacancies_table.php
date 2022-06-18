<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRespondVacanciesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('respond_vacancies', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('vacancy_id');
            $table->foreign('vacancy_id')->references('id')->on('vacancies')->onDelete('cascade');

            $table->unsignedBigInteger('resume_id');
            $table->foreign('resume_id')->references('id')->on('user_resumes')->onDelete('cascade');

            $table->unsignedBigInteger('user_vacancy_id');
            $table->foreign('user_vacancy_id')->references('id')->on('users')->onDelete('cascade');

            $table->unsignedBigInteger('user_resume_id');
            $table->foreign('user_resume_id')->references('id')->on('users')->onDelete('cascade');

            $table->text('textarea_letter')->nullable()->default(null);
            $table->tinyInteger('review')->default(0)->comment('0=no, 1=yes - просмотр хозяином');
            $table->tinyInteger('accepted')->default(0)->comment('0=no, 1=yes - хозяин принял отклик');

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
        Schema::dropIfExists('respond_vacancies');
    }
}
