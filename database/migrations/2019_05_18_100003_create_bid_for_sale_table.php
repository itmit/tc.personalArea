<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBidForSaleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bid_for_sales', function (Blueprint $table) {
            $table->increments('id');
            $table->string('seller_name');
            $table->string('phone_number', 18);
            $table->timestamps();

            $table->integer('place')->unsigned();

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
        Schema::dropIfExists('bid_for_sales');
    }
}
