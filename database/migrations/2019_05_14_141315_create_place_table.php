<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlaceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('place');
        Schema::create('place', function (Blueprint $table) {
            $table->increments('id');
            $table->string('block');
            $table->integer('floor')->nullable();
            $table->string('row');
            $table->string('place_number');
            $table->string('status');
            $table->integer('price')->nullable();
            $table->timestamps();

            $table->unique(['block', 'place_number', 'row', 'floor']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('place');
    }
}
