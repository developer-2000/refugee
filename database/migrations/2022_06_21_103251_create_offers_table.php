<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOffersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('offers', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('one_user_id');
            $table->foreign('one_user_id')->references('id')->on('users')->onDelete('cascade');

            $table->unsignedBigInteger('two_user_id');
            $table->foreign('two_user_id')->references('id')->on('users')->onDelete('cascade');

            $table->longText('chat')->nullable()->default(null);
            $table->tinyInteger('one_user_review')->default(0)->comment('0=no, 1=yes - просмотр обновлений чата');
            $table->tinyInteger('two_user_review')->default(0)->comment('0=no, 1=yes - просмотр обновлений чата');
            $table->tinyInteger('accepted')->default(0)->comment('0=no, 1=yes - two_user дал доступ к своим контактам');
            $table->string('alias', 100)->unique()->comment('url чата');

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
        Schema::dropIfExists('offers');
    }
}
