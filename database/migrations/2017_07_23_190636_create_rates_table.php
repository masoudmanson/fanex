<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rates', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->increments('id')->unsigned();;
            $table->integer('exchanger_id')->unsigned()->nullable();
            $table->integer('currency_id')->unsigned()->nullable();
            $table->string('rate');
            $table->timestamps();

            $table->foreign('exchanger_id')->references('id')->on('exchangers')
                ->onUpdate('cascade')->onDelete('set null');

            $table->foreign('currency_id')->references('id')->on('currencies')
                ->onUpdate('cascade')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('rates', function($table) {
            $table->dropForeign(['exchanger_id']);
            $table->dropForeign(['currency_id']);
        });

        Schema::dropIfExists('rates');
    }
}