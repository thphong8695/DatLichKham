<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBacsisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bacsis', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->bigInteger('chuyenkhoa_id')->unsigned()->nullable();
            $table->foreign('chuyenkhoa_id')->references('id')->on('khunggios');
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
        Schema::dropIfExists('bacsis');
    }
}
