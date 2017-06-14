<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
            $table->engine = 'InnoDB';

            $table->increments('id');
            $table->integer('userId')->unique()->nullable();//maybe string
//            $table->string('api_token')->nullable();
            $table->string('api_token', 60)->unique()->nullable();
            $table->string('firstname');
            $table->string('lastname');

//** should be encrypted
            $table->string('account_number')->nullable();
            $table->string('mobile')->nullable();
            $table->enum('gender', ['Mr.', 'Ms.', 'Co.'])->nullable();
            $table->enum('identity_number', ['passport', 'national', 'registration', 'national_id'])->nullable();
            $table->string('address')->nullable();
            $table->string('place_of_birth')->nullable();
            $table->string('date_of_birth')->nullable();
            $table->string('postal_code')->nullable();
            $table->string('tel')->nullable();
            $table->string('fax')->nullable();
            $table->string('email')->unique()->nullable();
//            $table->string('password');
//**
            $table->boolean('is_authorized')->nullable();
            $table->rememberToken();
            $table->timestamps();
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
