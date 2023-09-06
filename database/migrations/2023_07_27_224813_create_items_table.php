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
        Schema::create('items', function (Blueprint $table) {
            $table->string('KODE_BARANG_PURCHASING');
            $table->string('KODE_DESKRIPSI_BARANG_PURCHASING');
            $table->string('SATUAN');
            $table->string('KODE_BARANG_SAGE');
            $table->string('KODE_DESKRIPSI_BARANG_SAGE');
            $table->string('BUYING_UNIT_SAGE');
            $table->double('RUMUS_Untuk_Purchase');
            $table->string('STOKING_UNIT_BOM');
            $table->double('RUMUS_untuk_BOM');
            $table->integer('AccPersediaan');
            $table->integer('AccBiaya');
            $table->integer('AccRev')->nullable();
            $table->double('Harga')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('items');
    }
};
