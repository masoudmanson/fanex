<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCurrenciesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('currencies', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->increments('id')->unsigned();;
            $table->enum('type',['EUR','TRY', 'USD', 'GBP', 'ریال', 'CNY'])->default('EUR');
            $table->enum('sign',['€','₺', '$', '£', '﷼', '¥'])->default('€');
            $table->enum('name',['Euro','Turkish Lira', 'Dollar', 'Pound', '﷼', 'Yuan'])->default('Euro');

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
        Schema::dropIfExists('currencies');
    }
}