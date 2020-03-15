<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePresensisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('presensis', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('karyawan_id')->unsigned();
            $table->foreign('karyawan_id')->references('id')->on('karyawans')->onDelete('cascade');
            $table->date('tanggal');
            $table->time('jam_hadir');
            $table->string('lokasi_user_hadir',50);
            $table->string('lokasi_qrcode_hadir',50)->nullable();
            $table->time('jam_pulang')->nullable();
            $table->string('lokasi_user_pulang',50)->nullable();
            $table->string('lokasi_qrcode_pulang',50)->nullable();
            $table->double('durasi_kerja')->default(0.0);
            $table->enum('validasi',['ya','tidak']);
            $table->string('cache',10)->nullable();
            $table->bigInteger('link')->unsigned();
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
        Schema::table('presensis', function (Blueprint $table) {
            $table->dropForeign(['karyawan_id']);
        });
        Schema::dropIfExists('presensis');
    }
}
