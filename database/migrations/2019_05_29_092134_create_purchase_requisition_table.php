<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePurchaseRequisitionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('purchase_requisition');
        Schema::create('purchase_requisition', function (Blueprint $table) {
            $table->increments('id');
            $table->string('seller_name');
            $table->string('phone_number', 18);
            $table->timestamps();

            $table->integer('place')->unsigned();

            $table->foreign('place')->references('id')->on('place')
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
        Schema::dropIfExists('purchase_requisition');
    }
}
