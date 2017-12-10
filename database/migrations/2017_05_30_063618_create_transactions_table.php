<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->increments('id')->unsigned();
            $table->integer('user_id')->unsigned()->nullable();
            $table->integer('beneficiary_id')->unsigned()->nullable();
            $table->integer('backlog_id')->unsigned()->nullable();
            $table->string('uri')->nullable();
            $table->enum('bank_status',['canceled','failed','successful', 'waiting'])->default('waiting');
            $table->enum('fanex_status',['pending','accepted','rejected', 'waiting'])->default('waiting');
            $table->enum('upt_status',['successful','failed', 'rejected', 'waiting'])->default('waiting');
            $table->string('currency')->nullable();
            $table->bigInteger('product_id');
            $table->string('exchange_rate')->nullable();
            $table->string('premium_amount')->nullable();
            $table->string('payment_amount')->nullable();
            $table->string('vat')->nullable();
            $table->string('payment_type')->nullable();
            $table->timestamp('payment_date')->nullable();
            $table->string('country')->nullable();
            $table->string('upt_ref')->nullable();
            $table->string('ttl')->nullable();
            $table->string('receiver_account')->nullable();
            $table->string('receiver_firstname')->nullable();
            $table->string('receiver_lastname')->nullable();
            $table->string('receiver_bank_name')->nullable();
            $table->string('receiver_branch_name')->nullable();
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
