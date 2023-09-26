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
        Schema::create('itemakuns', function (Blueprint $table) {
            $table->string('KODE_BARANG_SAGE');
            $table->string('KODE_DESKRIPSI_BARANG_SAGE');
            $table->string('STOKING_UNIT_BOM');
            $table->string('BUYING_UNIT');
            $table->string('Akun_Pembelian')->nullable();
            $table->string('Deskripsi_Akun_Pembelian')->nullable();
            $table->string('Akun_Biaya')->nullable();
            $table->string('Deskripsi_Akun_Biaya')->nullable();
            $table->string('Akun_COGS')->nullable();
            $table->string('Deskripsi_Akun_COGS')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('itemakuns');
    }
};
