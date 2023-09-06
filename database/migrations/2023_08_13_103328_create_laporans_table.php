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
        Schema::create('laporans', function (Blueprint $table) {
            $table->date('TANGGAL');
            $table->integer('KODE');
            $table->string('NAMA');
            $table->string('KODE_BARANG_SAGE');
            $table->string('KODE_DESKRIPSI_BARANG_SAGE');
            $table->string('STOKING_UNIT_BOM');
            $table->double('SAwalUnit')->nullable();
            $table->double('SAwalQuantity')->nullable();
            $table->double('SAwalPrice')->nullable();
            $table->double('Pembelian_Unit')->nullable();
            $table->double('Pembelian_Quantity')->nullable();
            $table->double('Pembelian_Price')->nullable();
            $table->double('Penerimaan_Unit')->nullable();
            $table->double('Penerimaan_Quantity')->nullable();
            $table->double('Penerimaan_Price')->nullable();
            $table->double('TransferIn_Unit')->nullable();
            $table->double('TransferIn_Quantity')->nullable();
            $table->double('TransferIn_Price')->nullable();
            $table->double('Pengiriman_Unit')->nullable();
            $table->double('Pengiriman_Quantity')->nullable();
            $table->double('Pengiriman_Price')->nullable();
            $table->double('Bom_Unit')->nullable();
            $table->double('Bom_Quantity')->nullable();
            $table->double('Bom_Price')->nullable();
            $table->double('TransferOut_Unit')->nullable();
            $table->double('TransferOut_Quantity')->nullable();
            $table->double('TransferOut_Price')->nullable();
            $table->double('BiayaUnit')->nullable();
            $table->double('BiayaQuantity')->nullable();
            $table->double('BiayaPrice')->nullable();
            $table->double('SAkhirUnit')->nullable();
            $table->double('SAkhirQuantity')->nullable();
            $table->double('SAkhirPrice')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('laporans');
    }
};
