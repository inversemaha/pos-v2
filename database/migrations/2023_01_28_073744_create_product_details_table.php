<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_details', function (Blueprint $table) {
            $table->increments('product_details_id');
            $table->double('product_purchase_price');
            $table->double('product_retail_price');
            $table->unsignedInteger('product_id');
            $table->unsignedInteger('outlet_id');
            $table->string('barcode')->nullable();
            $table->timestamps();
            $table->foreign('outlet_id')->references('outlet_id')->on('outlets');
            $table->foreign('product_id')->references('product_id')->on('products');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product_details');
    }
};
