<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Exports\LaporanperbandinganExport;
use App\Imports\LaporanpenerimaanImport;
use App\Imports\LaporanpengirimanImport;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Laporanpenerimaan;
use App\Models\Laporanpengiriman;
use App\Models\Laporanperbandingan;
use App\Models\Convertlaporanpenerimaan;
use App\Models\Convertlaporanpengiriman;
use Illuminate\Support\Facades\Auth;


class PerbandinganController extends Controller
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function index()
    {
        if (Auth::check()) {
            return view('Perbandingan');
        }

        return redirect("/")->withSuccess('Opps! You do not have access');
    }
    public function importPenerimaan()
    {
        if (Auth::check()) {
            Laporanpenerimaan::truncate();

            Excel::import(new LaporanpenerimaanImport, request()->file('file'));
            $laporanpenerimaan = Laporanpenerimaan::join('items', 'laporanpenerimaans.KD_BHN', '=', 'items.KODE_BARANG_PURCHASING')
                ->join('outlets', 'outlets.KODE', '=', 'laporanpenerimaans.PENERIMA')
                ->select(
                    'LPB',
                    'TGL_TERIMA',
                    'FAKTUR',
                    'BUKTI_KIRIM',
                    'TGL_KIRIM',
                    'PENERIMA',
                    'DARI',
                    'outlets.NAMA',
                    'NAMAPENGIRIM',
                    'items.KODE_BARANG_SAGE as sage',
                    'items.KODE_DESKRIPSI_BARANG_SAGE as sagebarang',
                    'items.BUYING_UNIT_SAGE as sageunit',
                    'QT_KIRIM',
                    Laporanpenerimaan::raw('laporanpenerimaans.QT_TERIMA* items.RUMUS_Untuk_Purchase as sageharga'),
                    'QT_SISA'
                )->get();
            foreach ($laporanpenerimaan as $laporanpenerimaans) {
                if ($laporanpenerimaans->sageharga != 0) {
                    Convertlaporanpenerimaan::create([
                        'LPB' => $laporanpenerimaans->LPB,
                        'TGL_TERIMA' => $laporanpenerimaans->TGL_TERIMA,
                        'FAKTUR' => $laporanpenerimaans->FAKTUR,
                        'BUKTI_KIRIM' => $laporanpenerimaans->BUKTI_KIRIM,
                        'TGL_KIRIM' => $laporanpenerimaans->TGL_KIRIM,
                        'PENERIMA' => $laporanpenerimaans->PENERIMA,
                        'NAMAPENERIMA' => $laporanpenerimaans->NAMA,
                        'DARI' => $laporanpenerimaans->DARI,
                        'NAMAPENGIRIM' => $laporanpenerimaans->NAMAPENGIRIM,

                        'KD_BHN' => $laporanpenerimaans->sage,
                        'NAMABARANG' => $laporanpenerimaans->sagebarang,
                        'SATUAN' => $laporanpenerimaans->sageunit,
                        'QT_TERIMA' => $laporanpenerimaans->sageharga,

                        'QT_KIRIM' => $laporanpenerimaans->QT_KIRIM,

                        'QT_SISA' => $laporanpenerimaans->QT_SISA

                    ]);
                }
            }

            return back()->with('success', 'Berhasil Upload');
        }

        return redirect("/")->withSuccess('Opps! You do not have access');
    }

    public function importPengiriman()
    {
        if (Auth::check()) {
            Laporanpengiriman::truncate();

            Excel::import(new LaporanpengirimanImport, request()->file('file'));
            $laporanpengiriman = Laporanpengiriman::join('items', 'laporanpengirimans.KODE_BAHAN', '=', 'items.KODE_BARANG_PURCHASING')
                ->join('outlets', 'outlets.KODE', '=', 'laporanpengirimans.DARI')
                ->select(
                    'BUKTI_KIRIM',
                    'TGL_KIRIM',
                    'DARI',
                    'KEPADA',
                    'outlets.NAMA',
                    'NAMAPENERIMA',
                    'items.KODE_BARANG_SAGE as sage',
                    'items.KODE_DESKRIPSI_BARANG_SAGE as sagebahan',
                    'items.BUYING_UNIT_SAGE as sageunit',
                    Laporanpengiriman::raw('laporanpengirimans.QT_KIRIM * items.RUMUS_Untuk_Purchase as sageharga'),
                    'QT_TERIMA',
                    'QT_SISA'
                )->get();

            foreach ($laporanpengiriman as $laporanpengirimans) {
                if ($laporanpengirimans->sageharga != 0) {
                    Convertlaporanpengiriman::create([
                        'BUKTI_KIRIM' => $laporanpengirimans->BUKTI_KIRIM,
                        'TGL_KIRIM' => $laporanpengirimans->TGL_KIRIM,
                        'DARI' => $laporanpengirimans->DARI,
                        'KEPADA' => $laporanpengirimans->KEPADA,
                        'NAMAPENERIMA' => $laporanpengirimans->NAMAPENERIMA,
                        'NAMADARI' => $laporanpengirimans->NAMA,

                        'KODE_BAHAN' => $laporanpengirimans->sage,
                        'NAMABARANG' => $laporanpengirimans->sagebahan,
                        'SATUAN' => $laporanpengirimans->sageunit,

                        'QT_KIRIM' => $laporanpengirimans->sageharga,

                        'QT_TERIMA' => $laporanpengirimans->QT_TERIMA,

                        'QT_SISA' => $laporanpengirimans->QT_SISA
                    ]);
                }
            }
            return back()->with('success', 'Berhasil Upload');
        }

        return redirect("/")->withSuccess('Opps! You do not have access');
    }

    public function laporanpengiriman()
    {
        if (Auth::check()) {
            $laporanpengirimans2 = Laporanperbandingan::get();
            Laporanperbandingan::truncate();

            return view('Laporanperbandingan', compact('laporanpengirimans2'));
        }

        return redirect("/")->withSuccess('Opps! You do not have access');
    }

    public function Hasillaporanpengiriman(Request $request)
    {
        if (Auth::check()) {
            // menangkap data pencarian
            Laporanperbandingan::truncate();

            $Tanggal_awal = $request->Tanggal_awal;
            $Tanggal_akhir = $request->Tanggal_akhir;

            /*$laporanpengirimans = Convertlaporanpengiriman::leftjoin('convertlaporanpenerimaans', 'convertlaporanpenerimaans.BUKTI_KIRIM', '=', 'convertlaporanpengirimans.BUKTI_KIRIM')
                ->select(
                'convertlaporanpengirimans.BUKTI_KIRIM as BK',
            'convertlaporanpengirimans.TGL_KIRIM as TK',
            'convertlaporanpengirimans.DARI AS DR',
            'convertlaporanpengirimans.NAMADARI as ndr',

            'convertlaporanpenerimaans.TGL_TERIMA as Tter',
            'convertlaporanpengirimans.KEPADA as pene',
            'convertlaporanpengirimans.NAMAPENERIMA as nape',

            'convertlaporanpengirimans.KODE_BAHAN as kB',
            'convertlaporanpengirimans.NAMABARANG as NB',
            'convertlaporanpengirimans.SATUAN as stn',
            'convertlaporanpengirimans.QT_KIRIM as kirr',

                Convertlaporanpengiriman::raw('IFNULL(sum(convertlaporanpenerimaans.QT_TERIMA), 0) as ter')

                )->whereDate('convertlaporanpengirimans.TGL_KIRIM', '>=', $Tanggal_awal)->whereDate('convertlaporanpengirimans.TGL_KIRIM', '<=', $Tanggal_akhir)->whereDate('convertlaporanpenerimaans.TGL_TERIMA', '<=', $Tanggal_akhir)->get();
                    foreach ($laporanpengirimans as $laporanpengirimans1) {
                        Laporanperbandingan::create([
                            'BUKTI_KIRIM' => $laporanpengirimans1->BK,
                            'TGL_KIRIM' => $laporanpengirimans1->TK,
                            'DARI' => $laporanpengirimans1->DR,
                            'NAMADARI' => $laporanpengirimans1->ndr,
                            'TGL_TERIMA' => $laporanpengirimans1->Tter,
                            'PENERIMA' => $laporanpengirimans1->pene,
                            'NAMAPENERIMA' => $laporanpengirimans1->nape,
                            'KD_BHN' => $laporanpengirimans1->kB,
                            'NAMABARANG' => $laporanpengirimans1->NB,
                            'SATUAN' => $laporanpengirimans1->stn,
                            'QT_KIRIM' => $laporanpengirimans1->kirr,
                            'QT_TERIMA' => $laporanpengirimans1->ter,
                            'QT_SISA' => Laporanperbandingan::raw('QT_KIRIM - QT_TERIMA')
                        ]);
                    }           */
            $laporanpengirimans = Convertlaporanpengiriman::whereDate('convertlaporanpengirimans.TGL_KIRIM', '>=', $Tanggal_awal)->whereDate('convertlaporanpengirimans.TGL_KIRIM', '<=', $Tanggal_akhir)->get();
            foreach ($laporanpengirimans as $laporanpengirimans) {
                Laporanperbandingan::create([
                    'BUKTI_KIRIM' => $laporanpengirimans->BUKTI_KIRIM,
                    'TGL_KIRIM' => $laporanpengirimans->TGL_KIRIM,
                    'DARI' => $laporanpengirimans->DARI,
                    'NAMADARI' => $laporanpengirimans->NAMADARI,
                    'PENERIMA' => $laporanpengirimans->KEPADA,
                    'NAMAPENERIMA' => $laporanpengirimans->NAMAPENERIMA,
                    'KD_BHN' => $laporanpengirimans->KODE_BAHAN,
                    'NAMABARANG' => $laporanpengirimans->NAMABARANG,
                    'SATUAN' => $laporanpengirimans->SATUAN,
                    'QT_KIRIM' => $laporanpengirimans->QT_KIRIM,
                    'QT_TERIMA' => 0,
                    'QT_SISA' => $laporanpengirimans->QT_KIRIM
                ]);
            }

            $laporanpengirimansupdate = Convertlaporanpenerimaan::whereDate('convertlaporanpenerimaans.TGL_TERIMA', '<=', $Tanggal_akhir)
                ->select('BUKTI_KIRIM', 'PENERIMA', 'DARI', 'KD_BHN', 'TGL_TERIMA', Convertlaporanpenerimaan::raw('sum(convertlaporanpenerimaans.QT_TERIMA) as ter'))
                ->groupBy('BUKTI_KIRIM', 'PENERIMA', 'DARI', 'KD_BHN')->get();


            foreach ($laporanpengirimansupdate as $laporanpengirimansupdates) {
                Laporanperbandingan::where('BUKTI_KIRIM', $laporanpengirimansupdates->BUKTI_KIRIM)
                    ->where('DARI', $laporanpengirimansupdates->DARI)->where('PENERIMA', $laporanpengirimansupdates->PENERIMA)
                    ->where('KD_BHN', $laporanpengirimansupdates->KD_BHN)
                    ->update([
                        'TGL_TERIMA' => $laporanpengirimansupdates->TGL_TERIMA,
                        'QT_TERIMA' => $laporanpengirimansupdates->ter,
                        'QT_SISA' => Laporanperbandingan::raw('QT_KIRIM - QT_TERIMA')
                    ]);
            }
            $laporanpengirimans2 = Laporanperbandingan::where('QT_SISA', '<>', 0)->get();
            return view('Laporanperbandingan', compact('laporanpengirimans2'));
        }

        return redirect("/")->withSuccess('Opps! You do not have access');
    }

    public function deleteperbandingandata()
    {
        if (Auth::check()) {
            Laporanperbandingan::truncate();
            Laporanpenerimaan::truncate();
            Laporanpengiriman::truncate();
            Convertlaporanpengiriman::truncate();
            Convertlaporanpenerimaan::truncate();

            return back();
        }

        return redirect("/")->withSuccess('Opps! You do not have access');
    }
    public function LaporanPerbandinganexport()
    {
        if (Auth::check()) {
            /* <tr>
                                <th colspan="12">
                                    <a class="btn btn-danger float-end" href="{{ route('laporanpengirimans.export') }}">Export Convert Data Penerimaan Internal</a>
                                </th>
                            </tr>
                            */
            return Excel::download(new LaporanperbandinganExport, 'LaporanPengiriman.xlsx');
        }

        return redirect("/")->withSuccess('Opps! You do not have access');
    }

    public function carilaporan(Request $request)
    {

        if (Auth::check()) {
            $cari = $request->cari;
            $laporanpengirimans2 = Laporanperbandingan::where('DARI', $cari)->get();
            return view('Laporanperbandingan', compact('laporanpengirimans2'));
        }

        return redirect("/")->withSuccess('Opps! You do not have access');
    }
}
