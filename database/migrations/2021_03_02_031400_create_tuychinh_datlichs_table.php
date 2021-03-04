<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTuychinhDatlichsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tuychinh_datlichs', function (Blueprint $table) {
            $table->id();
            $table->boolean('namsinh')->nullable();
            $table->boolean('gioitinh')->nullable();
            $table->boolean('sonha')->nullable();
            $table->boolean('diachi')->nullable();
            $table->boolean('mayte')->nullable();
            $table->boolean('sobaohiem')->nullable();
            $table->boolean('ghichu')->nullable();
            $table->boolean('province_id')->nullable();
            $table->boolean('vacxin_id')->nullable();
            $table->boolean('bacsi_id')->nullable();
            $table->boolean('chuyenkhoa_id')->nullable();
            $table->boolean('sms_id')->nullable();
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
        Schema::dropIfExists('tuychinh_datlichs');
    }
}
