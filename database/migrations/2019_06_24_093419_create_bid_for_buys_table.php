<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBidForBuysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('bid_for_buys');
        Schema::create('bid_for_buys', function (Blueprint $table) {
            $table->increments('id');
            $table->string('seller_name');
            $table->string('phone_number', 18);
            $table->integer('place')->unsigned();
            $table->timestamps();

            $table->foreign('place')->references('id')->on('places')
                ->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bid_for_buys');
    }
}
