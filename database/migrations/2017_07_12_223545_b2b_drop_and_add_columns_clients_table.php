<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class B2bDropAndAddColumnsClientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('clients', function (Blueprint $table) {
            $table->dropColumn('prefix');
            $table->boolean('is_active')->default(1)->after('status');
            $table->string('token',100)->after('is_active')->unique()->nullable();
        });

        \DB::statement("UPDATE `clients` SET `is_active`= 0 WHERE `status` = 'deleted'");

        Schema::table('clients', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('clients', function (Blueprint $table) {
            $table->string('prefix', 7)->after('id')->default('CLNT');
            $table->string('status', 25)->after('is_active')
                                            ->default('active');
        });

        \DB::statement("UPDATE `clients` SET `status` = 'deleted' WHERE `is_active`= 0;");

        Schema::table('clients', function (Blueprint $table) {
            $table->dropColumn(['is_active', 'token']);
        });
    }
}
