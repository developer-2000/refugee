<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserContactsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_contacts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            $table->string('name', 100);
            $table->string('surname', 100);
            $table->unsignedBigInteger('position_id')->nullable()->default(null)->comment('должность');
            $table->string('email', 100)->nullable()->default(null);
            $table->string('skype', 100)->nullable()->default(null);
            $table->string('phone', 100)->nullable()->default(null);
            $table->boolean('check_phone')->default(false)->comment('проверка телефона');
            $table->string('messengers', 100)->nullable()->default(null)->comment('меседжеры телефона');
            $table->unsignedBigInteger('avatar_id')->nullable()->default(null)->comment('id file avatar user');
            $table->string('default_avatar_url')->nullable()->default(null)->comment('url default file');

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
        Schema::dropIfExists('user_contacts');
    }
}
