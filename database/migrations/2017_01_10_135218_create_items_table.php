<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('items', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('order_id')->unsigned();
            $table->integer('product_id')->unsigned();
            $table->integer('design_id')->unsigned();
            $table->integer('quantity')->unsigned();
            $table->integer('total_price')->nullable()->unsigned();
            $table->integer('unit_price')->nullable()->unsigned();
            $table->timestamps();

            $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade');
            $table->foreign('design_id')->references('id')->on('designs')->onDelete('set null');
            $table->foreign('product_id')->references('id')->on('products')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('items');
    }
}
