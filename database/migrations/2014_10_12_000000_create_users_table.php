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
            $table->increments('id');
            $table->integer('user_id')->unique();
            $table->string('api_token');
            $table->string('firstname');
            $table->string('lastname');
            $table->string('account_number');
            $table->string('mobile');
            $table->enum('sex', ['Mr.', 'Ms.', 'Co.']);
            $table->enum('identity_number', ['passport', 'national', 'registration', 'national_id']);
            $table->string('address');
            $table->string('place_of_birth');
            $table->string('date_of_birth');
            $table->string('postal_code');
            $table->string('tel');
            $table->string('fax');
            $table->string('email')->unique();
            $table->string('password');
            $table->boolean('is_authorized');
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
