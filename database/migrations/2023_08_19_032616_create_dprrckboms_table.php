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
        Schema::create('dprrckboms', function (Blueprint $table) {
            $table->string('KODE_BAHAN');
            $table->string('NAMA_BAHAN');
            $table->double('BANYAK');
            $table->string('SATUAN_BAHAN');
            $table->string('KODE_BARANG');
            $table->string('NAMA_BARANG');
            $table->string('SATUAN_BARANG');
            $table->double('Harga')->nullable();
            $table->double('HargaBarang')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('dprrckboms');
    }
};
