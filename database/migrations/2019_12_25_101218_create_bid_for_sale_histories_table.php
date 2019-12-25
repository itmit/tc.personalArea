<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBidForSaleHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bid_for_sale_histories', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('bid');
            $table->enum('status', ['не обработана', 'в работе', 'отказано', 'успешно завершена']);
            $table->text('text')->nullable();
            $table->timestamps();

            $table->foreign('bid')->references('id')->on('bid_for_sales');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bid_for_sale_histories');
    }
}
