<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class B2bSelectedActivitiesCreateTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('selected_activites', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('package_activity_id')->unsigned()->nullable();
            $table->string('code')->nullable();
            $table->string('mode')->nullable();
            $table->datetime('date')->nullable();
            $table->string('vendor')->nullable();
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
        Schema::dropIfExists('selected_activites');
    }
}
