<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompanyInfoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('company_info', function (Blueprint $table) {
            $table->id();
            $table->string('company_name');
            $table->string('tag_line')->nullable();
            $table->string('hot_line');
            $table->string('email')->nullable();
            $table->string('address');
            $table->string('website')->nullable();
            $table->string('tin_no')->nullable();
            $table->string('bin_no')->nullable();
            $table->string('trade_license_no')->nullable();
            $table->string('vat_reg_no')->nullable();
            $table->string('company_type')->nullable();
            $table->string('company_category')->nullable();
            $table->string('logo');
            $table->string('pad_header')->nullable();
            $table->string('pad_footer')->nullable();
            $table->string('pad')->nullable();
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
        Schema::dropIfExists('company_info');
    }
}
