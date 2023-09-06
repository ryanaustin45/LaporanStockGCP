<?php

namespace App\Imports;

use App\Models\Laporanpengiriman;
use Maatwebsite\Excel\Concerns\ToModel;
use PhpOffice\PhpSpreadsheet\Shared\Date;


class LaporanpengirimanImport  implements ToModel
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */

    public function model(array $row)
    {
        return new Laporanpengiriman([
            //
            'BUKTI_KIRIM' => $row['0'],
            'TGL_KIRIM' => Date::excelToDateTimeObject($row['1']),
            'DARI' => $row['2'],
            'KEPADA' => $row['3'],
            'NAMAPENERIMA' => $row['4'],
            'KODE_BAHAN' => $row['5'],
            'NAMABARANG' => $row['6'],
            'SATUAN' => $row['7'],
            'QT_KIRIM' => $row['8'],
            'QT_TERIMA' => $row['9'],
            'QT_SISA' => $row['10'],
        ]);
    }
}
