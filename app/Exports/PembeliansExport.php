<?php

namespace App\Exports;

use App\Models\Convertpembelian;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;



class PembeliansExport implements FromCollection, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $pembelians = Convertpembelian::get();

        return $pembelians;
    }
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function headings(): array
    {
        return ["TANGGAL", "KODE OUTLET", "NAMA OUTLET", "KODE ITEM", "NAMA ITEM", "SATUAN", "QUANTITY", "HARGA", "NILAI"];
    }
}
