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
        Schema::create('rekapcogs', function (Blueprint $table) {
            $table->date('TANGGAL');
            $table->integer('KODE');
            $table->string('NAMA');
            $table->double('Pembelian_Unit')->nullable();
            $table->string('akun')->nullable();
            $table->double('SAwalPrice')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rekapcogs');
    }
};
