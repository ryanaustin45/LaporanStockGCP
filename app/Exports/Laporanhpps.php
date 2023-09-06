<?php

namespace App\Exports;

use App\Models\Laporanhpp;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class Laporanhpps implements FromCollection, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return Laporanhpp::get();
    }
    public function headings(): array
    {
        return
            [
                "TANGGAL", "KODE OUTLET", "Outlet", "KODE BARANG", "Barang",
                "Banyak", "Jumlah", "Revenue",
                "COGS", "Profit", "Margint"

            ];
    }
}
