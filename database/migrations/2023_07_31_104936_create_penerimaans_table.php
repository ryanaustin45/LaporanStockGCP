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
        Schema::create('penerimaans', function (Blueprint $table) {
            $table->string('LPB');
            $table->date('TANGGAL');
            $table->string('FAKTUR');
            $table->integer('PENERIMA');
            $table->integer('DARI');
            $table->string('NAMAPELANGGAN');
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
        Schema::dropIfExists('penerimaans');
    }
};
