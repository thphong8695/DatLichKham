<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddChuyenkhoasToDatlichkhamsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('datlichkhams', function (Blueprint $table) {
            $table->bigInteger('chuyenkhoa_id')->unsigned()->nullable();
            $table->foreign('chuyenkhoa_id')->references('id')->on('chuyenkhoas');
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
