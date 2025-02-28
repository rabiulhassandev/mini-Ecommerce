<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('slug')->unique();
            $table->string('icon')->default('bx bx-category');
            $table->integer('order')->default('0');
            $table->string('thumbnail')->nullable();
            $table->string('banner')->nullable();
            $table->string('meta_title')->nullable();
            $table->longText('meta_desc')->nullable();
            $table->boolean('status')->default(true);

            $table->unsignedBigInteger('parent_id')->nullable();
            $table->timestamps();

            $table
                ->foreign('parent_id')
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
        Schema::dropIfExists('categories');
    }
}
