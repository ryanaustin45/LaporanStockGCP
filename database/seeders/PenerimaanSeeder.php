<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Penerimaan;
use App\Models\Convertpenerimaan;

class PenerimaanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $penerimaanss = Penerimaan::join('items', 'items.KODE_BARANG_PURCHASING', '=', 'penerimaans.KD_BHN')
            ->join('outlets', 'outlets.KODE', '=', 'penerimaans.PENERIMA')
            ->select(
                'penerimaans.TANGGAL as TANGGAL',
                'penerimaans.PENERIMA as PENERIMA',
                'outlets.NAMA as ALAMAT',
                'penerimaans.DARI as DARI',
                'penerimaans.NAMAPELANGGAN as NAMAPELANGGAN',
                'items.KODE_BARANG_SAGE as KODE_BARANG_SAGE',
                'items.KODE_DESKRIPSI_BARANG_SAGE as KODE_DESKRIPSI_BARANG_SAGE',
                'items.BUYING_UNIT_SAGE as STOKING_UNIT_BOM',
                Penerimaan::raw('(penerimaans.QT_TERIMA * items.RUMUS_Untuk_Purchase) as QUANTITY'),
                'items.Harga'
            )->groupBy('penerimaans.KD_BHN', 'penerimaans.PENERIMA', 'penerimaans.DARI', 'penerimaans.TANGGAL')->get();
        // menjadi convert penerimaan 
        $dataconvertpenerimaan = [];
        $longarray = 0;
        foreach ($penerimaanss as $penerimaansss) {
            if ($penerimaansss->QUANTITY != 0) {
                $dataconvertpenerimaan[] = [
                    'TANGGAL' => $penerimaansss->TANGGAL,
                    'PENERIMA' => $penerimaansss->PENERIMA,
                    'NAMAPENERIMA' => $penerimaansss->ALAMAT,
                    'DARI' => $penerimaansss->DARI,
                    'NAMADARI' => $penerimaansss->NAMAPELANGGAN,
                    'KODE_BARANG_SAGE' => $penerimaansss->KODE_BARANG_SAGE,
                    'KODE_DESKRIPSI_BARANG_SAGE' => $penerimaansss->KODE_DESKRIPSI_BARANG_SAGE,
                    'STOKING_UNIT_BOM' => $penerimaansss->STOKING_UNIT_BOM,
                    'QUANTITY' => $penerimaansss->QUANTITY,
                    'HARGA' => $penerimaansss->Harga,
                    'JUMLAH' => $penerimaansss->QUANTITY * $penerimaansss->Harga
                ];
                $longarray = $longarray + 1;
            }
        }
        foreach (array_chunk($dataconvertpenerimaan, $longarray) as $data) {
            Convertpenerimaan::insert($data);
        }
    }
}
