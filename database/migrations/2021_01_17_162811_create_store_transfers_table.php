<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStoreTransfersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('store_transfers', function (Blueprint $table) {
            $table->id();
            $table->string('invoice_no');
            $table->unsignedBigInteger('send_store_id');
            $table->foreign('send_store_id')->references('id')->on('stores');
            $table->unsignedBigInteger('rcv_store_id');
            $table->foreign('rcv_store_id')->references('id')->on('stores');
            $table->string('remarks')->nullable();
            $table->boolean('is_received')->default(0);
            $table->date('date');
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
        Schema::dropIfExists('store_transfers');
    }
}
