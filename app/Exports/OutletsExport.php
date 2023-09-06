<?php

namespace App\Exports;

use App\Models\Outlet;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;


class OutletsExport implements FromCollection, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return Outlet::select("KODE", "NAMA", "ALAMAT", "ADMIN_PO", "ADMIN_SPB")->get();
    }
    public function headings(): array
    {
        return ["KODE", "NAMA", "ALAMAT", "ADMIN_PO", "ADMIN_SPB"];
    }
}
