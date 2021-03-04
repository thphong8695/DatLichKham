<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddBacsiIdToDatlichkhamsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('datlichkhams', function (Blueprint $table) {
            $table->bigInteger('bacsi_id')->unsigned()->nullable();
            $table->foreign('bacsi_id')->references('id')->on('bacsis');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('datlichkhams', function (Blueprint $table) {
            //
        });
    }
}
