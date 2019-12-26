<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBidForBuyHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bid_for_buy_histories', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('bid')->unsigned();
            $table->enum('status', ['не обработана', 'в работе', 'отказано', 'успешно завершена']);
            $table->text('text')->nullable();
            $table->timestamps();

            $table->foreign('bid')->references('id')->on('bid_for_buys');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bid_for_buy_histories');
    }
}
