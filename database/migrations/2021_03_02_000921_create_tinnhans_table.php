<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTinnhansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tinnhans', function (Blueprint $table) {
            $table->id();
            $table->string('phone');
            $table->text('content');
            $table->bigInteger('benhvien_id')->unsigned();
            $table->foreign('benhvien_id')->references('id')->on('benhvien_pks');
            $table->bigInteger('user_id')->unsigned()->nullable();
            $table->bigInteger('datlichkham_id')->unsigned()->nullable();
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
        Schema::dropIfExists('tinnhans');
    }
}
