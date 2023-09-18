<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Pembelian;
use App\Models\Laporan;


class PembelianSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $pembelians1 = Pembelian::select(
            'pembelians.TANGGAL',
            'pembelians.KD_CUS',
            'pembelians.NAMAPELANGGAN',
            'items.KODE_BARANG_SAGE',
            'items.KODE_DESKRIPSI_BARANG_SAGE',
            'items.STOKING_UNIT_BOM',
            Pembelian::raw('(pembelians.BANYAK * items.RUMUS_Untuk_Purchase) / items.RUMUS_untuk_BOM as QUANTITY'),
            //Pembelian::raw('(pembelians.JUMLAH / ((pembelians.BANYAK *items. RUMUS_Untuk_Purchase) / items.RUMUS_untuk_BOM))as HARGA'),
            'pembelians.JUMLAH'
        )->join('items', 'pembelians.KD_BRG', '=', 'items.KODE_BARANG_PURCHASING')->get();
        /* masuk kedalam database convert pembelian dari pembelian */
        $datalaporanpembelian = [];
        $longarray = 0;
        foreach ($pembelians1 as $pembelians12) {
            if ($pembelians12->QUANTITY != 0) {
                $datalaporanpembelian[] = [
                    'TANGGAL' => $pembelians12->TANGGAL,
                    'KODE' => $pembelians12->KD_CUS,
                    'NAMA' => $pembelians12->NAMAPELANGGAN,
                    'KODE_BARANG_SAGE' => $pembelians12->KODE_BARANG_SAGE,
                    'KODE_DESKRIPSI_BARANG_SAGE' => $pembelians12->KODE_DESKRIPSI_BARANG_SAGE,
                    'STOKING_UNIT_BOM' => $pembelians12->STOKING_UNIT_BOM,
                    'Pembelian_Unit' => $pembelians12->QUANTITY,
                    'Pembelian_Quantity' => $pembelians12->JUMLAH / $pembelians12->QUANTITY,
                    'Pembelian_Price' => $pembelians12->JUMLAH
                ];
                $longarray = $longarray + 1;
            }
        }

        foreach (array_chunk($datalaporanpembelian, $longarray) as $data) {
            Laporan::insert($data);
        }
    }
}