<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('username')->unique();
            $table->string('email')->unique();
            $table->string('phone')->unique();
            $table->timestamp('email_verified_at')->nullable();

            $table->unsignedBigInteger('user_status_id')->default(1);
            // extra Information for user
            $table->text('bio')->nullable();
            $table->string('address')->nullable();
            $table->string('birth')->nullable();
            // social
            $table->string('facebook')->nullable();
            $table->string('twitter')->nullable();
            $table->string('whatsapp')->nullable();

            $table->string('password');
            $table->rememberToken();
            $table->foreignId('current_team_id')->nullable();
            $table->string('profile_photo_path', 2048)->nullable();
            $table->integer('otp')->nullable();
            $table->timestamp('otp_created_at')->nullable();
            $table->integer('otp_attempt')->default(0);
            $table->timestamps();

            $table
                ->foreign('user_status_id')
                ->references('id')
                ->on('user_statuses')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
