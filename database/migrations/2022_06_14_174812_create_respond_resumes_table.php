<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRespondResumesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('respond_resumes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('resume_id');
            $table->foreign('resume_id')->references('id')->on('user_resumes')->onDelete('cascade');

            $table->unsignedBigInteger('company_id');
            $table->foreign('company_id')->references('id')->on('user_companies')->onDelete('cascade');
            $table->unsignedBigInteger('user_company_id');
            $table->foreign('user_company_id')->references('id')->on('users')->onDelete('cascade');
            $table->text('textarea_letter')->nullable()->default(null);
            $table->tinyInteger('review')->default(0)->comment('0=no, 1=yes - просмотр хозяином');
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
        Schema::dropIfExists('respond_resumes');
    }
}
