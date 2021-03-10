<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMoneyReceiptsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('money_receipts', function (Blueprint $table) {
            $table->id();
            $table->string('mr_no')->comment('Money Receipt No');
            $table->unsignedBigInteger('max_sl_no');
            $table->string('manual_mr_no')->nullable()->comment('Manual Money Receipt No');
            $table->unsignedBigInteger('invoice_id')->nullable();
            $table->foreign('invoice_id')->references('id')->on('invoices');
            $table->unsignedBigInteger('store_id');
            $table->foreign('store_id')->references('id')->on('stores');
            $table->unsignedBigInteger('customer_id')->nullable();
            $table->foreign('customer_id')->references('id')->on('customers');
            $table->string('collection_type');
            $table->unsignedBigInteger('bank_id')->nullable();
            $table->string('cheque_no')->nullable();
            $table->string('cheque_date')->nullable();
            $table->double('discount')->default(0);
            $table->double('amount')->default(0);
            $table->date('date');
            $table->text('remarks');
            $table->unsignedBigInteger('received_by')->nullable();
            $table->foreign('received_by')->references('id')->on('users');
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
        Schema::dropIfExists('money_receipts');
    }
}
