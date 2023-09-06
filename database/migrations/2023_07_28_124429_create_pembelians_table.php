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
        Schema::create('pembelians', function (Blueprint $table) {
            $table->string('LPB');
            $table->string('FAKTUR');
            $table->date('TANGGAL');
            $table->string('KD_SUP');
            $table->integer('KD_CUS');
            $table->string('NAMAPELANGGAN');
            $table->string('NAMASUPLIER');
            $table->string('KD_BRG');
            $table->string('NAMABARANG');
            $table->string('NAMA_BARANG_DISUPLIER');
            $table->string('SATUAN');
            $table->double('BANYAK');
            $table->double('HARGA');
            $table->double('JUMLAH');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pembelians');
    }
};
