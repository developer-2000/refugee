<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOfferChatArchivesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('offer_chat_archives', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('table_id')->comment('id table');

            $table->unsignedBigInteger('one_user_id');
            $table->foreign('one_user_id')->references('id')->on('users')->onDelete('cascade');

            $table->unsignedBigInteger('two_user_id');
            $table->foreign('two_user_id')->references('id')->on('users')->onDelete('cascade');

            $table->longText('chat')->nullable()->default(null);
            $table->tinyInteger('one_user_review')->default(0);
            $table->tinyInteger('two_user_review')->default(0);
            $table->tinyInteger('accepted')->default(0);
            $table->string('alias', 100)->unique()->index();

            $table->timestamp('table_created_at')->comment('create table');
            $table->timestamp('table_updated_at')->comment('update table');

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
        Schema::dropIfExists('offer_chat_archives');
    }
}
