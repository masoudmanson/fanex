<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBeneficiariesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('beneficiaries', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->increments('id')->unsigned();
            $table->integer('user_id')->unsigned()->nullable();
            $table->string('firstname');
            $table->string('lastname');
            $table->string('account_number');
            $table->text('address');
            $table->string('tel');
            $table->string('fax');
            $table->string('bank_name');
            $table->string('branch_name');
            $table->text('branch_address');
            $table->string('swift_code');
            $table->string('iban_code');
            $table->string('routing_aba');
            $table->string('transit_sort_code');
            $table->string('blz_bsb');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')
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
        Schema::table('beneficiaries', function ($table) {
            $table->dropForeign(['user_id']);
        });

        Schema::dropIfExists('beneficiaries');
    }
}