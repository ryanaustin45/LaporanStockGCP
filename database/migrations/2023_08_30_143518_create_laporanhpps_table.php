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
        Schema::create('laporanhpps', function (Blueprint $table) {
            $table->date('TANGGAL');
            $table->string('KODE_OUTLET');
            $table->string('Outlet');
            $table->string('KODE_BARANG');
            $table->string('Barang');
            $table->double('Banyak');
            $table->double('Jumlah');
            $table->double('Revenue')->nullable();
            $table->double('COGS')->nullable();
            $table->double('Profit')->nullable();
            $table->double('Margin')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('laporanhpps');
    }
};
