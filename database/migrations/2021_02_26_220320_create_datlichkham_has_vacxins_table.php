<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDatlichkhamHasVacxinsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('datlichkham_has_vacxins', function (Blueprint $table) {
            $table->bigInteger('datlichkham_id')->unsigned()->nullable();
            $table->foreign('datlichkham_id')->references('id')->on('datlichkhams')->onDelete('cascade');
            $table->bigInteger('vacxin_id')->unsigned()->nullable();
            $table->foreign('vacxin_id')->references('id')->on('vacxins')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('datlichkham_has_vacxins');
    }
}
