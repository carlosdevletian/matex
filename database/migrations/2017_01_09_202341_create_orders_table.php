<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->increments('id');
            $table->string('email')->nullable();
            $table->string('reference_number')->nullable();
            $table->integer('user_id')->nullable()->unsigned();
            $table->integer('address_id')->nullable()->unsigned();
            $table->integer('status_id')->nullable()->unsigned();
            $table->integer('subtotal')->nullable();
            $table->integer('shipping')->nullable();
            $table->integer('tax')->nullable();
            $table->integer('total')->nullable();
            $table->string('shipping_company')->nullable();
            $table->string('tracking_number')->nullable();
            $table->string('tracking_url')->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
            $table->foreign('address_id')->references('id')->on('addresses')->onDelete('set null');
            $table->foreign('status_id')->references('id')->on('statuses')->onDelete('set null');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
}
