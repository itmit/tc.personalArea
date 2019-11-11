<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReservationHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reservation_histories', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('bid')->unsigned();
            $table->integer('action')->unsigned();
            $table->integer('timer')->nullable();
            $table->timestamps();

            $table->foreign('bid')->references('id')->on('reservation');
            $table->foreign('action')->references('id')->on('actions');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('reservation_histories');
    }
}
