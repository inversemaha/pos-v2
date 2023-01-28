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
        Schema::create('products', function (Blueprint $table) {
            $table->increments('product_id');
            $table->string('product_name')->nullable();
            $table->unsignedInteger('product_category_id');
            $table->string('product_image')->nullable();
            $table->text('product_description')->nullable();
            $table->unsignedInteger('outlet_id');
            $table->timestamps();
            $table->foreign('product_category_id')->references('product_category_id')->on('products_categories');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
};
