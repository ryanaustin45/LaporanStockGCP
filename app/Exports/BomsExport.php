<?php

namespace App\Exports;

use App\Models\Laporanakhir;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class BomsExport implements FromCollection, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return Laporanakhir::get();
    }
    public function headings(): array
    {
        return  [
            ["Laporan Stock"],
            [
                "Kode Outlet", "Nama", "Kode Item", "Nama Item", "Satuan Unit",
                "Saldo Awal Quantity", "Saldo Awal Price", "Saldo Awal Amount",
                "Pembelian Quantity", "Pembelian Price", "Pembelian Amount",
                "Penerimaan Quantity", "Penerimaan Price", "Penerimaan Amount",
                "TransferIn Quantity", "TransferIn Price", "TransferIn Amount",
                "Pengiriman Quantity", "Pengiriman Price", "Pengiriman Amount",
                "Bom Quantity", "Bom Price", "Bom Amount",
                "TransferOut Quantity", "TransferOut Price", "TransferOut Amount",
                "Biaya Quantity", "Biaya Price", "Biaya Amount",
                "Saldo Akhir Quantity", "Saldo Akhir Price", "Saldo Akhir Amount"
            ]
        ];
    }
}
