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
        Schema::create('laporanperbandingans', function (Blueprint $table) {
            $table->string('BUKTI_KIRIM');
            $table->date('TGL_KIRIM');
            $table->integer('DARI');
            $table->string('NAMADARI');


            $table->date('TGL_TERIMA')->nullable();
            $table->integer('PENERIMA');
            $table->string('NAMAPENERIMA');

            $table->string('KD_BHN');
            $table->string('NAMABARANG');
            $table->string('SATUAN');
            $table->double('QT_KIRIM');

            $table->double('QT_TERIMA')->nullable();

            $table->double('QT_SISA')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('laporanperbandingans');
    }
};
