<?php

namespace App\Imports;

use App\Models\Penerimaan;
use Maatwebsite\Excel\Concerns\ToModel;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class PenerimaansImport implements ToModel
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        return new Penerimaan([
            'LPB' => $row['0'],
            'TANGGAL' => Date::excelToDateTimeObject($row['1']),
            'FAKTUR' => $row['2'],
            'PENERIMA' => $row['3'],
            'DARI' => $row['4'],
            'NAMAPELANGGAN' => $row['5'],
            'KD_BHN' => $row['6'],
            'NAMABARANG' => $row['7'],
            'SATUAN' => $row['8'],
            'QT_KIRIM' => $row['9'],
            'QT_TERIMA' => $row['10'],
            'QT_SISA' => $row['11'],
            //
        ]);
    }
}
