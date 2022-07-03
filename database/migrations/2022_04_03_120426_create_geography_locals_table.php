<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGeographyLocalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('geography_locals', function (Blueprint $table) {
            $table->id();
            $table->string('local')->index();
            $table->string('alias');
            $table->tinyInteger('type')->default(0)->comment('0=country, 1=region, 2=city');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('geography_locals');
    }
}
