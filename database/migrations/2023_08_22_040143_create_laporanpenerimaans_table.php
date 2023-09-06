<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('laporanpenerimaans', function (Blueprint $table) {
            $table->string('LPB');
            $table->date('TGL_TERIMA');
            $table->string('FAKTUR');
            $table->string('BUKTI_KIRIM');
            $table->date('TGL_KIRIM');
            $table->integer('PENERIMA');
            $table->integer('DARI');
            $table->string('NAMAPENGIRIM');
            $table->string('KD_BHN');
            $table->string('NAMABARANG');
            $table->string('SATUAN');
            $table->double('QT_KIRIM');
            $table->double('QT_TERIMA');
            $table->double('QT_SISA');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('laporanpenerimaans');
    }
};
