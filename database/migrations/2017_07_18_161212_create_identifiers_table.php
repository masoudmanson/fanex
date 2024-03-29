<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIdentifiersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('identifiers', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->increments('id');
            $table->string('name');
            $table->string('field_1')->nullable();
            $table->string('field_2')->nullable();
            $table->string('optional_field_1')->nullable();
            $table->string('optional_field_2')->nullable();

            $table->integer('exchanger_id')->nullable();
            $table->boolean('status')->default(false);

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
//        Schema::table('identifiers', function($table) {
//            $table->dropForeign(['exchanger_id']);
//        });

        Schema::dropIfExists('identifiers');
    }
}
