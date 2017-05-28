<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTranssactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->integer('beneficiary_id')->unsigned();
            $table->integer('backlog_id')->unsigned();
            $table->string('uri')->nullable();
            $table->enum('status',['canceled','unsuccessful','successful'])->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')
                ->onUpdate('cascade')->onDelete('set null');

            $table->foreign('beneficiary_id')->references('id')->on('beneficiaries')
                ->onUpdate('cascade')->onDelete('set null');

            $table->foreign('backlog_id')->references('id')->on('backlogs')
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
        Schema::table('transactions', function($table) {
            $table->dropForeign(['user_id']);
            $table->dropForeign(['beneficiary_id']);
            $table->dropForeign(['backlog_id']);
        });

        Schema::dropIfExists('transactions');
    }
}
