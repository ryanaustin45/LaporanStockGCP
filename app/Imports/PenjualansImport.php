<?php

namespace App\Imports;

use App\Models\Penjualan;
use Maatwebsite\Excel\Concerns\ToModel;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use Illuminate\Contracts\Queue\ShouldQueue;
use Maatwebsite\Excel\Concerns\WithChunkReading;

class PenjualansImport implements ToModel, WithChunkReading, ShouldQueue
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        return new Penjualan([
            'TANGGAL' => Date::excelToDateTimeObject($row['0']),
            'KODE_OUTLET' => $row['1'],
            'Outlet' => $row['2'],
            'KODE_BARANG' => $row['3'],
            'Barang' => $row['4'],
            'Banyak' => $row['5'],
            'Jumlah' => $row['6'],
            //
        ]);
    }
    public function batchSize(): int
    {
        return 10000;
    }
    public function chunkSize(): int
    {
        return 10000;
    }
}
