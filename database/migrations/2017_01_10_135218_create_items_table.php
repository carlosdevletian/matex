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
            $table->integer('order_id')->unsigned()->nullable();
            $table->integer('cart_id')->unsigned()->nullable();
            $table->integer('product_id')->unsigned();
            $table->integer('design_id')->unsigned();
            $table->integer('quantity')->unsigned();
            $table->integer('total_price')->nullable()->unsigned();
            $table->integer('unit_price')->nullable()->unsigned();
            $table->boolean('available')->default(true);
            $table->timestamps();

            $table->foreign('cart_id')->references('id')->on('carts')->onDelete('cascade');
            $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade');
            $table->foreign('design_id')->references('id')->on('designs')->onDelete('cascade');
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
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
