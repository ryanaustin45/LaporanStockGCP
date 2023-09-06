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
        Schema::create('convertpenerimaans', function (Blueprint $table) {
            $table->date('TANGGAL');
            $table->integer('PENERIMA');
            $table->string('NAMAPENERIMA');
            $table->integer('DARI');
            $table->string('NAMADARI');
            $table->string('KODE_BARANG_SAGE');
            $table->string('KODE_DESKRIPSI_BARANG_SAGE');
            $table->string('STOKING_UNIT_BOM');
            $table->double('QUANTITY')->nullable();
            $table->double('HARGA')->nullable();
            $table->double('JUMLAH')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('convertpenerimaans');
    }
};
