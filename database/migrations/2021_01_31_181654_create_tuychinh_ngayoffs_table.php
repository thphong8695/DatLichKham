<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTuychinhNgayoffsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tuychinh_ngayoffs', function (Blueprint $table) {
            $table->id();
            $table->date('ngayoff');
            $table->smallInteger('status');
            $table->bigInteger('benhvien_id')->unsigned()->nullable();
            $table->foreign('benhvien_id')->references('id')->on('benhvien_pks');
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
        Schema::dropIfExists('tuychinh_ngayoffs');
    }
}
