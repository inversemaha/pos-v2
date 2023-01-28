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
        Schema::create('sell_items', function (Blueprint $table) {
            $table->increments('sell_item_id');
            $table->string('invoice');
            $table->integer('quantity');
            $table->double('unit_price');
            $table->unsignedInteger('product_id');
            $table->unsignedInteger('outlet_id')->default(1);
            $table->timestamps();
            $table->foreign('outlet_id')->references('outlet_id')->on('outlets');
            // $table->foreign('invoice')->references('invoice')->on('sells');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sell_items');
    }
};
