<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AdminsChangeStatusColumnTextsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql3')->table('texts', function (Blueprint $table) {
            $table->boolean('status')->default(1)->change();
            $table->renameColumn('status', 'is_active');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('mysql3')->table('texts', function (Blueprint $table) {
            $table->string('is_active', 25)->nullable()->change();
            $table->renameColumn('is_active', 'status');
        });
    }
}
