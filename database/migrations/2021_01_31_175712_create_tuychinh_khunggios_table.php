<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTuychinhKhunggiosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tuychinh_khunggios', function (Blueprint $table) {
            $table->id();
            $table->date('ngaydat');
            $table->smallInteger('soluong');
            $table->smallInteger('status');
            $table->bigInteger('khunggio_id')->unsigned();
            $table->foreign('khunggio_id')->references('id')->on('khunggios');
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
        Schema::dropIfExists('tuychinh_khunggios');
    }
}
