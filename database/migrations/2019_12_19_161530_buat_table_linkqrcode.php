<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class BuatTableLinkqrcode extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('linkqr', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('link');
            $table->string('nama',50);
            $table->string('email',50);
            $table->string('no_hp',20);
            $table->string('nama_p',50);
            $table->string('alamat_p',50);
            $table->string('jabatan',20);
            $table->date('tanggal');
            $table->bigInteger('user_id')->unsigned();
            $table->enum('status',['aktif','tidak']);
            $table->string('latitude',50)->nullable();
            $table->string('longitude',50)->nullable();
            $table->enum('permintaan',['admin','karyawan']);
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
        Schema::dropIfExists('linkqr');
    }
}
