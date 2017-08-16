<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddExchangerIdToIdentifierTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('identifiers', function($table) {
            $table->foreign('exchanger_id')->references('id')->on('exchangers')
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
        Schema::table('identifiers', function($table) {
            $table->dropForeign(['exchanger_id']);
        });
    }
}
