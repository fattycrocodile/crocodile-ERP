<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReceivePurchasesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('receive_purchases', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('purchase_no');
            $table->foreign('purchase_no')->references('id')->on('purchases');
            $table->string('rcv_no');
            $table->date('rcv_date');
            $table->unsignedBigInteger('rcv_by')->nullable();
            $table->foreign('rcv_by')->references('id')->on('users');
            $table->unsignedBigInteger('created_by')->nullable();
            $table->foreign('created_by')->references('id')->on('users');
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->foreign('updated_by')->references('id')->on('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('receive_purchases');
    }
}
