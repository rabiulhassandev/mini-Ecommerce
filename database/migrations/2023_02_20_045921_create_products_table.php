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
            $table->string('unit')->default('Pcs');
            $table->integer('min_order_qty')->default(1);
            $table->float('unit_price')->nullable();
            $table->string('sku')->nullable();
            $table->string('shipping_days')->nullable();


            $table->longText('short_desc')->nullable();
            $table->longText('long_desc')->nullable();
            $table->longText('additional_info')->nullable();

            $table->string('thumbnail')->nullable();

            $table->string('meta_title')->nullable();
            $table->longText('meta_desc')->nullable();
            $table->text('meta_keywords')->nullable();
            $table->string('meta_image')->nullable();

            $table->boolean('featured_status')->default(false);
            $table->boolean('todays_deal_status')->default(false);
            $table->boolean('stock_status')->default(true);
            $table->boolean('status')->default(true);

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
