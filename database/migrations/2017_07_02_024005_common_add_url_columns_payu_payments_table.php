<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CommonAddUrlColumnsPayuPaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql2')->table('payu_payments', function (Blueprint $table) {
            $table->text('surl')->after('data');
            $table->text('furl')->after('surl');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('mysql2')->table('payu_payments', function (Blueprint $table) {
            $table->dropColumn(['surl', 'furl']);
        });
    }
}
