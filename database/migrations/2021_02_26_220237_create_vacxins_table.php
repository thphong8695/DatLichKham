<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVacxinsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vacxins', function (Blueprint $table) {
            $table->id();
            $table->string('name',100);
            $table->text('nguabenh');
            $table->string('giatien')->nullable();
            $table->boolean('mienphi')->nullable();
            $table->integer('soluong')->nullable();
            $table->date('ngayapdung')->nullable();
            $table->integer('stt')->nullable();
            $table->longText('ghichu')->nullable();

            $table->bigInteger('sdvacxin_id')->unsigned();
            $table->foreign('sdvacxin_id')->references('id')->on('sudung_vacxins');
            $table->bigInteger('benhvien_id')->unsigned();
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
        Schema::dropIfExists('vacxins');
    }
}
