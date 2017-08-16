<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExchangerUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('exchanger_users', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->increments('id')->unsigned();
            $table->integer('userId')->unique()->nullable();
            $table->integer('exchanger_id')->nullable();
            $table->string('firstname')->unique()->nullable();
            $table->string('lastname')->unique()->nullable();
//            $table->string('exchanger_name');
            $table->string('username')->nullable();
            $table->string('email')->unique()->nullable();
            $table->rememberToken();
            $table->timestamps();

//            $table->foreign('exchanger_id')->references('id')->on('exchangers')
//                ->onUpdate('cascade')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
//        Schema::table('exchanger_users', function($table) {
//            $table->dropForeign(['exchanger_id']);
//        });

        Schema::dropIfExists('exchanger_users');
    }
}