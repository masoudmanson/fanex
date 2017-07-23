<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddUsernameAndPasswordToExchangersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('exchangers', function (Blueprint $table) {
            $table->string('username');
            $table->string('email')->unique();
            $table->string('password');
            $table->rememberToken();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('exchangers', function (Blueprint $table) {
            $table->dropColumn('username');
            $table->dropColumn('email');
            $table->dropColumn('password');
        });
    }
}
