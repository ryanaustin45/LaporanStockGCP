<?php

namespace App\Exports;

use App\Models\Laporanperbandingan;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;


class LaporanperbandinganExport implements FromCollection, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return Laporanperbandingan::get();
    }
    public function headings(): array
    {
        return [

            "BUKTI KIRIM", "TGL KIRIM", "DARI", "NAMA DARI", "TGL ERIMA",
            "PENERIMA", "NAMA PENERIMA", "KD BHN",
            "NAMA BARANG", "SATUAN", "QT KIRIM",
            "QT TERIMA", "QT SISA"
        ];
    }
}
