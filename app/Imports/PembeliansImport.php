<?php

namespace App\Imports;

use App\Models\Pembelian;
use Maatwebsite\Excel\Concerns\ToModel;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use Illuminate\Contracts\Queue\ShouldQueue;
use Maatwebsite\Excel\Concerns\WithChunkReading;

class PembeliansImport implements ToModel, WithChunkReading, ShouldQueue
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */

    public function model(array $row)
    {
        return new Pembelian([
            //
            'LPB' => $row['0'],
            'FAKTUR' => $row['1'],
            'TANGGAL' => Date::excelToDateTimeObject($row['2']),
            'KD_SUP' => $row['3'],
            'KD_CUS' => $row['4'],
            'NAMAPELANGGAN' => $row['5'],
            'NAMASUPLIER' => $row['6'],
            'KD_BRG' => $row['7'],
            'NAMABARANG' => $row['8'],
            'NAMA_BARANG_DISUPLIER' => $row['9'],
            'SATUAN' => $row['10'],
            'BANYAK' => $row['11'],
            'HARGA' => $row['12'],
            'JUMLAH' => $row['13'],
        ]);
    }

    public function chunkSize(): int
    {
        return 10000;
    }
}
