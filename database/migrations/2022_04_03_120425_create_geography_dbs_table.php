<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGeographyDbsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('geography_dbs', function (Blueprint $table) {
            $table->id();
            $table->longText('country')->nullable()->comment('все страны');
            $table->longText('regions')->nullable()->comment('регионы стран');
            $table->longText('cities')->nullable()->comment('города регионов');
        });
    }

    /**
     * geographical locale
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('geography_dbs');
    }
}
