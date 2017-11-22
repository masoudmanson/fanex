<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBacklogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('backlogs', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->increments('id')->unsigned();
            $table->string('ip');
            $table->string('currency');
            $table->bigInteger('product_id');
            //todo : In case of making Fanex international we have to save both origin & destination currencies
            //$table->string('origin_currency');
            //$table->string('destination_currency');
            $table->string('upt_exchange_rate')->nullable();
            $table->string('upt_ttl')->nullable();
            $table->string('exchange_rate');
            $table->string('ttl');
            $table->string('premium_amount');
            $table->string('payment_amount');
            $table->string('payment_type');
            $table->string('country');

            /*
             * Optional Fields for data mining
             */
            $table->string('longitude')->nullable();
            $table->string('latitude')->nullable();
            $table->string('os')->nullable();
            $table->string('browser')->nullable();
            $table->string('device')->nullable();
            $table->string('store')->nullable();
            $table->string('udid')->nullable();
            $table->string('timezone')->nullable();

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
        Schema::dropIfExists('backlogs');
    }
}
