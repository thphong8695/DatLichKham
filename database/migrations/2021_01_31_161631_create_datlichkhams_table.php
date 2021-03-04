<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDatlichkhamsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('datlichkhams', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('namsinh')->nullable();
            $table->smallInteger('gioitinh')->nullable();
            $table->string('phone');
            $table->string('sonha')->nullable();
            $table->string('diachi')->nullable();
            $table->string('mayte')->nullable();
            $table->string('sobaohiem')->nullable();
            $table->longText('ghichu')->nullable();
            $table->date('ngaykham');
            $table->bigInteger('khunggio_id')->unsigned();
            $table->foreign('khunggio_id')->references('id')->on('khunggios');
            $table->bigInteger('benhvien_id')->unsigned();
            $table->foreign('benhvien_id')->references('id')->on('benhvien_pks');
            $table->bigInteger('user_id')->unsigned()->nullable();
            
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
        Schema::dropIfExists('datlichkhams');
    }
}
