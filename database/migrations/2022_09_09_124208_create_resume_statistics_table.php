<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateResumeStatisticsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('resume_statistics', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('resume_id');
            $table->foreign('resume_id')->references('id')->on('user_resumes')->onDelete('cascade');

            $table->tinyInteger('respond')->nullable()->default(0)->comment('отклики');

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
        Schema::dropIfExists('resume_statistics');
    }
}
