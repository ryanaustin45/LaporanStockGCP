<?php

namespace App\Exports;

use App\Models\Item;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ItemsExport implements FromCollection, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return Item::select("KODE_BARANG_PURCHASING", "KODE_DESKRIPSI_BARANG_PURCHASING", "SATUAN", "KODE_BARANG_SAGE", "KODE_DESKRIPSI_BARANG_SAGE", "BUYING_UNIT_SAGE", "RUMUS_Untuk_Purchase", "STOKING_UNIT_BOM", "RUMUS_untuk_BOM", "AccPersediaan", "AccBiaya", "AccRev")->get();
    }
    public function headings(): array
    {
        return ["KODE BARANG PURCHASING", "KODE DESKRIPSI BARANG PURCHASING", "SATUAN", "KODE BARANG SAGE", "KODE DESKRIPSI BARANG SAGE", "BUYING UNIT SAGE", "RUMUS Untuk Purchase", "STOKING UNIT BOM", "RUMUS untuk BOM<", "Acc. Persediaan", "Acc. Biaya", "Acc. Rev"];
    }
}
