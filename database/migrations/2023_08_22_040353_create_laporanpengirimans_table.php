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
        Schema::create('laporanpengirimans', function (Blueprint $table) {
            $table->string('BUKTI_KIRIM');
            $table->date('TGL_KIRIM');
            $table->integer('DARI');
            $table->integer('KEPADA');
            $table->string('NAMAPENERIMA');
            $table->string('KODE_BAHAN');
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
        Schema::dropIfExists('laporanpengirimans');
    }
};
