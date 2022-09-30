<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStatisticResumesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('statistic_resumes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('resume_id');
            $table->foreign('resume_id')->references('id')->on('resumes')->onDelete('cascade');

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
        Schema::dropIfExists('statistic_resumes');
    }
}
