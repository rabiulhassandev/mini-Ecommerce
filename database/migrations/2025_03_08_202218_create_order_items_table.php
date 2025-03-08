<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            $table->integer('quantity')->nullable();
            $table->float('rate')->nullable();
            $table->float('total')->nullable();
            
            $table->unsignedBigInteger('color_id')->nullable();
            $table->unsignedBigInteger('size_id')->nullable();
            $table->unsignedBigInteger('product_id')->nullable();
            $table->unsignedBigInteger('order_id')->nullable();
            $table->timestamps();

            $table
                ->foreign('color_id')
                ->references('id')
                ->on('colors')
                ->onDelete('set null');

            $table
                ->foreign('size_id')
                ->references('id')
                ->on('attributes_values')
                ->onDelete('set null');

            $table
                ->foreign('product_id')
                ->references('id')
                ->on('products')
                ->onDelete('set null');

            $table
                ->foreign('order_id')
                ->references('id')
                ->on('orders')
                ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('order_items');
    }
}
