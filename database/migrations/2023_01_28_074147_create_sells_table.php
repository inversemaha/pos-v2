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
        Schema::create('sells', function (Blueprint $table) {
            $table->increments('sell_id');
            $table->unsignedInteger('customer_id');
            $table->string('invoice');
            $table->double('grand_total_price');
            $table->double('given_amount');
            $table->double('change')->nullable();
            $table->double('discount_amount')->default(0);
            $table->double('total_vat')->default(0);
            $table->double('delivery_charge')->default(0);
            $table->boolean('paid_status'); //true, false
            $table->unsignedInteger('seller_id'); //true, false
            $table->unsignedInteger('outlet_id')->default(1);
            $table->timestamps();
            $table->foreign('outlet_id')->references('outlet_id')->on('outlets');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sells');
    }
};
