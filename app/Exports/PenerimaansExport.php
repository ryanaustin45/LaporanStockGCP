<?php

namespace App\Exports;

use App\Models\Convertpenerimaan;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class PenerimaansExport implements FromCollection, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $penerimaans = Convertpenerimaan::get();

        return $penerimaans;
    }
    public function headings(): array
    {
        return ["TANGGAL", "PENERIMA", "NAMA PENERIMA", "DARI", "NAMA DARI", "KODE ITEM", "NAMA ITEM", "SATUAN", "QUANTITY", "HARGA", "NILAI"];
    }
}
