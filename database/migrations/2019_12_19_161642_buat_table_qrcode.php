<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class BuatTableQrcode extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('qrcode', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('linkqr_id')->unsigned();
            $table->foreign('linkqr_id')->references('id')->on('linkqr')->onDelete('cascade');
            $table->string('qrcode');
            $table->string('status',10);
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
        Schema::table('qrcode', function (Blueprint $table) {
            $table->dropForeign(['linkqr_id']);
        });
        Schema::dropIfExists('qrcode');
    }
}
