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
            $table->enum('action', ['создание', 'бронирование', 'отмена клиентом до бронирования', 'отмена менеджером до бронирования', 'отмена клиентом после бронирования', 'отмена менеджером после бронирования', 'завершено']);
            $table->integer('timer')->nullable();
            $table->timestamps();

            $table->foreign('bid')->references('id')->on('reservation');
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
