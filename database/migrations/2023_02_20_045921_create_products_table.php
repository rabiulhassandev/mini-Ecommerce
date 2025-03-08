<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('slug')->unique();
            $table->float('price')->nullable();
            $table->string('sku')->nullable();
            
            
            $table->longText('short_desc')->nullable();
            $table->longText('long_desc')->nullable();
            $table->longText('shipping_return')->nullable();
            $table->longText('additional_info')->nullable();
            
            $table->string('thumbnail')->nullable();
            
            $table->boolean('stock_status')->default(true);
            $table->boolean('status')->default(true);
            
            $table->json('color_id')->nullable();
            $table->json('attr_value_id')->nullable();
            $table->unsignedBigInteger('category_id')->nullable();
            $table->timestamps();

            $table
                ->foreign('category_id')
                ->references('id')
                ->on('categories')
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
        Schema::dropIfExists('products');
    }
}
