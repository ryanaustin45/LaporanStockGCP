<?php

namespace App\Imports;

use App\Models\Laporanpenerimaan;
use Maatwebsite\Excel\Concerns\ToModel;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class LaporanpenerimaanImport  implements ToModel
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */

    public function model(array $row)
    {
        return new Laporanpenerimaan([
            //
            'LPB' => $row['0'],
            'TGL_TERIMA' => Date::excelToDateTimeObject($row['1']),
            'FAKTUR' => $row['2'],
            'BUKTI_KIRIM' => $row['3'],
            'TGL_KIRIM' => Date::excelToDateTimeObject($row['4']),
            'PENERIMA' => $row['5'],
            'DARI' => $row['6'],
            'NAMAPENGIRIM' => $row['7'],
            'KD_BHN' => $row['8'],
            'NAMABARANG' => $row['9'],
            'SATUAN' => $row['10'],
            'QT_KIRIM' => $row['11'],
            'QT_TERIMA' => $row['12'],
            'QT_SISA' => $row['13'],
        ]);
    }
}
