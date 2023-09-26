<?php

namespace App\Http\Controllers;

use App\Exports\BomsExport;
use App\Exports\Laporanhpps;
use App\Models\Bom;
use App\Models\Pembelian;
use App\Models\Laporan;
use App\Models\Laporanakhir;
use App\Models\Dprbom;
use App\Models\Dprrckbom;
use App\Models\Laporanhpp;
use App\Models\Penjualan;
use App\Models\Convertbom;
use App\Models\Convertpembelian;
use App\Models\Rekapbiaya;
use App\Models\Rekapcog;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

ini_set('max_execution_time', 160000);
ini_set('default_socket_timeout', 160000);


class BomController extends Controller
{
    public function index()
    {
        if (Auth::check()) {
            // sql = SELECT * FROM penjualans JOIN boms ON boms.KODE_BARANG LIKE CONCAT('%', penjualans.KODE_OUTLET ,'%') AND boms.KODE_BARANG LIKE CONCAT('%', penjualans.KODE_BARANG ,'%');

            // buat nyari quantity SELECT convertpembelians.KODE_DESKRIPSI_BARANG_SAGE, sum(convertpembelians.QUANTITY) FROM `convertpembelians` GROUP BY convertpembelians.KODE_DESKRIPSI_BARANG_SAGE, convertpembelians.KODE 
            //Outlet::where('KODE', 123)->update(['NAMA' => 'Updated title']);*/
            /*
        $laporantengah = Laporan::get();
        foreach ($laporantengah as $Laporandatass) {
            Laporan::Where('laporans.TANGGAL', $Laporandatass->TANGGAL)->where('laporans.KODE', $Laporandatass->KODE)->where('laporans.KODE_BARANG_SAGE', $Laporandatass->KODE_BARANG_SAGE)
                ->update([
                    'laporans.TransferIn_Unit' => $Laporandatass->SAwalUnit + $Laporandatass->Pembelian_Unit + $Laporandatass->Penerimaan_Unit,
                    'laporans.TransferIn_Price' => $Laporandatass->SAwalPrice + $Laporandatass->Pembelian_Price + $Laporandatass->Penerimaan_Price,
                    'laporans.TransferIn_Quantity' => ($Laporandatass->SAwalPrice + $Laporandatass->Pembelian_Price + $Laporandatass->Penerimaan_Price) / ($Laporandatass->SAwalUnit + $Laporandatass->Pembelian_Unit + $Laporandatass->Penerimaan_Unit),

                    'laporans.Pengiriman_Quantity' => ($Laporandatass->SAwalPrice + $Laporandatass->Pembelian_Price + $Laporandatass->Penerimaan_Price) / ($Laporandatass->SAwalUnit + $Laporandatass->Pembelian_Unit + $Laporandatass->Penerimaan_Unit),
                    'laporans.Pengiriman_Price' => (($Laporandatass->SAwalPrice + $Laporandatass->Pembelian_Price + $Laporandatass->Penerimaan_Price) / ($Laporandatass->SAwalUnit + $Laporandatass->Pembelian_Unit + $Laporandatass->Penerimaan_Unit)) *  $Laporandatass->Pengiriman_Unit,

                    'laporans.Bom_Quantity' => ($Laporandatass->SAwalPrice + $Laporandatass->Pembelian_Price + $Laporandatass->Penerimaan_Price) / ($Laporandatass->SAwalUnit + $Laporandatass->Pembelian_Unit + $Laporandatass->Penerimaan_Unit),
                    'laporans.Bom_Price' => (($Laporandatass->SAwalPrice + $Laporandatass->Pembelian_Price + $Laporandatass->Penerimaan_Price) / ($Laporandatass->SAwalUnit + $Laporandatass->Pembelian_Unit + $Laporandatass->Penerimaan_Unit)) *  $Laporandatass->Bom_Unit,

                    'laporans.TransferOut_Unit' => $Laporandatass->Pengiriman_Unit + $Laporandatass->Bom_Unit,
                    'laporans.TransferOut_Quantity' => ($Laporandatass->SAwalPrice + $Laporandatass->Pembelian_Price + $Laporandatass->Penerimaan_Price) / ($Laporandatass->SAwalUnit + $Laporandatass->Pembelian_Unit + $Laporandatass->Penerimaan_Unit),
                    'laporans.TransferOut_Price' => (($Laporandatass->SAwalPrice + $Laporandatass->Pembelian_Price + $Laporandatass->Penerimaan_Price) / ($Laporandatass->SAwalUnit + $Laporandatass->Pembelian_Unit + $Laporandatass->Penerimaan_Unit)) * ($Laporandatass->Pengiriman_Unit + $Laporandatass->Bom_Unit),

                    'laporans.SAkhirUnit' => ($Laporandatass->SAwalUnit + $Laporandatass->Pembelian_Unit + $Laporandatass->Penerimaan_Unit) - ($Laporandatass->Pengiriman_Unit + $Laporandatass->Bom_Unit),
                    'laporans.SAkhirQuantity' => ($Laporandatass->SAwalPrice + $Laporandatass->Pembelian_Price + $Laporandatass->Penerimaan_Price) / ($Laporandatass->SAwalUnit + $Laporandatass->Pembelian_Unit + $Laporandatass->Penerimaan_Unit),
                    'laporans.SAkhirPrice' => (($Laporandatass->SAwalPrice + $Laporandatass->Pembelian_Price + $Laporandatass->Penerimaan_Price) / ($Laporandatass->SAwalUnit + $Laporandatass->Pembelian_Unit + $Laporandatass->Penerimaan_Unit)) * (($Laporandatass->SAwalUnit + $Laporandatass->Pembelian_Unit + $Laporandatass->Penerimaan_Unit) - ($Laporandatass->Pengiriman_Unit + $Laporandatass->Bom_Unit))
                ]);
            Laporan::whereDate('laporans.TANGGAL', '>', $Laporandatass->TANGGAL)->where('laporans.KODE', $Laporandatass->KODE)->where('laporans.KODE_BARANG_SAGE', $Laporandatass->KODE_BARANG_SAGE)
                ->update([

                    'laporans.SAwalUnit' => $Laporandatass->SAkhirUnit,
                    'laporans.SAwalQuantity' => $Laporandatass->SAkhirQuantity,
                    'laporans.SAwalPrice' => $Laporandatass->SAkhirPrice
                ]);
        }*/
            $boms1 = Bom::where('KODE_BAHAN', 'like', "%" . 1101 . "%")->get();
            $boms2 = Dprbom::where('KODE_BAHAN', 'like', "%" . 1101 . "%")->get();
            $boms3 = Dprrckbom::where('KODE_BAHAN', 'like', "%" . 1101 . "%")->get();

            return view('boms', compact('boms1', 'boms2', 'boms3'));
        }

        return redirect("/")->withSuccess('Opps! You do not have access');
    }
    public function laporan()
    {
        if (Auth::check()) {
            $laporanakhirview = Laporanakhir::get();
            return view('Laporans', compact('laporanakhirview'));
        }

        return redirect("/")->withSuccess('Opps! You do not have access');
    }

    public function Laporanhpps()
    {
        if (Auth::check()) {
            $penjualanss = Laporanhpp::get();
            return view('Laporanhpps', compact('penjualanss'));
        }

        return redirect("/")->withSuccess('Opps! You do not have access');
    }

    public function laporanpembelian()
    {
        if (Auth::check()) {
            $laporanakhirview = Convertpembelian::get();
            return view('LaporanPembelian', compact('laporanakhirview'));
        }

        return redirect("/")->withSuccess('Opps! You do not have access');
    }
    public function laporanpembeliantanggal(Request $request)
    {
        if (Auth::check()) {
            Convertpembelian::truncate();
            $date = $request->date;

            Laporan::whereDate('TANGGAL', '=', $date)->where('laporans.Pembelian_Unit', '<>', null)
                ->join('items', 'laporans.KODE_BARANG_SAGE', '=', 'items.KODE_BARANG_SAGE')
                ->join('itemakuns', 'laporans.KODE_BARANG_SAGE', '=', 'itemakuns.KODE_BARANG_SAGE')->select(
                    'laporans.TANGGAL',
                    'laporans.KODE_BARANG_SAGE',
                    'laporans.KODE_DESKRIPSI_BARANG_SAGE',
                    'laporans.STOKING_UNIT_BOM',
                    'items.RUMUS_untuk_BOM',
                    'items.BUYING_UNIT_SAGE',
                    'itemakuns.Akun_Pembelian',
                    'itemakuns.Deskripsi_Akun_Pembelian',
                    Laporan::raw('sum(laporans.Pembelian_Unit)as Pemunit'),
                    Laporan::raw('sum(laporans.Pembelian_Price)as Pemprice'),
                )->groupBy('KODE_BARANG_SAGE')
                ->orderBy('laporans.KODE_BARANG_SAGE')
                ->chunk(1000, function ($rows) {
                    foreach ($rows as $user) {
                        Convertpembelian::insert([
                            'TANGGAL' => $user->TANGGAL,
                            'KODE_BARANG_SAGE' => $user->KODE_BARANG_SAGE,
                            'KODE_DESKRIPSI_BARANG_SAGE' => $user->KODE_DESKRIPSI_BARANG_SAGE,
                            'STOKING_UNIT_BOM' => $user->BUYING_UNIT_SAGE,

                            'QUANTITY' => $user->Pemunit * $user->RUMUS_untuk_BOM,
                            'HARGA' => $user->Pemprice / ($user->Pemunit * $user->RUMUS_untuk_BOM),
                            'JUMLAH' => $user->Pemprice,

                            'KODE' => $user->Akun_Pembelian,
                            'NAMA' => $user->Deskripsi_Akun_Pembelian
                        ]);
                    }
                });

            $laporanakhirview = Convertpembelian::get();
            return view('LaporanPembelian', compact('laporanakhirview'));
        }

        return redirect("/")->withSuccess('Opps! You do not have access');
    }
    public function rekappembelian()
    {
        if (Auth::check()) {
            $laporanakhirview = Convertpembelian::get();
            return view('RekapPembelian', compact('laporanakhirview'));
        }

        return redirect("/")->withSuccess('Opps! You do not have access');
    }
    public function rekappembeliantanggal(Request $request)
    {
        if (Auth::check()) {
            Convertpembelian::truncate();
            $date = $request->date;


            Laporan::whereDate('TANGGAL', '=', $date)->where('laporans.Pembelian_Unit', '<>', null)
                ->join('items', 'laporans.KODE_BARANG_SAGE', '=', 'items.KODE_BARANG_SAGE')
                ->join('itemakuns', 'laporans.KODE_BARANG_SAGE', '=', 'itemakuns.KODE_BARANG_SAGE')->select(
                    'laporans.TANGGAL',
                    'items.RUMUS_untuk_BOM',
                    'itemakuns.Akun_Pembelian',
                    'itemakuns.Deskripsi_Akun_Pembelian',
                    Laporan::raw('sum(laporans.Pembelian_Price)as Pemprice'),
                )->groupBy('itemakuns.Akun_Pembelian')
                ->orderBy('itemakuns.Akun_Pembelian')
                ->chunk(1000, function ($rows) {
                    foreach ($rows as $user) {
                        Convertpembelian::insert([
                            'TANGGAL' => $user->TANGGAL,
                            'QUANTITY' => $user->Pemprice,
                            'KODE' => $user->Akun_Pembelian,
                            'NAMA' => $user->Deskripsi_Akun_Pembelian
                        ]);
                    }
                });

            $laporanakhirview = Convertpembelian::get();
            return view('RekapPembelian', compact('laporanakhirview'));
        }

        return redirect("/")->withSuccess('Opps! You do not have access');
    }
    public function laporanbiaya()
    {
        if (Auth::check()) {
            $laporanakhirview = Laporanakhir::get();
            return view('LaporanBiaya', compact('laporanakhirview'));
        }

        return redirect("/")->withSuccess('Opps! You do not have access');
    }
    public function biayalaporantanggal(Request $request)
    {
        if (Auth::check()) {
            Laporanakhir::truncate();
            $date = $request->date;

            Laporan::whereDate('TANGGAL', '=', $date)->where('laporans.Pengiriman_Unit', '<>', null)
                ->join('items', 'laporans.KODE_BARANG_SAGE', '=', 'items.KODE_BARANG_SAGE')
                ->join('itemakuns', 'laporans.KODE_BARANG_SAGE', '=', 'itemakuns.KODE_BARANG_SAGE')->select(
                    'laporans.TANGGAL',
                    'laporans.KODE',
                    'laporans.NAMA',
                    'laporans.KODE_BARANG_SAGE',
                    'laporans.KODE_DESKRIPSI_BARANG_SAGE',
                    'laporans.STOKING_UNIT_BOM',
                    'items.RUMUS_untuk_BOM',
                    'items.BUYING_UNIT_SAGE',
                    'itemakuns.Akun_COGS',
                    'itemakuns.Deskripsi_Akun_COGS',
                    Laporan::raw('sum(laporans.Pengiriman_Unit)as Pemunit'),
                    Laporan::raw('IFNULL(sum(laporans.SAwalPrice), 1) / IFNULL(sum(laporans.SAwalUnit), 1)  as sAunit')

                )->groupBy('laporans.KODE_BARANG_SAGE', 'laporans.KODE')
                ->orderBy('laporans.KODE_BARANG_SAGE')
                ->chunk(1000, function ($rows) {
                    foreach ($rows as $user) {
                        Laporanakhir::insert([
                            'TANGGAL' => $user->TANGGAL,
                            'KODE' => $user->KODE,
                            'NAMA' => $user->NAMA,
                            'Sumber' => "Pengiriman",

                            'KODE_BARANG_SAGE' => $user->KODE_BARANG_SAGE,
                            'KODE_DESKRIPSI_BARANG_SAGE' => $user->KODE_DESKRIPSI_BARANG_SAGE,
                            'STOKING_UNIT_BOM' => $user->BUYING_UNIT_SAGE,

                            'SAwalUnit' => $user->Pemunit * $user->RUMUS_untuk_BOM,
                            'Bom_Price' => $user->RUMUS_untuk_BOM,

                            'SAwalQuantity' => $user->sAunit,
                            'SAwalPrice' => (($user->Pemunit * $user->RUMUS_untuk_BOM) * $user->sAunit),



                            'Pembelian_Unit' => $user->Akun_COGS,
                            'akun' => $user->Deskripsi_Akun_COGS
                        ]);
                    }
                });

            Laporan::where('laporans.SAwalPrice', '<>', null)->select(
                'laporans.KODE_BARANG_SAGE',
                'laporans.KODE',
                'laporans.SAwalUnit',
                'laporans.SAwalPrice'
            )->orderBy('laporans.KODE_BARANG_SAGE', 'asc')
                ->chunk(1000, function ($rows) {
                    foreach ($rows as $UpdateLaporanharians2) {
                        Dprrckbom::where('dprrckboms.KODE_BAHAN', 'LIKE', '%' . $UpdateLaporanharians2->KODE_BARANG_SAGE . '%')
                            ->where('dprrckboms.KODE_BAHAN', 'LIKE', '%' . $UpdateLaporanharians2->KODE . '%')
                            ->join('items', 'dprrckboms.KODE_BAHAN',  'LIKE',  Dprrckbom::raw('CONCAT("%",items.KODE_BARANG_SAGE,"%")'))->groupBy('dprrckboms.KODE_BAHAN')
                            ->update([
                                'dprrckboms.Harga' => Dprrckbom::raw('round(round(dprrckboms.BANYAK,2) * items.RUMUS_untuk_BOM * ' . $UpdateLaporanharians2->SAwalPrice / $UpdateLaporanharians2->SAwalUnit  . ',2) ')

                            ]);
                        Dprbom::where('dprboms.KODE_BAHAN', 'LIKE', '%' . $UpdateLaporanharians2->KODE_BARANG_SAGE . '%')
                            ->where('dprboms.KODE_BAHAN', 'LIKE', '%' . $UpdateLaporanharians2->KODE . '%')
                            ->join('items', 'dprboms.KODE_BAHAN',  'LIKE',  Dprbom::raw('CONCAT("%",items.KODE_BARANG_SAGE,"%")'))
                            ->join('laporanakhirs', 'dprboms.KODE_BAHAN',  'LIKE',  Dprbom::raw('CONCAT("%",laporanakhirs.KODE_BARANG_SAGE,"%")'))->groupBy('dprboms.KODE_BAHAN')
                            ->update([
                                'dprboms.Harga' => Dprbom::raw('round(round(dprboms.BANYAK,2) * items.RUMUS_untuk_BOM * ' . $UpdateLaporanharians2->SAwalPrice / $UpdateLaporanharians2->SAwalUnit  . ',2) ')

                            ]);
                    }
                });

            Laporan::whereDate('laporans.TANGGAL', '<=', $date)->where('laporans.Pembelian_Unit', '<>', null)
                ->select(
                    'laporans.TANGGAL',
                    'laporans.KODE_BARANG_SAGE',
                    'laporans.KODE',
                    'laporans.Pembelian_Price',
                    'laporans.Pembelian_Unit'
                )->groupBy('laporans.KODE_BARANG_SAGE', 'laporans.KODE', 'laporans.TANGGAL')->orderBy('laporans.TANGGAL', 'asc')
                ->chunk(1000, function ($rows) {
                    foreach ($rows as $UpdateLaporanharians2) {
                        Laporanakhir::where('KODE_BARANG_SAGE', $UpdateLaporanharians2->KODE_BARANG_SAGE)
                            ->where('KODE', $UpdateLaporanharians2->KODE)
                            ->update([
                                'SAwalQuantity' => Laporanakhir::raw('round(' . $UpdateLaporanharians2->Pembelian_Price . '/(Bom_Price * ' . $UpdateLaporanharians2->Pembelian_Unit . '),2) '),
                                'SAwalPrice' => Laporanakhir::raw('round((' . $UpdateLaporanharians2->Pembelian_Price . '/(Bom_Price * ' . $UpdateLaporanharians2->Pembelian_Unit . '))*SAwalUnit,2) ')
                            ]);

                        Dprrckbom::where('dprrckboms.KODE_BAHAN', 'LIKE', '%' . $UpdateLaporanharians2->KODE_BARANG_SAGE . '%')
                            ->where('dprrckboms.KODE_BAHAN', 'LIKE', '%' . $UpdateLaporanharians2->KODE . '%')
                            ->join('items', 'dprrckboms.KODE_BAHAN',  'LIKE',  Dprrckbom::raw('CONCAT("%",items.KODE_BARANG_SAGE,"%")'))
                            ->update([
                                'dprrckboms.Harga' => Dprrckbom::raw('round(round(dprrckboms.BANYAK,2) * items.RUMUS_untuk_BOM * (' . $UpdateLaporanharians2->Pembelian_Price . '/(items.RUMUS_untuk_BOM * ' . $UpdateLaporanharians2->Pembelian_Unit . ')),2) ')

                            ]);
                        Dprbom::where('dprboms.KODE_BAHAN', 'LIKE', '%' . $UpdateLaporanharians2->KODE_BARANG_SAGE . '%')
                            ->where('dprboms.KODE_BAHAN', 'LIKE', '%' . $UpdateLaporanharians2->KODE . '%')
                            ->join('items', 'dprboms.KODE_BAHAN',  'LIKE',  Dprbom::raw('CONCAT("%",items.KODE_BARANG_SAGE,"%")'))
                            ->join('laporanakhirs', 'dprboms.KODE_BAHAN',  'LIKE',  Dprbom::raw('CONCAT("%",laporanakhirs.KODE_BARANG_SAGE,"%")'))
                            ->update([
                                'dprboms.Harga' => Dprbom::raw('round(round(dprboms.BANYAK,2) * items.RUMUS_untuk_BOM *  (' . $UpdateLaporanharians2->Pembelian_Price . '/(items.RUMUS_untuk_BOM * ' . $UpdateLaporanharians2->Pembelian_Unit . ')),2) ')
                            ]);
                    }
                });



            Dprrckbom::select(
                'dprrckboms.KODE_BARANG',
                Dprrckbom::raw('RIGHT(dprrckboms.KODE_BARANG, 11) as kode'),
                Dprrckbom::raw('round(sum(dprrckboms.Harga),2) as Harga2')
            )->groupBy('dprrckboms.KODE_BARANG')->orderBy('dprrckboms.KODE_BARANG')->chunk(1000, function ($rows) {
                foreach ($rows as $dprrckbomhargabarangs) {
                    if ($dprrckbomhargabarangs->Harga2 != null) {
                        Dprbom::where(
                            'dprboms.KODE_BAHAN',
                            'LIKE',
                            '%' . $dprrckbomhargabarangs->kode . '%'
                        )->join('items', 'dprboms.KODE_BAHAN',  'LIKE',  Dprrckbom::raw('CONCAT("%",items.KODE_BARANG_SAGE,"%")'))->update([
                            'dprboms.Harga' => Dprbom::raw('round(round(dprboms.BANYAK,2) * items.RUMUS_untuk_BOM *  ' . $dprrckbomhargabarangs->Harga2 . ',2) ')
                        ]);
                        Laporanakhir::where('KODE_BARANG_SAGE', $dprrckbomhargabarangs->kode)
                            ->update([
                                'SAwalQuantity' => $dprrckbomhargabarangs->Harga2,
                                'SAwalPrice' => Laporanakhir::raw('round(' . $dprrckbomhargabarangs->Harga2 . ' * SAwalUnit,2) ')
                            ]);
                    }
                }
            });

            Dprbom::join('laporanakhirs', 'dprboms.KODE_BAHAN',  'LIKE',  Dprbom::raw('CONCAT("%",laporanakhirs.KODE_BARANG_SAGE,"%")'))->select(
                'dprboms.KODE_BARANG',
                Dprbom::raw('RIGHT(dprboms.KODE_BARANG, 11) as kode'),
                Dprbom::raw('LEFT(dprboms.KODE_BARANG, 4) as kode2'),
                Dprbom::raw('round(sum(dprboms.Harga),2) as Harga2')
            )->groupBy(
                'dprboms.KODE_BARANG'
            )->orderBy('dprboms.KODE_BARANG')->chunk(1000, function ($rows) {
                foreach ($rows as $dprrckbomhargabarangs) {
                    if ($dprrckbomhargabarangs->Harga2 != null) {
                        Laporanakhir::where('KODE_BARANG_SAGE', $dprrckbomhargabarangs->kode)
                            ->where('KODE', $dprrckbomhargabarangs->kode2)
                            ->update([
                                'SAwalQuantity' => $dprrckbomhargabarangs->Harga2,
                                'SAwalPrice' => Laporanakhir::raw('round(' . $dprrckbomhargabarangs->Harga2 . ' * SAwalUnit,2) ')
                            ]);
                    }
                }
            });


            Laporan::whereDate('TANGGAL', '=', $date)->where('laporans.Pembelian_Unit', '<>', null)
                ->join('items', 'laporans.KODE_BARANG_SAGE', '=', 'items.KODE_BARANG_SAGE')
                ->join('itemakuns', 'laporans.KODE_BARANG_SAGE', '=', 'itemakuns.KODE_BARANG_SAGE')->select(
                    'laporans.TANGGAL',
                    'laporans.KODE',
                    'laporans.NAMA',
                    'laporans.KODE_BARANG_SAGE',
                    'laporans.KODE_DESKRIPSI_BARANG_SAGE',
                    'laporans.STOKING_UNIT_BOM',
                    'items.RUMUS_untuk_BOM',
                    'items.BUYING_UNIT_SAGE',
                    'itemakuns.Akun_COGS',
                    'itemakuns.Deskripsi_Akun_COGS',
                    Laporan::raw('sum(laporans.Pembelian_Unit)as Pemunit'),
                    Laporan::raw('sum(laporans.Pembelian_Price)as Pemprice'),
                )->groupBy('laporans.KODE_BARANG_SAGE', 'laporans.KODE')
                ->orderBy('laporans.KODE_BARANG_SAGE')
                ->chunk(1000, function ($rows) {
                    foreach ($rows as $user) {
                        Laporanakhir::insert([
                            'TANGGAL' => $user->TANGGAL,
                            'KODE' => $user->KODE,
                            'NAMA' => $user->NAMA,
                            'Sumber' => "Pembelian",

                            'KODE_BARANG_SAGE' => $user->KODE_BARANG_SAGE,
                            'KODE_DESKRIPSI_BARANG_SAGE' => $user->KODE_DESKRIPSI_BARANG_SAGE,
                            'STOKING_UNIT_BOM' => $user->BUYING_UNIT_SAGE,

                            'SAwalUnit' => $user->Pemunit * $user->RUMUS_untuk_BOM,
                            'SAwalQuantity' => $user->Pemprice / ($user->Pemunit * $user->RUMUS_untuk_BOM),
                            'SAwalPrice' => $user->Pemprice,

                            'Pembelian_Unit' => $user->Akun_COGS,
                            'akun' => $user->Deskripsi_Akun_COGS
                        ]);
                    }
                });



            $laporanakhirview = Laporanakhir::get();
            return view('LaporanBiaya', compact('laporanakhirview'));
        }

        return redirect("/")->withSuccess('Opps! You do not have access');
    }
    public function rekapbiaya()
    {
        if (Auth::check()) {
            $laporanakhirview = Rekapbiaya::get();
            return view('RekapBiaya', compact('laporanakhirview'));
        }

        return redirect("/")->withSuccess('Opps! You do not have access');
    }
    public function rekapBiayatanggal(Request $request)
    {
        if (Auth::check()) {
            Rekapbiaya::truncate();
            $date = $request->date;

            Laporan::whereDate('TANGGAL', '=', $date)->where('laporans.Pengiriman_Unit', '<>', null)
                ->join('items', 'laporans.KODE_BARANG_SAGE', '=', 'items.KODE_BARANG_SAGE')
                ->join('itemakuns', 'laporans.KODE_BARANG_SAGE', '=', 'itemakuns.KODE_BARANG_SAGE')->select(
                    'laporans.TANGGAL',
                    'laporans.KODE',
                    'laporans.NAMA',
                    'laporans.KODE_BARANG_SAGE',
                    'laporans.KODE_DESKRIPSI_BARANG_SAGE',
                    'laporans.STOKING_UNIT_BOM',
                    'items.RUMUS_untuk_BOM',
                    'items.BUYING_UNIT_SAGE',
                    'itemakuns.Akun_COGS',
                    'itemakuns.Deskripsi_Akun_COGS',
                    Laporan::raw('sum(laporans.Pengiriman_Unit)as Pemunit'),
                    Laporan::raw('IFNULL(sum(laporans.SAwalPrice), 1) / IFNULL(sum(laporans.SAwalUnit), 1)  as sAunit')

                )->groupBy('laporans.KODE_BARANG_SAGE', 'laporans.KODE')
                ->orderBy('laporans.KODE_BARANG_SAGE')
                ->chunk(1000, function ($rows) {
                    foreach ($rows as $user) {
                        Laporanakhir::insert([
                            'TANGGAL' => $user->TANGGAL,
                            'KODE' => $user->KODE,
                            'NAMA' => $user->NAMA,
                            'Sumber' => "Pengiriman",

                            'KODE_BARANG_SAGE' => $user->KODE_BARANG_SAGE,
                            'KODE_DESKRIPSI_BARANG_SAGE' => $user->KODE_DESKRIPSI_BARANG_SAGE,
                            'STOKING_UNIT_BOM' => $user->BUYING_UNIT_SAGE,

                            'SAwalUnit' => $user->Pemunit * $user->RUMUS_untuk_BOM,
                            'Bom_Price' => $user->RUMUS_untuk_BOM,

                            'SAwalQuantity' => $user->sAunit,
                            'SAwalPrice' => (($user->Pemunit * $user->RUMUS_untuk_BOM) * $user->sAunit),



                            'Pembelian_Unit' => $user->Akun_COGS,
                            'akun' => $user->Deskripsi_Akun_COGS
                        ]);
                    }
                });

            Laporan::where('laporans.SAwalPrice', '<>', null)->select(
                'laporans.KODE_BARANG_SAGE',
                'laporans.KODE',
                'laporans.SAwalUnit',
                'laporans.SAwalPrice'
            )->orderBy('laporans.KODE_BARANG_SAGE', 'asc')
                ->chunk(1000, function ($rows) {
                    foreach ($rows as $UpdateLaporanharians2) {
                        Dprrckbom::where('dprrckboms.KODE_BAHAN', 'LIKE', '%' . $UpdateLaporanharians2->KODE_BARANG_SAGE . '%')
                            ->where('dprrckboms.KODE_BAHAN', 'LIKE', '%' . $UpdateLaporanharians2->KODE . '%')
                            ->join('items', 'dprrckboms.KODE_BAHAN',  'LIKE',  Dprrckbom::raw('CONCAT("%",items.KODE_BARANG_SAGE,"%")'))->groupBy('dprrckboms.KODE_BAHAN')
                            ->update([
                                'dprrckboms.Harga' => Dprrckbom::raw('round(round(dprrckboms.BANYAK,2) * items.RUMUS_untuk_BOM * ' . $UpdateLaporanharians2->SAwalPrice / $UpdateLaporanharians2->SAwalUnit  . ',2) ')

                            ]);
                        Dprbom::where('dprboms.KODE_BAHAN', 'LIKE', '%' . $UpdateLaporanharians2->KODE_BARANG_SAGE . '%')
                            ->where('dprboms.KODE_BAHAN', 'LIKE', '%' . $UpdateLaporanharians2->KODE . '%')
                            ->join('items', 'dprboms.KODE_BAHAN',  'LIKE',  Dprbom::raw('CONCAT("%",items.KODE_BARANG_SAGE,"%")'))
                            ->join('laporanakhirs', 'dprboms.KODE_BAHAN',  'LIKE',  Dprbom::raw('CONCAT("%",laporanakhirs.KODE_BARANG_SAGE,"%")'))->groupBy('dprboms.KODE_BAHAN')
                            ->update([
                                'dprboms.Harga' => Dprbom::raw('round(round(dprboms.BANYAK,2) * items.RUMUS_untuk_BOM * ' . $UpdateLaporanharians2->SAwalPrice / $UpdateLaporanharians2->SAwalUnit  . ',2) ')

                            ]);
                    }
                });

            Laporan::whereDate('laporans.TANGGAL', '<=', $date)->where('laporans.Pembelian_Unit', '<>', null)
                ->select(
                    'laporans.TANGGAL',
                    'laporans.KODE_BARANG_SAGE',
                    'laporans.KODE',
                    'laporans.Pembelian_Price',
                    'laporans.Pembelian_Unit'
                )->groupBy('laporans.KODE_BARANG_SAGE', 'laporans.KODE', 'laporans.TANGGAL')->orderBy('laporans.TANGGAL', 'asc')
                ->chunk(1000, function ($rows) {
                    foreach ($rows as $UpdateLaporanharians2) {
                        Laporanakhir::where('KODE_BARANG_SAGE', $UpdateLaporanharians2->KODE_BARANG_SAGE)
                            ->where('KODE', $UpdateLaporanharians2->KODE)
                            ->update([
                                'SAwalQuantity' => Laporanakhir::raw('round(' . $UpdateLaporanharians2->Pembelian_Price . '/(Bom_Price * ' . $UpdateLaporanharians2->Pembelian_Unit . '),2) '),
                                'SAwalPrice' => Laporanakhir::raw('round((' . $UpdateLaporanharians2->Pembelian_Price . '/(Bom_Price * ' . $UpdateLaporanharians2->Pembelian_Unit . '))*SAwalUnit,2) ')
                            ]);

                        Dprrckbom::where('dprrckboms.KODE_BAHAN', 'LIKE', '%' . $UpdateLaporanharians2->KODE_BARANG_SAGE . '%')
                            ->where('dprrckboms.KODE_BAHAN', 'LIKE', '%' . $UpdateLaporanharians2->KODE . '%')
                            ->join('items', 'dprrckboms.KODE_BAHAN',  'LIKE',  Dprrckbom::raw('CONCAT("%",items.KODE_BARANG_SAGE,"%")'))
                            ->update([
                                'dprrckboms.Harga' => Dprrckbom::raw('round(round(dprrckboms.BANYAK,2) * items.RUMUS_untuk_BOM * (' . $UpdateLaporanharians2->Pembelian_Price . '/(items.RUMUS_untuk_BOM * ' . $UpdateLaporanharians2->Pembelian_Unit . ')),2) ')

                            ]);
                        Dprbom::where('dprboms.KODE_BAHAN', 'LIKE', '%' . $UpdateLaporanharians2->KODE_BARANG_SAGE . '%')
                            ->where('dprboms.KODE_BAHAN', 'LIKE', '%' . $UpdateLaporanharians2->KODE . '%')
                            ->join('items', 'dprboms.KODE_BAHAN',  'LIKE',  Dprbom::raw('CONCAT("%",items.KODE_BARANG_SAGE,"%")'))
                            ->join('laporanakhirs', 'dprboms.KODE_BAHAN',  'LIKE',  Dprbom::raw('CONCAT("%",laporanakhirs.KODE_BARANG_SAGE,"%")'))
                            ->update([
                                'dprboms.Harga' => Dprbom::raw('round(round(dprboms.BANYAK,2) * items.RUMUS_untuk_BOM *  (' . $UpdateLaporanharians2->Pembelian_Price . '/(items.RUMUS_untuk_BOM * ' . $UpdateLaporanharians2->Pembelian_Unit . ')),2) ')
                            ]);
                    }
                });



            Dprrckbom::select(
                'dprrckboms.KODE_BARANG',
                Dprrckbom::raw('RIGHT(dprrckboms.KODE_BARANG, 11) as kode'),
                Dprrckbom::raw('round(sum(dprrckboms.Harga),2) as Harga2')
            )->groupBy('dprrckboms.KODE_BARANG')->orderBy('dprrckboms.KODE_BARANG')->chunk(1000, function ($rows) {
                foreach ($rows as $dprrckbomhargabarangs) {
                    if ($dprrckbomhargabarangs->Harga2 != null) {
                        Dprbom::where(
                            'dprboms.KODE_BAHAN',
                            'LIKE',
                            '%' . $dprrckbomhargabarangs->kode . '%'
                        )->join('items', 'dprboms.KODE_BAHAN',  'LIKE',  Dprrckbom::raw('CONCAT("%",items.KODE_BARANG_SAGE,"%")'))->update([
                            'dprboms.Harga' => Dprbom::raw('round(round(dprboms.BANYAK,2) * items.RUMUS_untuk_BOM *  ' . $dprrckbomhargabarangs->Harga2 . ',2) ')
                        ]);
                        Laporanakhir::where('KODE_BARANG_SAGE', $dprrckbomhargabarangs->kode)
                            ->update([
                                'SAwalQuantity' => $dprrckbomhargabarangs->Harga2,
                                'SAwalPrice' => Laporanakhir::raw('round(' . $dprrckbomhargabarangs->Harga2 . ' * SAwalUnit,2) ')
                            ]);
                    }
                }
            });

            Dprbom::join('laporanakhirs', 'dprboms.KODE_BAHAN',  'LIKE',  Dprbom::raw('CONCAT("%",laporanakhirs.KODE_BARANG_SAGE,"%")'))->select(
                'dprboms.KODE_BARANG',
                Dprbom::raw('RIGHT(dprboms.KODE_BARANG, 11) as kode'),
                Dprbom::raw('LEFT(dprboms.KODE_BARANG, 4) as kode2'),
                Dprbom::raw('round(sum(dprboms.Harga),2) as Harga2')
            )->groupBy(
                'dprboms.KODE_BARANG'
            )->orderBy('dprboms.KODE_BARANG')->chunk(1000, function ($rows) {
                foreach ($rows as $dprrckbomhargabarangs) {
                    if ($dprrckbomhargabarangs->Harga2 != null) {
                        Laporanakhir::where('KODE_BARANG_SAGE', $dprrckbomhargabarangs->kode)
                            ->where('KODE', $dprrckbomhargabarangs->kode2)
                            ->update([
                                'SAwalQuantity' => $dprrckbomhargabarangs->Harga2,
                                'SAwalPrice' => Laporanakhir::raw('round(' . $dprrckbomhargabarangs->Harga2 . ' * SAwalUnit,2) ')
                            ]);
                    }
                }
            });


            Laporan::whereDate('TANGGAL', '=', $date)->where('laporans.Pembelian_Unit', '<>', null)
                ->join('items', 'laporans.KODE_BARANG_SAGE', '=', 'items.KODE_BARANG_SAGE')
                ->join('itemakuns', 'laporans.KODE_BARANG_SAGE', '=', 'itemakuns.KODE_BARANG_SAGE')->select(
                    'laporans.TANGGAL',
                    'laporans.KODE',
                    'laporans.NAMA',
                    'laporans.KODE_BARANG_SAGE',
                    'laporans.KODE_DESKRIPSI_BARANG_SAGE',
                    'laporans.STOKING_UNIT_BOM',
                    'items.RUMUS_untuk_BOM',
                    'items.BUYING_UNIT_SAGE',
                    'itemakuns.Akun_COGS',
                    'itemakuns.Deskripsi_Akun_COGS',
                    Laporan::raw('sum(laporans.Pembelian_Unit)as Pemunit'),
                    Laporan::raw('sum(laporans.Pembelian_Price)as Pemprice'),
                )->groupBy('laporans.KODE_BARANG_SAGE', 'laporans.KODE')
                ->orderBy('laporans.KODE_BARANG_SAGE')
                ->chunk(1000, function ($rows) {
                    foreach ($rows as $user) {
                        Laporanakhir::insert([
                            'TANGGAL' => $user->TANGGAL,
                            'KODE' => $user->KODE,
                            'NAMA' => $user->NAMA,
                            'Sumber' => "Pembelian",

                            'KODE_BARANG_SAGE' => $user->KODE_BARANG_SAGE,
                            'KODE_DESKRIPSI_BARANG_SAGE' => $user->KODE_DESKRIPSI_BARANG_SAGE,
                            'STOKING_UNIT_BOM' => $user->BUYING_UNIT_SAGE,

                            'SAwalUnit' => $user->Pemunit * $user->RUMUS_untuk_BOM,
                            'SAwalQuantity' => $user->Pemprice / ($user->Pemunit * $user->RUMUS_untuk_BOM),
                            'SAwalPrice' => $user->Pemprice,

                            'Pembelian_Unit' => $user->Akun_COGS,
                            'akun' => $user->Deskripsi_Akun_COGS
                        ]);
                    }
                });

            Laporanakhir::select(
                'laporanakhirs.TANGGAL',
                'laporanakhirs.KODE',
                'laporanakhirs.NAMA',
                'laporanakhirs.Pembelian_Unit',
                'laporanakhirs.akun',
                Laporanakhir::raw('sum(SAwalPrice)as Pemunit')
            )->groupBy('laporanakhirs.KODE', 'laporanakhirs.akun')->orderBy('laporanakhirs.KODE')
                ->chunk(1000, function ($rows) {
                    foreach ($rows as $user) {
                        Rekapbiaya::insert([
                            'TANGGAL' => $user->TANGGAL,
                            'KODE' => $user->KODE,
                            'NAMA' => $user->NAMA,
                            'SAwalPrice' => $user->Pemunit,

                            'Pembelian_Unit' => $user->Pembelian_Unit,
                            'akun' => $user->akun
                        ]);
                    }
                });


            $laporanakhirview = Rekapbiaya::get();
            return view('RekapBiaya', compact('laporanakhirview'));
        }

        return redirect("/")->withSuccess('Opps! You do not have access');
    }

    public function rekapcogs()
    {
        if (Auth::check()) {
            $laporanakhirview = Rekapcog::get();
            return view('RekapCogs', compact('laporanakhirview'));
        }

        return redirect("/")->withSuccess('Opps! You do not have access');
    }
    public function rekapcogstanggal(Request $request)
    {
        if (Auth::check()) {

            Rekapcog::truncate();
            Convertbom::truncate();
            Laporanhpp::truncate();

            $Tanggal = $request->date;

            $Boms23 =  Penjualan::whereDate('TANGGAL', '=', $Tanggal)->select(
                'penjualans.TANGGAL',
                'penjualans.KODE_OUTLET',
                'penjualans.Outlet',
                'penjualans.KODE_BARANG',
                'penjualans.Barang',
                'penjualans.Banyak',
                'penjualans.Jumlah'
            )->get();

            $datalaporanpenjualan = [];
            foreach ($Boms23 as $Boms23s) {
                if ($Boms23s->Banyak != 0) {
                    $datalaporanpenjualan[] = [
                        'TANGGAL' => $Boms23s->TANGGAL,
                        'KODE_OUTLET' => $Boms23s->KODE_OUTLET,
                        'Outlet' => $Boms23s->Outlet,
                        'KODE_BARANG' => $Boms23s->KODE_BARANG,
                        'Barang' => $Boms23s->Barang,
                        'Banyak' => $Boms23s->Banyak,
                        'Jumlah' => $Boms23s->Jumlah,
                        'Revenue' => $Boms23s->Jumlah / 1.1
                    ];
                }
            }
            foreach (array_chunk($datalaporanpenjualan, 1000) as $t) {
                Laporanhpp::insert($t);
            }

            Laporan::join(
                'dprrckboms',
                function ($join) {
                    $join->on(
                        Laporan::raw('RIGHT(dprrckboms.KODE_BAHAN, 11)'),
                        '=',
                        'laporans.KODE_BARANG_SAGE'
                    )->on(
                        Laporan::raw('LEFT(dprrckboms.KODE_BAHAN, 4)'),
                        '=',
                        'laporans.KODE'
                    );
                }
            )->where('laporans.SAwalPrice', '<>', null)->select(
                'laporans.KODE_BARANG_SAGE',
                'laporans.KODE',
                'laporans.SAwalUnit',
                'laporans.SAwalPrice'
            )->orderBy('laporans.KODE_BARANG_SAGE', 'asc')
                ->chunk(1000, function ($rows) {
                    foreach ($rows as $UpdateLaporanharians2) {
                        Dprrckbom::where('dprrckboms.KODE_BAHAN', 'LIKE', '%' . $UpdateLaporanharians2->KODE_BARANG_SAGE . '%')
                            ->where('dprrckboms.KODE_BAHAN', 'LIKE', '%' . $UpdateLaporanharians2->KODE . '%')
                            ->join('items', 'dprrckboms.KODE_BAHAN',  'LIKE',  Dprrckbom::raw('CONCAT("%",items.KODE_BARANG_SAGE,"%")'))->groupBy('dprrckboms.KODE_BAHAN')
                            ->update([
                                'dprrckboms.Harga' => Dprrckbom::raw('round(round(dprrckboms.BANYAK,2) * (' . $UpdateLaporanharians2->SAwalPrice  . '/ (' . $UpdateLaporanharians2->SAwalUnit  . ' / items.RUMUS_untuk_BOM)),2) ')
                            ]);
                    }
                });

            Laporan::join(
                'dprboms',
                function ($join) {
                    $join->on(
                        Laporan::raw('RIGHT(dprboms.KODE_BAHAN, 11)'),
                        '=',
                        'laporans.KODE_BARANG_SAGE'
                    )->on(
                        Laporan::raw('LEFT(dprboms.KODE_BAHAN, 4)'),
                        '=',
                        'laporans.KODE'
                    );
                }
            )->where('laporans.SAwalPrice', '<>', null)->select(
                'laporans.KODE_BARANG_SAGE',
                'laporans.KODE',
                'laporans.SAwalUnit',
                'laporans.SAwalPrice'
            )->orderBy('laporans.KODE_BARANG_SAGE', 'asc')
                ->chunk(1000, function ($rows) {
                    foreach ($rows as $UpdateLaporanharians2) {
                        Dprbom::where('dprboms.KODE_BAHAN', 'LIKE', '%' . $UpdateLaporanharians2->KODE_BARANG_SAGE . '%')
                            ->where('dprboms.KODE_BAHAN', 'LIKE', '%' . $UpdateLaporanharians2->KODE . '%')
                            ->join('items', 'dprboms.KODE_BAHAN',  'LIKE',  Dprbom::raw('CONCAT("%",items.KODE_BARANG_SAGE,"%")'))
                            ->update([
                                'dprboms.Harga' => Dprbom::raw('round(round(dprboms.BANYAK,2) * (' . $UpdateLaporanharians2->SAwalPrice  . '/ (' . $UpdateLaporanharians2->SAwalUnit  . ' / items.RUMUS_untuk_BOM)),2) ')
                            ]);
                    }
                });

            Laporan::join(
                'boms',
                function ($join) {
                    $join->on(
                        Laporan::raw('RIGHT(boms.KODE_BAHAN, 11)'),
                        '=',
                        'laporans.KODE_BARANG_SAGE'
                    )->on(
                        Laporan::raw('LEFT(boms.KODE_BAHAN, 4)'),
                        '=',
                        'laporans.KODE'
                    );
                }
            )->join(
                'laporanhpps',
                function ($join) {
                    $join->on(
                        'boms.KODE_BARANG',
                        'LIKE',
                        Bom::raw('CONCAT("%",laporanhpps.KODE_BARANG,"%")')
                    )->on(
                        'boms.KODE_BARANG',
                        'LIKE',
                        Bom::raw('CONCAT("%",laporanhpps.KODE_OUTLET,"%")')
                    );
                }
            )->where('laporans.SAwalPrice', '<>', null)->select(
                'laporans.KODE_BARANG_SAGE',
                'laporans.KODE',
                'laporans.SAwalUnit',
                'laporans.SAwalPrice'
            )->orderBy('laporans.KODE_BARANG_SAGE', 'asc')
                ->chunk(1000, function ($rows) {
                    foreach ($rows as $UpdateLaporanharians2) {
                        Bom::where('boms.KODE_BAHAN', 'LIKE', '%' . $UpdateLaporanharians2->KODE_BARANG_SAGE . '%')
                            ->where('boms.KODE_BAHAN', 'LIKE', '%' . $UpdateLaporanharians2->KODE . '%')
                            ->join('items', 'boms.KODE_BAHAN',  'LIKE',  Bom::raw('CONCAT("%",items.KODE_BARANG_SAGE,"%")'))
                            ->update([
                                'boms.Harga' => Dprbom::raw('round(round(boms.BANYAK,2) * (' . $UpdateLaporanharians2->SAwalPrice  . '/ (' . $UpdateLaporanharians2->SAwalUnit  . ' / items.RUMUS_untuk_BOM)),2) ')
                            ]);
                    }
                });

            Laporan::whereDate('laporans.TANGGAL', '<=', $Tanggal)->where('laporans.Pembelian_Unit', '<>', null)
                ->join(
                    'dprrckboms',
                    function ($join) {
                        $join->on(
                            Laporan::raw('RIGHT(dprrckboms.KODE_BAHAN, 11)'),
                            '=',
                            'laporans.KODE_BARANG_SAGE'
                        )->on(
                            Laporan::raw('LEFT(dprrckboms.KODE_BAHAN, 4)'),
                            '=',
                            'laporans.KODE'
                        );
                    }
                )->select(
                    'laporans.TANGGAL',
                    'laporans.KODE_BARANG_SAGE',
                    'laporans.KODE',
                    'laporans.Pembelian_Quantity'
                )->groupBy('laporans.KODE_BARANG_SAGE', 'laporans.KODE', 'laporans.TANGGAL')->orderBy('laporans.TANGGAL', 'asc')
                ->chunk(1000, function ($rows) {
                    foreach ($rows as $UpdateLaporanharians2) {
                        Dprrckbom::where('dprrckboms.KODE_BAHAN', 'LIKE', '%' . $UpdateLaporanharians2->KODE_BARANG_SAGE . '%')
                            ->where('dprrckboms.KODE_BAHAN', 'LIKE', '%' . $UpdateLaporanharians2->KODE . '%')
                            ->update([
                                'dprrckboms.Harga' => Dprrckbom::raw('round(round(dprrckboms.BANYAK,2) * ' . $UpdateLaporanharians2->Pembelian_Quantity . ',2) ')

                            ]);
                    }
                });

            Laporan::whereDate('laporans.TANGGAL', '<=', $Tanggal)->where('laporans.Pembelian_Unit', '<>', null)->join(
                'dprboms',
                function ($join) {
                    $join->on(
                        Laporan::raw('RIGHT(dprboms.KODE_BAHAN, 11)'),
                        '=',
                        'laporans.KODE_BARANG_SAGE'
                    )->on(
                        Laporan::raw('LEFT(dprboms.KODE_BAHAN, 4)'),
                        '=',
                        'laporans.KODE'
                    );
                }
            )->select(
                'laporans.TANGGAL',
                'laporans.KODE_BARANG_SAGE',
                'laporans.KODE',
                'laporans.Pembelian_Quantity'

            )->groupBy('laporans.KODE_BARANG_SAGE', 'laporans.KODE', 'laporans.TANGGAL')->orderBy('laporans.TANGGAL', 'asc')
                ->chunk(1000, function ($rows) {
                    foreach ($rows as $UpdateLaporanharians2) {

                        Dprbom::where('dprboms.KODE_BAHAN', 'LIKE', '%' . $UpdateLaporanharians2->KODE_BARANG_SAGE . '%')
                            ->where('dprboms.KODE_BAHAN', 'LIKE', '%' . $UpdateLaporanharians2->KODE . '%')
                            ->update([
                                'dprboms.Harga' => Dprbom::raw('round(round(dprboms.BANYAK,2) *' . $UpdateLaporanharians2->Pembelian_Quantity . ',2) ')
                            ]);
                    }
                });
            Laporan::whereDate('laporans.TANGGAL', '<=', $Tanggal)->where('laporans.Pembelian_Unit', '<>', null)->join(
                'boms',
                function ($join) {
                    $join->on(
                        Laporan::raw('RIGHT(boms.KODE_BAHAN, 11)'),
                        '=',
                        'laporans.KODE_BARANG_SAGE'
                    )->on(
                        Laporan::raw('LEFT(boms.KODE_BAHAN, 4)'),
                        '=',
                        'laporans.KODE'
                    );
                }
            )->join(
                'laporanhpps',
                function ($join) {
                    $join->on(
                        'boms.KODE_BARANG',
                        'LIKE',
                        Bom::raw('CONCAT("%",laporanhpps.KODE_BARANG,"%")')
                    )->on(
                        'boms.KODE_BARANG',
                        'LIKE',
                        Bom::raw('CONCAT("%",laporanhpps.KODE_OUTLET,"%")')
                    );
                }
            )->select(
                'laporans.TANGGAL',
                'laporans.KODE_BARANG_SAGE',
                'laporans.KODE',
                'laporans.Pembelian_Quantity'

            )->groupBy('laporans.KODE_BARANG_SAGE', 'laporans.KODE', 'laporans.TANGGAL')->orderBy('laporans.TANGGAL', 'asc')
                ->chunk(1000, function ($rows) {
                    foreach ($rows as $UpdateLaporanharians2) {
                        Bom::join(
                            'convertpenerimaans',
                            function ($join) {
                                $join->on(
                                    'boms.KODE_BAHAN',
                                    'LIKE',
                                    Bom::raw('CONCAT("%",convertpenerimaans.KODE_BARANG_SAGE,"%")')
                                )->on(
                                    'boms.KODE_BAHAN',
                                    'LIKE',
                                    Bom::raw('CONCAT("%",convertpenerimaans.PENERIMA,"%")')
                                );
                            }
                        )->where('boms.KODE_BAHAN', 'LIKE', '%' . $UpdateLaporanharians2->KODE_BARANG_SAGE . '%')
                            ->where('convertpenerimaans.DARI', $UpdateLaporanharians2->KODE)
                            ->update([
                                'boms.Harga' => Bom::raw('round(round(boms.BANYAK,2) * ' . $UpdateLaporanharians2->Pembelian_Quantity . ',2) ')
                            ]);
                    }
                });

            /*memasukan nilai harga pada bahan jadi bom dapur racik dari penjunmlahan bahan baku dapur racik */
            Dprrckbom::select(
                'dprrckboms.KODE_BARANG',
                Dprrckbom::raw('RIGHT(dprrckboms.KODE_BARANG, 11) as kode'),
                Dprrckbom::raw('round(sum(dprrckboms.Harga),2) as Harga2')
            )->groupBy('dprrckboms.KODE_BARANG')->orderBy('dprrckboms.KODE_BARANG')
                ->chunk(1000, function ($rows) {
                    foreach ($rows as $dprrckbomhargabarangs) {
                        if ($dprrckbomhargabarangs->Harga2 != null) {
                            Dprbom::where('dprboms.KODE_BAHAN', 'LIKE', '%' . $dprrckbomhargabarangs->kode . '%')
                                ->update([
                                    'dprboms.Harga' => Dprbom::raw('round(round(dprboms.BANYAK,2) * ' . $dprrckbomhargabarangs->Harga2 . ',2) ')
                                ]);
                            Bom::where('boms.KODE_BAHAN', 'LIKE', '%' . $dprrckbomhargabarangs->kode . '%')->join(
                                'laporanhpps',
                                function ($join) {
                                    $join->on(
                                        'boms.KODE_BARANG',
                                        'LIKE',
                                        Bom::raw('CONCAT("%",laporanhpps.KODE_BARANG,"%")')
                                    )->on(
                                        'boms.KODE_BARANG',
                                        'LIKE',
                                        Bom::raw('CONCAT("%",laporanhpps.KODE_OUTLET,"%")')
                                    );
                                }
                            )->update([
                                'boms.Harga' => Bom::raw('round(round(boms.BANYAK,2) * ' . $dprrckbomhargabarangs->Harga2 . ',2) ')
                            ]);
                        }
                    }
                });




            Dprbom::select(
                'dprboms.KODE_BARANG',
                Dprbom::raw('RIGHT(dprboms.KODE_BARANG, 11) as kode'),
                Dprbom::raw('LEFT(dprboms.KODE_BARANG, 4) as kode2'),
                Dprbom::raw('round(sum(dprboms.Harga),2) as Harga2')
            )->groupBy('dprboms.KODE_BARANG')->orderBy('dprboms.KODE_BARANG')
                ->chunk(1000, function ($rows) {
                    foreach ($rows as $dprbomhargabarangs) {
                        if ($dprbomhargabarangs->Harga2 != null) {
                            Bom::where('boms.KODE_BAHAN', 'LIKE', '%' . $dprbomhargabarangs->kode . '%')
                                ->join(
                                    'laporanhpps',
                                    function ($join) {
                                        $join->on(
                                            'boms.KODE_BARANG',
                                            'LIKE',
                                            Bom::raw('CONCAT("%",laporanhpps.KODE_BARANG,"%")')
                                        )->on(
                                            'boms.KODE_BARANG',
                                            'LIKE',
                                            Bom::raw('CONCAT("%",laporanhpps.KODE_OUTLET,"%")')
                                        );
                                    }
                                )->join(
                                    'convertpenerimaans',
                                    function ($join) {
                                        $join->on(
                                            'boms.KODE_BARANG',
                                            'LIKE',
                                            Bom::raw('CONCAT("%",convertpenerimaans.KODE_BARANG_SAGE,"%")')
                                        )->on(
                                            'boms.KODE_BARANG',
                                            'LIKE',
                                            Bom::raw('CONCAT("%",convertpenerimaans.PENERIMA,"%")')
                                        );
                                    }
                                )->where('convertpenerimaans.DARI',  $dprbomhargabarangs->kode2)->orderBy('convertpenerimaans.TANGGAL', 'asc')->update([
                                    'boms.Harga' => Bom::raw('round(round(boms.BANYAK,2) * ' . $dprbomhargabarangs->Harga2 . ',2) ')
                                ]);
                        }
                    }
                });

            /*memasukan nilai harga pada bahan jadi bom dapur pusat dari penjunmlahan bahan baku dapur pusat */


            Bom::select(
                'boms.KODE_BARANG',
                Bom::raw('round(sum(boms.Harga),2) as Harga2'),
                Bom::raw('RIGHT(boms.KODE_BARANG, 13) as koode'),
                Bom::raw('LEFT(boms.KODE_BARANG, 4) as koode2')

            )->groupBy('boms.KODE_BARANG')->join(
                'laporanhpps',
                function ($join) {
                    $join->on(
                        'boms.KODE_BARANG',
                        'LIKE',
                        Bom::raw('CONCAT("%",laporanhpps.KODE_BARANG,"%")')
                    )->on(
                        'boms.KODE_BARANG',
                        'LIKE',
                        Bom::raw('CONCAT("%",laporanhpps.KODE_OUTLET,"%")')
                    );
                }
            )->orderBy('boms.KODE_BARANG')
                ->chunk(1000, function ($rows) {
                    foreach ($rows as $bomhargas123) {
                        if ($bomhargas123->Harga2 != null) {
                            Laporanhpp::where('KODE_BARANG',  $bomhargas123->koode)
                                ->where('KODE_OUTLET',  $bomhargas123->koode2)
                                ->update([
                                    'COGS' => Laporanhpp::raw('round(laporanhpps.Banyak * ' . $bomhargas123->Harga2 . ',2) ')
                                ]);
                        }
                    }
                });

            /*memasukan nilai harga pada bahan jadi bom dapur pusat dari penjunmlahan bahan baku dapur pusat */


            Laporanhpp::select(
                'laporanhpps.KODE_BARANG',
                'laporanhpps.Banyak',
                'laporanhpps.Jumlah',
                'laporanhpps.Revenue',
                'laporanhpps.COGS',
            )->orderBy('laporanhpps.KODE_BARANG')
                ->chunk(1000, function ($rows) {
                    foreach ($rows as $Bomslaporanhpps) {
                        Laporanhpp::where('KODE_BARANG', $Bomslaporanhpps->KODE_BARANG)->update([
                            'Profit' => Laporanhpp::raw('round(laporanhpps.Revenue,2) - round(laporanhpps.COGS,2)'),
                            'Margin' => Laporanhpp::raw(' round(((round(laporanhpps.Revenue,2) - round(laporanhpps.COGS,2)) / round(laporanhpps.Revenue,2)) * 100,2)'),
                            'Revenue' => Laporanhpp::raw('round(laporanhpps.Revenue,2)')
                        ]);
                    }
                });


            Laporanhpp::select(
                'laporanhpps.TANGGAL',
                'laporanhpps.KODE_OUTLET',
                'laporanhpps.Outlet',
                'itemakuns.Akun_Biaya',
                'itemakuns.Deskripsi_Akun_Biaya',
                Laporanakhir::raw('sum(Profit)as Pemunit')
            )->join('itemakuns', 'laporanhpps.KODE_BARANG', '=', 'itemakuns.KODE_BARANG_SAGE')->groupBy('laporanhpps.KODE_OUTLET', 'itemakuns.Akun_Biaya')->orderBy('laporanhpps.KODE_OUTLET')
                ->chunk(1000, function ($rows) {
                    foreach ($rows as $user) {
                        Rekapcog::insert([
                            'TANGGAL' => $user->TANGGAL,
                            'KODE' => $user->KODE_OUTLET,
                            'NAMA' => $user->Outlet,
                            'SAwalPrice' => $user->Pemunit,

                            'Pembelian_Unit' => $user->Akun_Biaya,
                            'akun' => $user->Deskripsi_Akun_Biaya
                        ]);
                    }
                });

            $laporanakhirview = Rekapcog::get();
            return view('RekapCogs', compact('laporanakhirview'));
        }

        return redirect("/")->withSuccess('Opps! You do not have access');
    }

    public function laporandua()
    {
        if (Auth::check()) {
            $laporanakhirview = Laporanakhir::get();
            return view('Laporansduas', compact('laporanakhirview'));
        }

        return redirect("/")->withSuccess('Opps! You do not have access');
    }

    public function caribom(Request $request)
    {
        if (Auth::check()) {
            $cari = $request->cari;
            $boms1 = Bom::where('KODE_BAHAN', 'like', "%" . $cari . "%")->get();
            $boms2 = Dprbom::where('KODE_BAHAN', 'like', "%" . $cari . "%")->get();
            $boms3 = Dprrckbom::where('KODE_BAHAN', 'like', "%" . $cari . "%")->get();

            return view('boms', compact('boms1', 'boms2', 'boms3'));
        }

        return redirect("/")->withSuccess('Opps! You do not have access');
    }


    public function export()
    {
        if (Auth::check()) {
            return Excel::download(new BomsExport, 'Laporan.xlsx');
        }

        return redirect("/")->withSuccess('Opps! You do not have access');
    }
    public function laporanhppexport()
    {
        if (Auth::check()) {
            return Excel::download(new Laporanhpps, 'LaporanHPP.xlsx');
        }

        return redirect("/")->withSuccess('Opps! You do not have access');
    }

    public function pengirimantes()
    {
        if (Auth::check()) {
            // sql = SELECT * FROM penjualans JOIN boms ON boms.KODE_BARANG LIKE CONCAT('%', penjualans.KODE_OUTLET ,'%') AND boms.KODE_BARANG LIKE CONCAT('%', penjualans.KODE_BARANG ,'%');

            // buat nyari quantity SELECT convertpembelians.KODE_DESKRIPSI_BARANG_SAGE, sum(convertpembelians.QUANTITY) FROM `convertpembelians` GROUP BY convertpembelians.KODE_DESKRIPSI_BARANG_SAGE, convertpembelians.KODE 
            //Outlet::where('KODE', 123)->update(['NAMA' => 'Updated title']);*/
            /*
        //penerimaan dari
        $penerimaan = Convertpenerimaan::select(
            'convertpenerimaans.TANGGAL',
            'convertpenerimaans.DARI',
            'convertpenerimaans.NAMADARI',
            'convertpenerimaans.KODE_BARANG_SAGE',
            'convertpenerimaans.KODE_DESKRIPSI_BARANG_SAGE',
            'convertpenerimaans.STOKING_UNIT_BOM',
            Convertpenerimaan::raw('sum(convertpenerimaans.QUANTITY) as unit'),
            'convertpenerimaans.HARGA',
            'convertpenerimaans.JUMLAH',
        )->groupBy('convertpenerimaans.TANGGAL', 'convertpenerimaans.DARI', 'convertpenerimaans.KODE_BARANG_SAGE')->get();

        foreach ($penerimaan as $Boms11) {
            Laporan::create([
                'TANGGAL' => $Boms11->TANGGAL,
                'KODE' => $Boms11->DARI,
                'NAMA' => $Boms11->NAMADARI,
                'KODE_BARANG_SAGE' => $Boms11->KODE_BARANG_SAGE,
                'KODE_DESKRIPSI_BARANG_SAGE' => $Boms11->KODE_DESKRIPSI_BARANG_SAGE,
                'STOKING_UNIT_BOM' => $Boms11->STOKING_UNIT_BOM,
                'Penerimaan_Unit' => $Boms11->unit,
                'Penerimaan_Quantity' => $Boms11->HARGA,
                'Penerimaan_Price' => $Boms11->JUMLAH,
                'Pengiriman_Unit' => $Boms11->unit

            ]);
        }
        // penerimaan penerima
        $penerimaan2 = Convertpenerimaan::select(
            'convertpenerimaans.TANGGAL',
            'convertpenerimaans.PENERIMA',
            'convertpenerimaans.NAMAPENERIMA',
            'convertpenerimaans.KODE_BARANG_SAGE',
            'convertpenerimaans.KODE_DESKRIPSI_BARANG_SAGE',
            'convertpenerimaans.STOKING_UNIT_BOM',
            Convertpenerimaan::raw('sum(convertpenerimaans.QUANTITY) as unit'),
            'convertpenerimaans.HARGA',
            'convertpenerimaans.JUMLAH',
        )->groupBy('convertpenerimaans.TANGGAL', 'convertpenerimaans.PENERIMA', 'convertpenerimaans.KODE_BARANG_SAGE')->get();

        foreach ($penerimaan2 as $Boms112) {
            $temp = Laporan::where('TANGGAL', $Boms112->TANGGAL)->where('KODE', $Boms112->PENERIMA)->where('KODE_BARANG_SAGE', $Boms112->KODE_BARANG_SAGE)
                ->update([
                    'Penerimaan_Unit' => $Boms112->unit, 'Penerimaan_Quantity' => $Boms112->HARGA,
                    'Penerimaan_Price' => $Boms112->JUMLAH
                ]);
            if ($temp) {
                continue;
            }
            Laporan::create([
                'TANGGAL' => $Boms112->TANGGAL,
                'KODE' => $Boms112->PENERIMA,
                'NAMA' => $Boms112->NAMAPENERIMA,
                'KODE_BARANG_SAGE' => $Boms112->KODE_BARANG_SAGE,
                'KODE_DESKRIPSI_BARANG_SAGE' => $Boms112->KODE_DESKRIPSI_BARANG_SAGE,
                'STOKING_UNIT_BOM' => $Boms112->STOKING_UNIT_BOM,
                'Penerimaan_Unit' => $Boms112->unit,
                'Penerimaan_Quantity' => $Boms112->HARGA,
                'Penerimaan_Price' => $Boms112->JUMLAH,
            ]);
        }


        //pembelian
        $pembelian = Convertpembelian::get();

        foreach ($pembelian as $pembelians) {
            $temp = Laporan::where('TANGGAL', $pembelians->TANGGAL)->where('KODE', $pembelians->KODE)->where('KODE_BARANG_SAGE', $pembelians->KODE_BARANG_SAGE)
                ->update([
                    'Pembelian_Unit' => $pembelians->QUANTITY, 'Pembelian_Quantity' => $pembelians->HARGA,
                    'Pembelian_Price' => $pembelians->JUMLAH
                ]);
            if ($temp) {
                continue;
            }
            Laporan::where('TANGGAL', '!=', $pembelians->TANGGAL)->Where('KODE', '!=', $pembelians->KODE)->Where('KODE_BARANG_SAGE', '!=', $pembelians->KODE_BARANG_SAGE)->create([
                'TANGGAL' => $pembelians->TANGGAL,
                'KODE' => $pembelians->KODE,
                'NAMA' => $pembelians->NAMA,
                'KODE_BARANG_SAGE' => $pembelians->KODE_BARANG_SAGE,
                'KODE_DESKRIPSI_BARANG_SAGE' => $pembelians->KODE_DESKRIPSI_BARANG_SAGE,
                'STOKING_UNIT_BOM' => $pembelians->STOKING_UNIT_BOM,
                'Pembelian_Unit' => $pembelians->QUANTITY,
                'Pembelian_Quantity' => $pembelians->HARGA,
                'Pembelian_Price' => $pembelians->JUMLAH,
            ]);
        }

        //bom
        $bomconvert = Convertbom::select(
            'convertboms.TANGGAL',
            'convertboms.KODE',
            'convertboms.NAMA',
            'convertboms.KODE_BARANG_SAGE',
            'convertboms.KODE_DESKRIPSI_BARANG_SAGE',
            'convertboms.STOKING_UNIT_BOM',
            Convertpenerimaan::raw('sum(convertboms.QUANTITY) as unit'),
        )->groupBy('convertboms.TANGGAL', 'convertboms.KODE', 'convertboms.KODE_BARANG_SAGE')->get();

        foreach ($bomconvert as $Bomsconvert1132) {
            $temp = Laporan::where('TANGGAL', $Bomsconvert1132->TANGGAL)->where('KODE', $Bomsconvert1132->KODE)->where('KODE_BARANG_SAGE', $Bomsconvert1132->KODE_BARANG_SAGE)
                ->update([
                    'Bom_Unit' => $Bomsconvert1132->unit
                ]);
            if ($temp) {
                continue;
            }
            Laporan::create([
                'TANGGAL' => $Bomsconvert1132->TANGGAL,
                'KODE' => $Bomsconvert1132->KODE,
                'NAMA' => $Bomsconvert1132->NAMA,
                'KODE_BARANG_SAGE' => $Bomsconvert1132->KODE_BARANG_SAGE,
                'KODE_DESKRIPSI_BARANG_SAGE' => $Bomsconvert1132->KODE_DESKRIPSI_BARANG_SAGE,
                'STOKING_UNIT_BOM' => $Bomsconvert1132->STOKING_UNIT_BOM,
                'Bom_Unit' => $Bomsconvert1132->unit,
            ]);
        }


        //Transin Trans OUT SALDO AKHIR
        $laporansdata = Laporan::get();
        foreach ($laporansdata as $Laporandatass) {
            Laporan::Where('laporans.TANGGAL', $Laporandatass->TANGGAL)->where('laporans.KODE', $Laporandatass->KODE)->where('laporans.KODE_BARANG_SAGE', $Laporandatass->KODE_BARANG_SAGE)
                ->update([
                    'laporans.TransferIn_Unit' => $Laporandatass->SAwalUnit + $Laporandatass->Pembelian_Unit + $Laporandatass->Penerimaan_Unit,
                    'laporans.TransferIn_Quantity' => ($Laporandatass->SAwalPrice + $Laporandatass->Pembelian_Price + $Laporandatass->Penerimaan_Price) / ($Laporandatass->SAwalUnit + $Laporandatass->Pembelian_Unit + $Laporandatass->Penerimaan_Unit),
                    'laporans.TransferIn_Price' => $Laporandatass->SAwalPrice + $Laporandatass->Pembelian_Price + $Laporandatass->Penerimaan_Price,

                    'laporans.Pengiriman_Quantity' => ($Laporandatass->SAwalPrice + $Laporandatass->Pembelian_Price + $Laporandatass->Penerimaan_Price) / ($Laporandatass->SAwalUnit + $Laporandatass->Pembelian_Unit + $Laporandatass->Penerimaan_Unit),
                    'laporans.Pengiriman_Price' => (($Laporandatass->SAwalPrice + $Laporandatass->Pembelian_Price + $Laporandatass->Penerimaan_Price) / ($Laporandatass->SAwalUnit + $Laporandatass->Pembelian_Unit + $Laporandatass->Penerimaan_Unit)) *  $Laporandatass->Pengiriman_Unit,

                    'laporans.Bom_Quantity' => ($Laporandatass->SAwalPrice + $Laporandatass->Pembelian_Price + $Laporandatass->Penerimaan_Price) / ($Laporandatass->SAwalUnit + $Laporandatass->Pembelian_Unit + $Laporandatass->Penerimaan_Unit),
                    'laporans.Bom_Price' => (($Laporandatass->SAwalPrice + $Laporandatass->Pembelian_Price + $Laporandatass->Penerimaan_Price) / ($Laporandatass->SAwalUnit + $Laporandatass->Pembelian_Unit + $Laporandatass->Penerimaan_Unit)) *  $Laporandatass->Bom_Unit,

                    'laporans.TransferOut_Unit' => $Laporandatass->Pengiriman_Unit + $Laporandatass->Bom_Unit,
                    'laporans.TransferOut_Quantity' => ($Laporandatass->SAwalPrice + $Laporandatass->Pembelian_Price + $Laporandatass->Penerimaan_Price) / ($Laporandatass->SAwalUnit + $Laporandatass->Pembelian_Unit + $Laporandatass->Penerimaan_Unit),
                    'laporans.TransferOut_Price' => (($Laporandatass->SAwalPrice + $Laporandatass->Pembelian_Price + $Laporandatass->Penerimaan_Price) / ($Laporandatass->SAwalUnit + $Laporandatass->Pembelian_Unit + $Laporandatass->Penerimaan_Unit)) * ($Laporandatass->Pengiriman_Unit + $Laporandatass->Bom_Unit),

                    'laporans.SAkhirUnit' => ($Laporandatass->SAwalUnit + $Laporandatass->Pembelian_Unit + $Laporandatass->Penerimaan_Unit) - ($Laporandatass->Pengiriman_Unit + $Laporandatass->Bom_Unit),
                    'laporans.SAkhirQuantity' => ($Laporandatass->SAwalPrice + $Laporandatass->Pembelian_Price + $Laporandatass->Penerimaan_Price) / ($Laporandatass->SAwalUnit + $Laporandatass->Pembelian_Unit + $Laporandatass->Penerimaan_Unit),
                    'laporans.SAkhirPrice' => (($Laporandatass->SAwalPrice + $Laporandatass->Pembelian_Price + $Laporandatass->Penerimaan_Price) / ($Laporandatass->SAwalUnit + $Laporandatass->Pembelian_Unit + $Laporandatass->Penerimaan_Unit)) * (($Laporandatass->SAwalUnit + $Laporandatass->Pembelian_Unit + $Laporandatass->Penerimaan_Unit) - ($Laporandatass->Pengiriman_Unit + $Laporandatass->Bom_Unit))
                ]);
        }
        foreach ($laporansdata as $Laporandatass) {
            Laporan::whereDate('laporans.TANGGAL', '>', $Laporandatass->TANGGAL)->where('laporans.KODE', $Laporandatass->KODE)->where('laporans.KODE_BARANG_SAGE', $Laporandatass->KODE_BARANG_SAGE)
                ->update([

                    'laporans.SAwalUnit' => $Laporandatass->SAkhirUnit,
                    'laporans.SAwalQuantity' => $Laporandatass->SAkhirQuantity,
                    'laporans.SAwalPrice' => $Laporandatass->SaldoAkhirPrice
                ]);
        }
        foreach ($laporansdata as $Laporandatass) {
            Laporan::Where('laporans.TANGGAL', $Laporandatass->TANGGAL)->where('laporans.KODE', $Laporandatass->KODE)->where('laporans.KODE_BARANG_SAGE', $Laporandatass->KODE_BARANG_SAGE)
                ->update([
                    'laporans.TransferIn_Unit' => $Laporandatass->SAwalUnit + $Laporandatass->Pembelian_Unit + $Laporandatass->Penerimaan_Unit,
                    'laporans.TransferIn_Quantity' => ($Laporandatass->SAwalPrice + $Laporandatass->Pembelian_Price + $Laporandatass->Penerimaan_Price) / ($Laporandatass->SAwalUnit + $Laporandatass->Pembelian_Unit + $Laporandatass->Penerimaan_Unit),
                    'laporans.TransferIn_Price' => $Laporandatass->SAwalPrice + $Laporandatass->Pembelian_Price + $Laporandatass->Penerimaan_Price,

                    'laporans.Pengiriman_Quantity' => ($Laporandatass->SAwalPrice + $Laporandatass->Pembelian_Price + $Laporandatass->Penerimaan_Price) / ($Laporandatass->SAwalUnit + $Laporandatass->Pembelian_Unit + $Laporandatass->Penerimaan_Unit),
                    'laporans.Pengiriman_Price' => (($Laporandatass->SAwalPrice + $Laporandatass->Pembelian_Price + $Laporandatass->Penerimaan_Price) / ($Laporandatass->SAwalUnit + $Laporandatass->Pembelian_Unit + $Laporandatass->Penerimaan_Unit)) *  $Laporandatass->Pengiriman_Unit,

                    'laporans.Bom_Quantity' => ($Laporandatass->SAwalPrice + $Laporandatass->Pembelian_Price + $Laporandatass->Penerimaan_Price) / ($Laporandatass->SAwalUnit + $Laporandatass->Pembelian_Unit + $Laporandatass->Penerimaan_Unit),
                    'laporans.Bom_Price' => (($Laporandatass->SAwalPrice + $Laporandatass->Pembelian_Price + $Laporandatass->Penerimaan_Price) / ($Laporandatass->SAwalUnit + $Laporandatass->Pembelian_Unit + $Laporandatass->Penerimaan_Unit)) *  $Laporandatass->Bom_Unit,

                    'laporans.TransferOut_Unit' => $Laporandatass->Pengiriman_Unit + $Laporandatass->Bom_Unit,
                    'laporans.TransferOut_Quantity' => ($Laporandatass->SAwalPrice + $Laporandatass->Pembelian_Price + $Laporandatass->Penerimaan_Price) / ($Laporandatass->SAwalUnit + $Laporandatass->Pembelian_Unit + $Laporandatass->Penerimaan_Unit),
                    'laporans.TransferOut_Price' => (($Laporandatass->SAwalPrice + $Laporandatass->Pembelian_Price + $Laporandatass->Penerimaan_Price) / ($Laporandatass->SAwalUnit + $Laporandatass->Pembelian_Unit + $Laporandatass->Penerimaan_Unit)) * ($Laporandatass->Pengiriman_Unit + $Laporandatass->Bom_Unit),

                    'laporans.SAkhirUnit' => ($Laporandatass->SAwalUnit + $Laporandatass->Pembelian_Unit + $Laporandatass->Penerimaan_Unit) - ($Laporandatass->Pengiriman_Unit + $Laporandatass->Bom_Unit),
                    'laporans.SAkhirQuantity' => ($Laporandatass->SAwalPrice + $Laporandatass->Pembelian_Price + $Laporandatass->Penerimaan_Price) / ($Laporandatass->SAwalUnit + $Laporandatass->Pembelian_Unit + $Laporandatass->Penerimaan_Unit),
                    'laporans.SAkhirPrice' => (($Laporandatass->SAwalPrice + $Laporandatass->Pembelian_Price + $Laporandatass->Penerimaan_Price) / ($Laporandatass->SAwalUnit + $Laporandatass->Pembelian_Unit + $Laporandatass->Penerimaan_Unit)) * (($Laporandatass->SAwalUnit + $Laporandatass->Pembelian_Unit + $Laporandatass->Penerimaan_Unit) - ($Laporandatass->Pengiriman_Unit + $Laporandatass->Bom_Unit))
                ]);
        }
        
        foreach ($penjua2lan as $Boms11) {
            Laporan::create([
                'TANGGAL' => $Boms11->TANGGAL,
                'KODE' => $Boms11->KODE_OUTLET,
                'NAMA' => $Boms11->Outlet,
                'KODE_BARANG_SAGE' => $Boms11->kodeBarang,
                'KODE_DESKRIPSI_BARANG_SAGE' => $Boms11->NAMA_BAHAN,
                'STOKING_UNIT_BOM' => $Boms11->SATUAN_BAHAN,
                'SAwalUnit' => $Boms11->QUANTITY,
                'SAwalQuantity' => $Boms11->HARGA,
                'SAwalPrice' => $Boms11->JUMLAH,
                'Pembelian_Unit' => $Boms11->QUANTITY,
                'Pembelian_Quantity' => $Boms11->HARGA,
                'Pembelian_Price' => $Boms11->JUMLAH,
                'Penerimaan_Unit' => $Boms11->QUANTITY,
                'Penerimaan_Quantity' => $Boms11->HARGA,
                'Penerimaan_Price' => $Boms11->JUMLAH,
                'TransferIn_Unit' => $Boms11->QUANTITY,
                'TransferIn_Quantity' => $Boms11->HARGA,
                'TransferIn_Price' => $Boms11->JUMLAH,
                'Pengiriman_Unit' => $Boms11->QUANTITY,
                'Pengiriman_Quantity' => $Boms11->HARGA,
                'Pengiriman_Price' => $Boms11->JUMLAH,
                'Bom_Unit' => $Boms11->QUANTITY,
                'Bom_Quantity' => $Boms11->HARGA,
                'Bom_Price' => $Boms11->JUMLAH,
                'TransferOut_Unit' => $Boms11->QUANTITY,
                'TransferOut_Quantity' => $Boms11->HARGA,
                'TransferOut_Price' => $Boms11->JUMLAH,
                'SAkhirUnit' => $Boms11->QUANTITY,
                'SAkhirQuantity' => $Boms11->HARGA,
                'SAkhirPrice' => $Boms11->JUMLAH
            ]);
        }
        $Boms2 = Penerimaan::join('boms', function ($join) {
            $join->on(
                'boms.KODE_BARANG',
                'LIKE',
                Penerimaan::raw("CONCAT('%', penerimaans.DARI, '%')")
            )->on(
                'boms.KODE_BARANG',
                'LIKE',
                Penerimaan::raw("CONCAT('%', penerimaans.KD_BHN, '%')")
            );
        })->select(
            'boms.KODE_BAHAN as KODE_BAHAN',
            'boms.NAMA_BAHAN as NAMA_BAHAN',
            'boms.BANYAK as BANYAK',
            'boms.SATUAN_BAHAN as SATUAN_BAHAN',
            'boms.KODE_BARANG as KODE_BARANG',
            'boms.NAMA_BARANG as NAMA_BARANG',
            'boms.SATUAN_BARANG as SATUAN_BARANG',
            'penerimaans.QT_TERIMA as Banyak2',
        )->get();
        */
            $boms1 = Bom::get();

            return view('TransaksiBom/Gudang', compact('Boms1'));
        }

        return redirect("/")->withSuccess('Opps! You do not have access');
    }

    public function LaporanTanggal(Request $request)
    {
        if (Auth::check()) {
            // menangkap data pencarian
            $date = $request->date;
            // Convertdprbom
            Laporanakhir::truncate();

            // SELECT `KODE`,`NAMA`,`KODE_BARANG_SAGE`,`KODE_DESKRIPSI_BARANG_SAGE`,sum(Pembelian_Unit),sum(Penerimaan_Unit),sum(Pengiriman_Unit),sum(Bom_Unit) FROM `laporans` WHERE `TANGGAL` < '2023-01-05' GROUP BY `KODE`,`KODE_BARANG_SAGE`;
            // select menentukan saldo awal
            $saldoawala = Laporan::whereDate('TANGGAL', '<', $date)
                ->join('items', 'laporans.KODE_BARANG_SAGE', '=', 'items.KODE_BARANG_SAGE')->select(
                    'laporans.KODE',
                    'laporans.NAMA',
                    'laporans.KODE_BARANG_SAGE',
                    'laporans.KODE_DESKRIPSI_BARANG_SAGE',
                    'items.BUYING_UNIT_SAGE',
                    Laporan::raw('sum(Pembelian_Unit) * items.RUMUS_untuk_BOM as Pemunit'),
                    Laporan::raw('sum(Penerimaan_Unit) * items.RUMUS_untuk_BOM as Peneunit'),
                    Laporan::raw('sum(Bom_Unit) * items.RUMUS_untuk_BOM as Bomunit'),
                    Laporan::raw('sum(Pengiriman_Unit) * items.RUMUS_untuk_BOM as pengiunit'),
                )->groupBy('laporans.KODE', 'laporans.KODE_BARANG_SAGE')->orderBy('laporans.KODE')->get();
            foreach ($saldoawala as $LaporanSaldoAwals) {
                Laporanakhir::insert([
                    'TANGGAL' => $date,
                    'KODE' => $LaporanSaldoAwals->KODE,
                    'NAMA' => $LaporanSaldoAwals->NAMA,
                    'KODE_BARANG_SAGE' => $LaporanSaldoAwals->KODE_BARANG_SAGE,
                    'KODE_DESKRIPSI_BARANG_SAGE' => $LaporanSaldoAwals->KODE_DESKRIPSI_BARANG_SAGE,
                    'STOKING_UNIT_BOM' => $LaporanSaldoAwals->BUYING_UNIT_SAGE,
                    'SAwalUnit' => ($LaporanSaldoAwals->Pemunit + $LaporanSaldoAwals->Peneunit) - ($LaporanSaldoAwals->pengiunit + $LaporanSaldoAwals->Bomunit),

                ]);
                Laporanakhir::where('KODE', '<>', 7301)->where('KODE', '<>', 7302)
                    ->where('KODE', '<', 9000)
                    ->where(Laporanakhir::raw('LEFT(KODE_BARANG_SAGE,2)'), '<>', '12')
                    ->where(Laporanakhir::raw('LEFT(KODE_BARANG_SAGE,2)'), '<>', '11')->update([
                        'SAwalUnit' => (($LaporanSaldoAwals->Pemunit + $LaporanSaldoAwals->Peneunit) - ($LaporanSaldoAwals->pengiunit + $LaporanSaldoAwals->Bomunit)) - ($LaporanSaldoAwals->Pemunit + $LaporanSaldoAwals->Peneunit)
                    ]);
            }

            $saldoterbaru = Laporan::whereDate('TANGGAL', '=', $date)->join('items', 'laporans.KODE_BARANG_SAGE', '=', 'items.KODE_BARANG_SAGE')
                ->select(
                    'laporans.KODE',
                    'laporans.NAMA',
                    'laporans.KODE_BARANG_SAGE',
                    'laporans.KODE_DESKRIPSI_BARANG_SAGE',
                    'items.BUYING_UNIT_SAGE',

                    Laporan::raw('sum(Pembelian_Unit) * items.RUMUS_untuk_BOM as Pemunit'),
                    Laporan::raw('sum(Pembelian_Price) as Pemprice'),

                    Laporan::raw('sum(Penerimaan_Unit) * items.RUMUS_untuk_BOM as Peneunit'),

                    Laporan::raw('sum(Pengiriman_Unit)* items.RUMUS_untuk_BOM as pengiunit'),

                    Laporan::raw('sum(Bom_Unit)* items.RUMUS_untuk_BOM as Bomunit'),



                )->groupBy('laporans.KODE', 'laporans.KODE_BARANG_SAGE')->orderBy('laporans.KODE_BARANG_SAGE')->get();
            foreach ($saldoterbaru as $LaporanSaldoAkhirs) {

                $temp = Laporanakhir::where('KODE', $LaporanSaldoAkhirs->KODE)->where('KODE_BARANG_SAGE', $LaporanSaldoAkhirs->KODE_BARANG_SAGE)
                    ->update([
                        'Pembelian_Unit' => $LaporanSaldoAkhirs->Pemunit,
                        'Pembelian_Price' => $LaporanSaldoAkhirs->Pemprice,
                        'Pembelian_Quantity' => $LaporanSaldoAkhirs->pemquan,

                        'Penerimaan_Unit' => $LaporanSaldoAkhirs->Peneunit,
                        'TransferIn_Unit' => Laporanakhir::raw('IFNULL(SAwalUnit, 0)+ ' .  $LaporanSaldoAkhirs->Pemunit + $LaporanSaldoAkhirs->Peneunit . ''),
                        'Pengiriman_Unit' => $LaporanSaldoAkhirs->pengiunit,
                        'Bom_Unit' => $LaporanSaldoAkhirs->Bomunit,
                        'TransferOut_Unit' => $LaporanSaldoAkhirs->pengiunit + $LaporanSaldoAkhirs->Bomunit,
                        'SAkhirUnit' => Laporanakhir::raw('(IFNULL(SAwalUnit, 0)+ ' .  $LaporanSaldoAkhirs->Pemunit + $LaporanSaldoAkhirs->Peneunit . ') - (' .  $LaporanSaldoAkhirs->pengiunit + $LaporanSaldoAkhirs->Bomunit . ')')
                    ]);
                if ($temp) {
                    continue;
                } else {
                    Laporanakhir::create([
                        'TANGGAL' => $date,
                        'KODE' => $LaporanSaldoAkhirs->KODE,
                        'NAMA' => $LaporanSaldoAkhirs->NAMA,
                        'KODE_BARANG_SAGE' => $LaporanSaldoAkhirs->KODE_BARANG_SAGE,
                        'KODE_DESKRIPSI_BARANG_SAGE' => $LaporanSaldoAkhirs->KODE_DESKRIPSI_BARANG_SAGE,
                        'STOKING_UNIT_BOM' => $LaporanSaldoAkhirs->BUYING_UNIT_SAGE,

                        'Pembelian_Unit' => $LaporanSaldoAkhirs->Pemunit,
                        'Pembelian_Price' => $LaporanSaldoAkhirs->Pemprice,
                        'Pembelian_Quantity' => $LaporanSaldoAkhirs->pemquan,

                        'Penerimaan_Unit' => $LaporanSaldoAkhirs->Peneunit,
                        'TransferIn_Unit' => ($LaporanSaldoAkhirs->Pemunit + $LaporanSaldoAkhirs->Peneunit),
                        'Pengiriman_Unit' => $LaporanSaldoAkhirs->pengiunit,
                        'Bom_Unit' => $LaporanSaldoAkhirs->Bomunit,
                        'TransferOut_Unit' => $LaporanSaldoAkhirs->pengiunit + $LaporanSaldoAkhirs->Bomunit,
                        'SAkhirUnit' => ($LaporanSaldoAkhirs->Pemunit + $LaporanSaldoAkhirs->Peneunit) - ($LaporanSaldoAkhirs->pengiunit + $LaporanSaldoAkhirs->Bomunit)
                    ]);

                    Laporanakhir::where('KODE', '<>', 7301)->where('KODE', '<>', 7302)
                        ->where('KODE', '<', 9000)
                        ->where(Laporanakhir::raw('LEFT(KODE_BARANG_SAGE,2)'), '<>', '12')
                        ->where(Laporanakhir::raw('LEFT(KODE_BARANG_SAGE,2)'), '<>', '11')
                        ->update([
                            'BiayaUnit' => Laporanakhir::raw('IFNULL(TransferIn_Unit, 0)'),
                            'SAkhirUnit' => Laporanakhir::raw('(TransferIn_Unit - TransferOut_Unit) - TransferIn_Unit ')
                        ]);
                }
            }

            $saldoterbaru = Laporan::whereDate('TANGGAL', '<=', $date)
                ->join('items', 'laporans.KODE_BARANG_SAGE', '=', 'items.KODE_BARANG_SAGE')
                ->select(
                    'laporans.KODE_BARANG_SAGE',
                    Laporan::raw('IFNULL(sum(Pembelian_Price),0) / IFNULL(sum(Pembelian_Unit)*items.RUMUS_untuk_BOM,1) as QUANTITY'),
                    Laporan::raw('IFNULL(sum(laporans.SAwalPrice), 0) / IFNULL(sum(laporans.SAwalUnit),1) as QUANTITY2')
                    // (((hitunhsaldoawalunit) * (hitungsaldoawalharga)) + (pembelianprice)) / (hitungsaldoawalunit)
                    // IFNULL((sum(Pembelian_Unit)+sum(Penerimaan_Unit)) -(sum(Pengiriman_Unit)+sum(Bom_Unit)),0)
                    // * (IFNULL(sum(laporans.SAwalPrice), 0) / IFNULL(sum(laporans.SAwalUnit)/items.RUMUS_untuk_BOM, 1))
                    // +  sum(Pembelian_Price)
                    // / IFNULL((sum(Pembelian_Unit)+sum(Penerimaan_Unit)) -(sum(Pengiriman_Unit)+sum(Bom_Unit)),1)
                    // saldo awal unit *  hitungsaldoawalharga = (IFNULL((sum(Pembelian_Unit)+sum(Penerimaan_Unit)) -(sum(Pengiriman_Unit)+sum(Bom_Unit)),0) * (IFNULL(sum(laporans.SAwalPrice), 0) / IFNULL(sum(laporans.SAwalUnit)/items.RUMUS_untuk_BOM, 1)))
                    // + ifnull = IFNULL((IFNULL((sum(Pembelian_Unit)+sum(Penerimaan_Unit)) -(sum(Pengiriman_Unit)+sum(Bom_Unit)),0) * (IFNULL(sum(laporans.SAwalPrice), 0) / IFNULL(sum(laporans.SAwalUnit)/items.RUMUS_untuk_BOM, 1)))+ sum(Pembelian_Price),0)
                    // last IFNULL(IFNULL((IFNULL((sum(Pembelian_Unit)+sum(Penerimaan_Unit)) -(sum(Pengiriman_Unit)+sum(Bom_Unit)),0) * (IFNULL(sum(laporans.SAwalPrice), 0) / IFNULL(sum(laporans.SAwalUnit)/items.RUMUS_untuk_BOM, 1)))+ sum(Pembelian_Price),0) /IFNULL((sum(Pembelian_Unit)+sum(Penerimaan_Unit)) -(sum(Pengiriman_Unit)+sum(Bom_Unit)),1),0 )
                    // Laporan::raw('IFNULL(IFNULL((IFNULL((sum(Pembelian_Unit)+sum(Penerimaan_Unit)) -(sum(Pengiriman_Unit)+sum(Bom_Unit)),0) * (IFNULL(sum(laporans.SAwalPrice), 0) / IFNULL(sum(laporans.SAwalUnit)/items.RUMUS_untuk_BOM, 1)))+ sum(Pembelian_Price),0) /IFNULL((sum(Pembelian_Unit)+sum(Penerimaan_Unit)) -(sum(Pengiriman_Unit)+sum(Bom_Unit)),1),0 ) as QUANTITY')
                    //Laporan::raw('IFNULL(IFNULL((IFNULL(sum(Pembelian_Unit)+sum(Penerimaan_Unit),0) * (IFNULL(sum(laporans.SAwalPrice), 0) / IFNULL(sum(laporans.SAwalUnit)/items.RUMUS_untuk_BOM, 1)))+ sum(Pembelian_Price),0) /IFNULL((sum(Pembelian_Unit)+sum(Penerimaan_Unit)),1),0 ) as QUANTITY')
                )->groupBy('laporans.KODE_BARANG_SAGE')->orderBy('laporans.KODE_BARANG_SAGE')->get();
            foreach ($saldoterbaru as $UpdateLaporanharians2) {
                if ($UpdateLaporanharians2->QUANTITY != 0) {
                    Laporanakhir::where('KODE_BARANG_SAGE', $UpdateLaporanharians2->KODE_BARANG_SAGE)
                        ->update([
                            'SAwalQuantity' => $UpdateLaporanharians2->QUANTITY,
                            'SAwalPrice' => Laporanakhir::raw('round(round(SAwalUnit,2) * ' . $UpdateLaporanharians2->QUANTITY . ',2) '),
                            'Penerimaan_Price' => Laporanakhir::raw('round(round(Penerimaan_Unit,2) * ' . $UpdateLaporanharians2->QUANTITY . ',2) '),
                            'TransferIn_Price' => Laporanakhir::raw('round(round(TransferIn_Unit,2) * ' . $UpdateLaporanharians2->QUANTITY . ',2) '),
                            'Pengiriman_Price' => Laporanakhir::raw('round(round(Pengiriman_Unit,2) * ' . $UpdateLaporanharians2->QUANTITY . ',2) '),
                            'Bom_Price' => Laporanakhir::raw('round(round(Bom_Unit,2) * ' . $UpdateLaporanharians2->QUANTITY . ',2) '),
                            'TransferOut_Price' => Laporanakhir::raw('round(round(TransferOut_Unit,2) * ' . $UpdateLaporanharians2->QUANTITY . ',2) '),
                            'BiayaPrice' => Laporanakhir::raw('round(round(BiayaUnit,2) * ' . $UpdateLaporanharians2->QUANTITY . ',2) '),
                            'SAkhirPrice' => Laporanakhir::raw('round(round(SAkhirUnit,2) * ' . $UpdateLaporanharians2->QUANTITY . ',2)')
                        ]);
                    Dprbom::where('dprboms.KODE_BAHAN', 'LIKE', '%' . $UpdateLaporanharians2->KODE_BARANG_SAGE . '%')->update([
                        'dprboms.Harga' => Dprbom::raw('round(dprboms.BANYAK * ' . $UpdateLaporanharians2->QUANTITY  .  ',2) ')
                    ]);
                    Dprrckbom::where('dprrckboms.KODE_BAHAN', 'LIKE', '%' . $UpdateLaporanharians2->KODE_BARANG_SAGE . '%')->update([
                        'dprrckboms.Harga' => Dprbom::raw('round(dprrckboms.BANYAK * ' . $UpdateLaporanharians2->QUANTITY  .  ',2) ')
                    ]);
                } else if ($UpdateLaporanharians2->QUANTITY2 != 0) {
                    Laporanakhir::where('KODE_BARANG_SAGE', $UpdateLaporanharians2->KODE_BARANG_SAGE)
                        ->update([
                            'SAwalQuantity' => $UpdateLaporanharians2->QUANTITY,
                            'SAwalPrice' => Laporanakhir::raw('round(round(SAwalUnit,2) * ' . $UpdateLaporanharians2->QUANTITY . ',2) '),
                            'Penerimaan_Price' => Laporanakhir::raw('round(round(Penerimaan_Unit,2) * ' . $UpdateLaporanharians2->QUANTITY . ',2) '),
                            'TransferIn_Price' => Laporanakhir::raw('round(round(TransferIn_Unit,2) * ' . $UpdateLaporanharians2->QUANTITY . ',2) '),
                            'Pengiriman_Price' => Laporanakhir::raw('round(round(Pengiriman_Unit,2) * ' . $UpdateLaporanharians2->QUANTITY . ',2) '),
                            'Bom_Price' => Laporanakhir::raw('round(round(Bom_Unit,2) * ' . $UpdateLaporanharians2->QUANTITY . ',2) '),
                            'TransferOut_Price' => Laporanakhir::raw('round(round(TransferOut_Unit,2) * ' . $UpdateLaporanharians2->QUANTITY . ',2) '),
                            'BiayaPrice' => Laporanakhir::raw('round(round(BiayaUnit,2) * ' . $UpdateLaporanharians2->QUANTITY . ',2) '),
                            'SAkhirPrice' => Laporanakhir::raw('round(round(SAkhirUnit,2) * ' . $UpdateLaporanharians2->QUANTITY . ',2)')
                        ]);
                    Dprbom::where('dprboms.KODE_BAHAN', 'LIKE', '%' . $UpdateLaporanharians2->KODE_BARANG_SAGE . '%')->update([
                        'dprboms.Harga' => Dprbom::raw('round(dprboms.BANYAK * ' . $UpdateLaporanharians2->QUANTITY2  .  ',2) ')
                    ]);
                    Dprrckbom::where('dprrckboms.KODE_BAHAN', 'LIKE', '%' . $UpdateLaporanharians2->KODE_BARANG_SAGE . '%')->update([
                        'dprrckboms.Harga' => Dprbom::raw('round(dprrckboms.BANYAK * ' . $UpdateLaporanharians2->QUANTITY2  .  ',2) ')
                    ]);
                }
            }
            $dprrckbomhargabarang = Dprrckbom::select(
                'dprrckboms.KODE_BARANG',
                Dprrckbom::raw('RIGHT(dprrckboms.KODE_BARANG, 11) as kode'),
                Dprrckbom::raw('round(sum(dprrckboms.Harga),2) as Harga2')
            )->groupBy('dprrckboms.KODE_BARANG')->get();

            foreach ($dprrckbomhargabarang as $dprrckbomhargabarangs) {
                if ($dprrckbomhargabarangs->Harga2 != null) {
                    Dprbom::where('dprboms.KODE_BAHAN', 'LIKE', '%' . $dprrckbomhargabarangs->kode . '%')
                        ->update([
                            'dprboms.Harga' => Dprbom::raw('round(round(dprboms.BANYAK,2) * ' . $dprrckbomhargabarangs->Harga2 . ',2) ')
                        ]);
                    Laporanakhir::where('KODE_BARANG_SAGE', $UpdateLaporanharians2->KODE_BARANG_SAGE)
                        ->update([
                            'SAwalQuantity' => $UpdateLaporanharians2->QUANTITY,
                            'SAwalPrice' => Laporanakhir::raw('round(round(SAwalUnit,2) * ' . $UpdateLaporanharians2->QUANTITY . ',2) '),
                            'Penerimaan_Price' => Laporanakhir::raw('round(round(Penerimaan_Unit,2) * ' . $UpdateLaporanharians2->QUANTITY . ',2) '),
                            'TransferIn_Price' => Laporanakhir::raw('round(round(TransferIn_Unit,2) * ' . $UpdateLaporanharians2->QUANTITY . ',2) '),
                            'Pengiriman_Price' => Laporanakhir::raw('round(round(Pengiriman_Unit,2) * ' . $UpdateLaporanharians2->QUANTITY . ',2) '),
                            'Bom_Price' => Laporanakhir::raw('round(round(Bom_Unit,2) * ' . $UpdateLaporanharians2->QUANTITY . ',2) '),
                            'TransferOut_Price' => Laporanakhir::raw('round(round(TransferOut_Unit,2) * ' . $UpdateLaporanharians2->QUANTITY . ',2) '),
                            'BiayaPrice' => Laporanakhir::raw('round(round(BiayaUnit,2) * ' . $UpdateLaporanharians2->QUANTITY . ',2) '),
                            'SAkhirPrice' => Laporanakhir::raw('round(round(SAkhirUnit,2) * ' . $UpdateLaporanharians2->QUANTITY . ',2)')
                        ]);
                }
            }

            $dprbomhargabarang = Dprbom::select(
                'dprboms.KODE_BARANG',
                Dprbom::raw('RIGHT(dprboms.KODE_BARANG, 11) as kode'),
                Dprbom::raw('round(sum(dprboms.Harga),2) as Harga2')
            )->groupBy('dprboms.KODE_BARANG')->get();

            /*memasukan nilai harga pada bahan jadi bom dapur pusat dari penjunmlahan bahan baku dapur pusat */
            foreach ($dprbomhargabarang as $dprbomhargabarangs) {
                if ($dprbomhargabarangs->Harga2 != null) {
                    Laporanakhir::where('KODE_BARANG_SAGE', $UpdateLaporanharians2->KODE_BARANG_SAGE)
                        ->update([
                            'SAwalQuantity' => $UpdateLaporanharians2->QUANTITY,
                            'SAwalPrice' => Laporanakhir::raw('round(round(SAwalUnit,2) * ' . $UpdateLaporanharians2->QUANTITY . ',2) '),
                            'Penerimaan_Price' => Laporanakhir::raw('round(round(Penerimaan_Unit,2) * ' . $UpdateLaporanharians2->QUANTITY . ',2) '),
                            'TransferIn_Price' => Laporanakhir::raw('round(round(TransferIn_Unit,2) * ' . $UpdateLaporanharians2->QUANTITY . ',2) '),
                            'Pengiriman_Price' => Laporanakhir::raw('round(round(Pengiriman_Unit,2) * ' . $UpdateLaporanharians2->QUANTITY . ',2) '),
                            'Bom_Price' => Laporanakhir::raw('round(round(Bom_Unit,2) * ' . $UpdateLaporanharians2->QUANTITY . ',2) '),
                            'TransferOut_Price' => Laporanakhir::raw('round(round(TransferOut_Unit,2) * ' . $UpdateLaporanharians2->QUANTITY . ',2) '),
                            'BiayaPrice' => Laporanakhir::raw('round(round(BiayaUnit,2) * ' . $UpdateLaporanharians2->QUANTITY . ',2) '),
                            'SAkhirPrice' => Laporanakhir::raw('round(round(SAkhirUnit,2) * ' . $UpdateLaporanharians2->QUANTITY . ',2)')
                        ]);
                }
            }

            $laporanakhirview = Laporanakhir::get();
            return view('Laporans', compact('laporanakhirview'));
        }
        return redirect("/")->withSuccess('Opps! You do not have access');
    }

    public function Laporanhppstanggal(Request $request)
    {
        if (Auth::check()) {
            // menangkap data pencarian
            $Tanggal = $request->date;
            Convertbom::truncate();
            Laporanhpp::truncate();

            $Boms23 =  Penjualan::whereDate('TANGGAL', '=', $Tanggal)->select(
                'penjualans.TANGGAL',
                'penjualans.KODE_OUTLET',
                'penjualans.Outlet',
                'penjualans.KODE_BARANG',
                'penjualans.Barang',
                'penjualans.Banyak',
                'penjualans.Jumlah'
            )->get();

            $datalaporanpenjualan = [];
            foreach ($Boms23 as $Boms23s) {
                if ($Boms23s->Banyak != 0) {
                    $datalaporanpenjualan[] = [
                        'TANGGAL' => $Boms23s->TANGGAL,
                        'KODE_OUTLET' => $Boms23s->KODE_OUTLET,
                        'Outlet' => $Boms23s->Outlet,
                        'KODE_BARANG' => $Boms23s->KODE_BARANG,
                        'Barang' => $Boms23s->Barang,
                        'Banyak' => $Boms23s->Banyak,
                        'Jumlah' => $Boms23s->Jumlah,
                        'Revenue' => $Boms23s->Jumlah / 1.1
                    ];
                }
            }
            foreach (array_chunk($datalaporanpenjualan, 1000) as $t) {
                Laporanhpp::insert($t);
            }

            $saldoterbaru = Laporan::whereDate('TANGGAL', '<=', $Tanggal)
                ->join('items', 'laporans.KODE_BARANG_SAGE', '=', 'items.KODE_BARANG_SAGE')
                ->select(
                    'laporans.KODE_BARANG_SAGE',
                    Laporan::raw('IFNULL(sum(Pembelian_Price),0) / IFNULL(sum(Pembelian_Unit),1) as QUANTITY'),
                    Laporan::raw('IFNULL(sum(laporans.SAwalPrice), 0) / (IFNULL(sum(laporans.SAwalUnit),0)/items.RUMUS_untuk_BOM) as QUANTITY2')
                    //Laporan::raw('IFNULL(IFNULL((IFNULL(sum(Pembelian_Unit)+sum(Penerimaan_Unit),0) * (IFNULL(sum(laporans.SAwalPrice), 0) / IFNULL(sum(laporans.SAwalUnit)/items.RUMUS_untuk_BOM, 1)))+ sum(Pembelian_Price),0) /IFNULL((sum(Pembelian_Unit)+sum(Penerimaan_Unit)),1),0 ) as QUANTITY')
                )->groupBy('laporans.KODE_BARANG_SAGE')->orderBy('laporans.KODE_BARANG_SAGE')->get();
            foreach ($saldoterbaru as $UpdateLaporanharians2) {
                if ($UpdateLaporanharians2->QUANTITY != 0) {
                    Bom::where('boms.KODE_BAHAN', 'LIKE', '%' . $UpdateLaporanharians2->KODE_BARANG_SAGE . '%')->update([
                        'boms.Harga' => Dprbom::raw('round(boms.BANYAK * ' . $UpdateLaporanharians2->QUANTITY  .  ',2) ')
                    ]);
                    Dprbom::where('dprboms.KODE_BAHAN', 'LIKE', '%' . $UpdateLaporanharians2->KODE_BARANG_SAGE . '%')->update([
                        'dprboms.Harga' => Dprbom::raw('round(dprboms.BANYAK * ' . $UpdateLaporanharians2->QUANTITY  .  ',2) ')
                    ]);
                    Dprrckbom::where('dprrckboms.KODE_BAHAN', 'LIKE', '%' . $UpdateLaporanharians2->KODE_BARANG_SAGE . '%')->update([
                        'dprrckboms.Harga' => Dprbom::raw('round(dprrckboms.BANYAK * ' . $UpdateLaporanharians2->QUANTITY  .  ',2) ')
                    ]);
                } else if ($UpdateLaporanharians2->QUANTITY2 != 0) {
                    Bom::where('boms.KODE_BAHAN', 'LIKE', '%' . $UpdateLaporanharians2->KODE_BARANG_SAGE . '%')->update([
                        'boms.Harga' => Dprbom::raw('round(boms.BANYAK * ' . $UpdateLaporanharians2->QUANTITY2  .  ',2) ')
                    ]);
                    Dprbom::where('dprboms.KODE_BAHAN', 'LIKE', '%' . $UpdateLaporanharians2->KODE_BARANG_SAGE . '%')->update([
                        'dprboms.Harga' => Dprbom::raw('round(dprboms.BANYAK * ' . $UpdateLaporanharians2->QUANTITY2  .  ',2) ')
                    ]);
                    Dprrckbom::where('dprrckboms.KODE_BAHAN', 'LIKE', '%' . $UpdateLaporanharians2->KODE_BARANG_SAGE . '%')->update([
                        'dprrckboms.Harga' => Dprbom::raw('round(dprrckboms.BANYAK * ' . $UpdateLaporanharians2->QUANTITY2  .  ',2) ')
                    ]);
                }
            }
            $dprrckbomhargabarang = Dprrckbom::select(
                'dprrckboms.KODE_BARANG',
                Dprrckbom::raw('RIGHT(dprrckboms.KODE_BARANG, 11) as kode'),
                Dprrckbom::raw('round(sum(dprrckboms.Harga),2) as Harga2')
            )->groupBy('dprrckboms.KODE_BARANG')->get();

            foreach ($dprrckbomhargabarang as $dprrckbomhargabarangs) {
                if ($dprrckbomhargabarangs->Harga2 != null) {
                    Dprbom::where('dprboms.KODE_BAHAN', 'LIKE', '%' . $dprrckbomhargabarangs->kode . '%')
                        ->update([
                            'dprboms.Harga' => Dprbom::raw('round(round(dprboms.BANYAK,2) * ' . $dprrckbomhargabarangs->Harga2 . ',2) ')
                        ]);
                    Bom::where('boms.KODE_BAHAN', 'LIKE', '%' . $dprrckbomhargabarangs->kode . '%')
                        ->update([
                            'boms.Harga' => Bom::raw('round(round(boms.BANYAK,2) * ' . $dprrckbomhargabarangs->Harga2 . ',2) ')
                        ]);
                }
            }

            $dprbomhargabarang = Dprbom::select(
                'dprboms.KODE_BARANG',
                Dprbom::raw('RIGHT(dprboms.KODE_BARANG, 11) as kode'),
                Dprbom::raw('round(sum(dprboms.Harga),2) as Harga2')
            )->groupBy('dprboms.KODE_BARANG')->get();

            /*memasukan nilai harga pada bahan jadi bom dapur pusat dari penjunmlahan bahan baku dapur pusat */
            foreach ($dprbomhargabarang as $dprbomhargabarangs) {
                if ($dprbomhargabarangs->Harga2 != null) {
                    Bom::where('boms.KODE_BAHAN', 'LIKE', '%' . $dprbomhargabarangs->kode . '%')->update([
                        'boms.Harga' => Bom::raw('round(round(boms.BANYAK,2) * ' . $dprbomhargabarangs->Harga2 . ',2) ')
                    ]);
                }
            }

            $bomharha = Bom::select(
                'boms.KODE_BARANG',
                Bom::raw('round(sum(boms.Harga),2) as Harga2'),
                Bom::raw('RIGHT(boms.KODE_BARANG, 13) as koode'),
            )->groupBy(
                'boms.KODE_BARANG'
            )->orderBy('boms.KODE_BARANG')->get();

            foreach ($bomharha as $bomhargas123) {
                if ($bomhargas123->Harga2 != null) {
                    Laporanhpp::where('KODE_BARANG',  $bomhargas123->koode)
                        ->update([
                            'COGS' => Laporanhpp::raw('round(laporanhpps.Banyak * ' . $bomhargas123->Harga2 . ',2) ')
                        ]);
                }
            }

            /*memasukan nilai harga pada bahan jadi bom dapur pusat dari penjunmlahan bahan baku dapur pusat */


            $laporanhppakhir = Laporanhpp::select(
                'laporanhpps.KODE_BARANG',
                'laporanhpps.Banyak',
                'laporanhpps.Jumlah',
                'laporanhpps.Revenue',
                'laporanhpps.COGS',
            )->orderBy('laporanhpps.KODE_BARANG')->get();
            foreach ($laporanhppakhir as $Bomslaporanhpps) {
                Laporanhpp::where('KODE_BARANG', $Bomslaporanhpps->KODE_BARANG)->update([
                    'Profit' => Laporanhpp::raw('round(laporanhpps.Revenue,2) - round(laporanhpps.COGS,2)'),
                    'Margin' => Laporanhpp::raw(' round(((round(laporanhpps.Revenue,2) - round(laporanhpps.COGS,2)) / round(laporanhpps.Revenue,2)) * 100,2)'),
                    'Revenue' => Laporanhpp::raw('round(laporanhpps.Revenue,2)')
                ]);
            }



            $penjualanss = Laporanhpp::get();
            return view('Laporanhpps', compact('penjualanss'));
        }

        return redirect("/")->withSuccess('Opps! You do not have access');
    }
    public function LaporanTanggaldua(Request $request)
    {
        if (Auth::check()) {
            // menangkap data pencarian
            $Tanggal_awal = $request->Tanggal_awal;
            $Tanggal_akhir = $request->Tanggal_akhir;

            // Convertdprbom
            Laporanakhir::truncate();

            // SELECT `KODE`,`NAMA`,`KODE_BARANG_SAGE`,`KODE_DESKRIPSI_BARANG_SAGE`,sum(Pembelian_Unit),sum(Penerimaan_Unit),sum(Pengiriman_Unit),sum(Bom_Unit) FROM `laporans` WHERE `TANGGAL` < '2023-01-05' GROUP BY `KODE`,`KODE_BARANG_SAGE`;
            $LaporanSaldoAwal = Laporan::select(
                'KODE',
                'NAMA',
                'KODE_BARANG_SAGE',
                'KODE_DESKRIPSI_BARANG_SAGE',
                'STOKING_UNIT_BOM',
                Laporan::raw('sum(Pembelian_Unit)as Pemunit'),
                Laporan::raw('sum(Pembelian_Price)as Pemprice'),

                Laporan::raw('sum(Penerimaan_Unit)as Peneunit'),
                Laporan::raw('sum(Penerimaan_Price)as Peneprice'),

                Laporan::raw('sum(Pengiriman_Unit)as pengiunit'),

                Laporan::raw('sum(Bom_Unit)as Bomunit'),

            )->groupBy('KODE', 'KODE_BARANG_SAGE')->whereDate('TANGGAL', '<', $Tanggal_awal)->get();

            foreach ($LaporanSaldoAwal as $LaporanSaldoAwals) {
                Laporanakhir::create([
                    'KODE' => $LaporanSaldoAwals->KODE,
                    'NAMA' => $LaporanSaldoAwals->NAMA,
                    'KODE_BARANG_SAGE' => $LaporanSaldoAwals->KODE_BARANG_SAGE,
                    'KODE_DESKRIPSI_BARANG_SAGE' => $LaporanSaldoAwals->KODE_DESKRIPSI_BARANG_SAGE,
                    'STOKING_UNIT_BOM' => $LaporanSaldoAwals->STOKING_UNIT_BOM,

                    'SAkhirUnit' => $LaporanSaldoAwals->Pemunit + $LaporanSaldoAwals->Peneunit,
                    'SAkhirPrice' => $LaporanSaldoAwals->Pemprice + $LaporanSaldoAwals->Peneprice,

                    'SAkhirQuantity' => Laporanakhir::raw('IFNULL(SAkhirPrice / NULLIF( SAkhirUnit, 0 ), 0)  '),

                    'Pengiriman_Price' => $LaporanSaldoAwals->pengiunit,
                    'Bom_Price' => $LaporanSaldoAwals->Bomunit,

                    'SAwalUnit' => ($LaporanSaldoAwals->Pemunit + $LaporanSaldoAwals->Peneunit) - ($LaporanSaldoAwals->pengiunit + $LaporanSaldoAwals->Bomunit),
                    'SAwalPrice' => Laporanakhir::raw('SAkhirPrice - ((SAkhirQuantity * IFNULL( Pengiriman_Price, 0 )) +( SAkhirQuantity * IFNULL( Bom_Price, 0 )))'),
                    'SAwalQuantity' => Laporanakhir::raw('IFNULL(SAwalPrice / NULLIF( SAwalUnit, 0 ), 0)')
                ]);
            }

            $UpdateBiayaLaporan1 = Laporanakhir::get();

            foreach ($UpdateBiayaLaporan1 as $LaporanSaldoAwals123) {
                Laporanakhir::where('KODE', '<>', 7301)->where('KODE', '<>', 7302)
                    ->where('KODE', '<', 9000)
                    ->where(Laporanakhir::raw('LEFT(KODE_BARANG_SAGE,2)'), '<>', '12')
                    ->where(Laporanakhir::raw('LEFT(KODE_BARANG_SAGE,2)'), '<>', '11')
                    ->update([

                        'SAwalUnit' => Laporanakhir::raw('(SAkhirUnit -(Pengiriman_Price + Bom_Price)) - SAkhirUnit'),
                        'SAwalPrice' => Laporanakhir::raw('(SAkhirPrice - ((SAkhirQuantity * IFNULL( Pengiriman_Price, 0 )) +( SAkhirQuantity * IFNULL( Bom_Price, 0 )))) - SAkhirPrice')
                    ]);
            }

            $LaporanSaldoAwalupdate = Laporanakhir::get();

            foreach ($LaporanSaldoAwalupdate as $LaporanSaldoAwals) {
                Laporanakhir::where('KODE', $LaporanSaldoAwals->KODE)->where('KODE_BARANG_SAGE', $LaporanSaldoAwals->KODE_BARANG_SAGE)
                    ->update([
                        'Pembelian_Unit' => 0,
                        'Pembelian_Quantity' => 0,
                        'Pembelian_Price' => 0,

                        'Penerimaan_Unit' => 0,
                        'Penerimaan_Quantity' => 0,
                        'Penerimaan_Price' => 0,

                        'TransferIn_Unit' => $LaporanSaldoAwals->SAwalUnit,
                        'TransferIn_Price' => $LaporanSaldoAwals->SAwalPrice,
                        'TransferIn_Quantity' => $LaporanSaldoAwals->SAwalQuantity,

                        'Pengiriman_Price' => 0,
                        'Bom_Price' => 0,

                        'TransferOut_Quantity' => 0,
                        'TransferOut_Price' => 0,

                        'SAkhirUnit' => $LaporanSaldoAwals->SAwalUnit,
                        'SAkhirQuantity' => $LaporanSaldoAwals->SAwalQuantity,
                        'SAkhirPrice' => $LaporanSaldoAwals->SAwalPrice
                    ]);
            }



            $LaporanSaldoAkhir = Laporan::select(
                'KODE',
                'NAMA',
                'KODE_BARANG_SAGE',
                'KODE_DESKRIPSI_BARANG_SAGE',
                'STOKING_UNIT_BOM',

                Laporan::raw('sum(Pembelian_Unit)as Pemunit'),
                Laporan::raw('sum(Pembelian_Price)as Pemprice'),

                Laporan::raw('sum(Penerimaan_Unit)as Peneunit'),
                Laporan::raw('sum(Penerimaan_Price)as Peneprice'),

                Laporan::raw('sum(Pengiriman_Unit)as pengiunit'),

                Laporan::raw('sum(Bom_Unit)as Bomunit'),

            )->groupBy('KODE', 'KODE_BARANG_SAGE')->whereDate('TANGGAL', '>=', $Tanggal_awal)->whereDate('TANGGAL', '<=', $Tanggal_akhir)->get();

            foreach ($LaporanSaldoAkhir as $LaporanSaldoAkhirs) {

                $temp = Laporanakhir::where('KODE', $LaporanSaldoAkhirs->KODE)->where('KODE_BARANG_SAGE', $LaporanSaldoAkhirs->KODE_BARANG_SAGE)
                    ->update([

                        'Pembelian_Unit' => $LaporanSaldoAkhirs->Pemunit,
                        'Pembelian_Price' => $LaporanSaldoAkhirs->Pemprice,
                        'Pembelian_Quantity' => Laporanakhir::raw(' IFNULL(Pembelian_Price / NULLIF( Pembelian_Unit, 0 ), 0)'),

                        'Penerimaan_Unit' => $LaporanSaldoAkhirs->Peneunit,
                        'Penerimaan_Price' => $LaporanSaldoAkhirs->Peneprice,
                        'Penerimaan_Quantity' => Laporanakhir::raw(' IFNULL(Penerimaan_Price / NULLIF( Penerimaan_Unit, 0 ), 0)'),


                        'TransferIn_Unit' => Laporanakhir::raw('IFNULL(SAwalUnit, 0)+ IFNULL(Pembelian_Unit, 0) +IFNULL(Penerimaan_Unit, 0)'),
                        'TransferIn_Price' => Laporanakhir::raw('IFNULL(SAwalPrice, 0)+ IFNULL(Pembelian_Price, 0) +IFNULL(Penerimaan_Price, 0)'),
                        'TransferIn_Quantity' => Laporanakhir::raw(' IFNULL(TransferIn_Price / NULLIF( TransferIn_Unit, 0 ), 0)'),


                        'Pengiriman_Unit' => $LaporanSaldoAkhirs->pengiunit,
                        'Pengiriman_Quantity' => Laporanakhir::raw('IF(Pengiriman_Unit IS NULL, 0, TransferIn_Quantity)'),
                        'Pengiriman_Price' => Laporanakhir::raw('IFNULL(TransferIn_Quantity, 0) * IFNULL(Pengiriman_Unit, 0)'),


                        'Bom_Unit' => $LaporanSaldoAkhirs->Bomunit,
                        'Bom_Quantity' => Laporanakhir::raw('IF(Bom_Unit IS NULL, 0, TransferIn_Quantity)'),
                        'Bom_Price' => Laporanakhir::raw('IFNULL(TransferIn_Quantity, 0) * IFNULL(Bom_Unit, 0)'),


                        'TransferOut_Unit' => $LaporanSaldoAkhirs->pengiunit + $LaporanSaldoAkhirs->Bomunit,
                        'TransferOut_Quantity' => Laporanakhir::raw('IF(TransferOut_Unit IS NULL, 0, TransferIn_Quantity) '),
                        'TransferOut_Price' => Laporanakhir::raw('IFNULL(TransferIn_Quantity, 0) *IFNULL(TransferOut_Unit, 0)'),

                        'SAkhirUnit' => Laporanakhir::raw('IFNULL(TransferIn_Unit, 0) - IFNULL(TransferOut_Unit, 0)  '),
                        'SAkhirQuantity' => Laporanakhir::raw('TransferIn_Quantity'),
                        'SAkhirPrice' => Laporanakhir::raw('TransferIn_Quantity * SAkhirUnit')

                    ]);
                if ($temp) {
                    continue;
                } else {
                    Laporanakhir::create([
                        'KODE' => $LaporanSaldoAkhirs->KODE,
                        'NAMA' => $LaporanSaldoAkhirs->NAMA,
                        'KODE_BARANG_SAGE' => $LaporanSaldoAkhirs->KODE_BARANG_SAGE,
                        'KODE_DESKRIPSI_BARANG_SAGE' => $LaporanSaldoAkhirs->KODE_DESKRIPSI_BARANG_SAGE,
                        'STOKING_UNIT_BOM' => $LaporanSaldoAkhirs->STOKING_UNIT_BOM,

                        'Pembelian_Unit' => $LaporanSaldoAkhirs->Pemunit,
                        'Pembelian_Price' => $LaporanSaldoAkhirs->Pemprice,
                        'Pembelian_Quantity' => Laporanakhir::raw(' IFNULL(Pembelian_Price / NULLIF( Pembelian_Unit, 0 ), 0)'),

                        'Penerimaan_Unit' => $LaporanSaldoAkhirs->Peneunit,
                        'Penerimaan_Price' => $LaporanSaldoAkhirs->Peneprice,
                        'Penerimaan_Quantity' => Laporanakhir::raw(' IFNULL(Penerimaan_Price / NULLIF( Penerimaan_Unit, 0 ), 0)'),

                        'TransferIn_Unit' => Laporanakhir::raw('IFNULL(SAwalUnit, 0)+ IFNULL(Pembelian_Unit, 0) +IFNULL(Penerimaan_Unit, 0)'),
                        'TransferIn_Price' => Laporanakhir::raw('IFNULL(SAwalPrice, 0)+ IFNULL(Pembelian_Price, 0) +IFNULL(Penerimaan_Price, 0)'),
                        'TransferIn_Quantity' => Laporanakhir::raw(' IFNULL(TransferIn_Price / NULLIF( TransferIn_Unit, 0 ), 0)'),

                        'Pengiriman_Unit' => $LaporanSaldoAkhirs->pengiunit,
                        'Pengiriman_Quantity' => Laporanakhir::raw(' IF(Pengiriman_Unit IS NULL, 0, TransferIn_Quantity)'),
                        'Pengiriman_Price' => Laporanakhir::raw('IFNULL(TransferIn_Quantity, 0) * IFNULL(Pengiriman_Unit, 0)'),

                        'Bom_Unit' => $LaporanSaldoAkhirs->Bomunit,
                        'Bom_Quantity' => Laporanakhir::raw('IF(Bom_Unit IS NULL, 0, TransferIn_Quantity)'),
                        'Bom_Price' => Laporanakhir::raw('IFNULL(TransferIn_Quantity, 0) * IFNULL(Bom_Unit, 0)'),


                        'TransferOut_Unit' => $LaporanSaldoAkhirs->pengiunit + $LaporanSaldoAkhirs->Bomunit,
                        'TransferOut_Quantity' => Laporanakhir::raw(' IF(TransferOut_Unit IS NULL, 0, TransferIn_Quantity)'),
                        'TransferOut_Price' => Laporanakhir::raw('IFNULL(TransferIn_Quantity, 0) *IFNULL(TransferOut_Unit, 0)'),


                        'SAkhirUnit' => Laporanakhir::raw('IFNULL(TransferIn_Unit, 0) - IFNULL(TransferOut_Unit, 0)  '),
                        'SAkhirQuantity' => Laporanakhir::raw(' IFNULL(TransferIn_Price / NULLIF( TransferIn_Unit, 0 ), 0)'),
                        'SAkhirPrice' => Laporanakhir::raw('TransferIn_Quantity * SAkhirUnit')



                    ]);
                }
            }



            $UpdateBiayaLaporan = Laporanakhir::get();

            foreach ($UpdateBiayaLaporan as $LaporanSaldoAwals) {
                Laporanakhir::where('KODE', '<>', 7301)->where('KODE', '<>', 7302)
                    ->where('KODE', '<', 9000)
                    ->where(Laporanakhir::raw('LEFT(KODE_BARANG_SAGE,2)'), '<>', '12')
                    ->where(Laporanakhir::raw('LEFT(KODE_BARANG_SAGE,2)'), '<>', '11')
                    ->update([

                        'BiayaUnit' => Laporanakhir::raw('IFNULL(TransferIn_Unit, 0)'),
                        'BiayaQuantity' => Laporanakhir::raw('IFNULL(TransferIn_Quantity, 0)'),
                        'BiayaPrice' => Laporanakhir::raw('IFNULL(TransferIn_Price, 0)'),

                        'SAkhirUnit' => Laporanakhir::raw('(TransferIn_Unit - TransferOut_Unit) - TransferIn_Unit '),
                        'SAkhirQuantity' => Laporanakhir::raw('TransferIn_Quantity '),
                        'SAkhirPrice' => Laporanakhir::raw('SAkhirUnit*TransferIn_Quantity')
                    ]);
            }

            $laporanakhirview = Laporanakhir::get();
            return view('Laporansduas', compact('laporanakhirview'));
        }

        return redirect("/")->withSuccess('Opps! You do not have access');
    }
    public function carilaporan(Request $request)
    {
        if (Auth::check()) {
            $cari = $request->cari;
            $laporanakhirview = Laporanakhir::where('KODE', $cari)->get();
            return view('Laporans', compact('laporanakhirview'));
        }

        return redirect("/")->withSuccess('Opps! You do not have access');
    }

    /*
                DB::table('tbl')->where('num', '>', 3)->chunk(500, function($rows) {
                // process $rows
            });

            $Bomslaporanhpp = Laporanhpp::select(
                        'laporanhpps.KODE_BARANG',
                        'laporanhpps.Banyak',
                        'laporanhpps.Jumlah',
                        'laporanhpps.Revenue',
                        'laporanhpps.COGS',
                    )->get();

                    foreach ($Bomslaporanhpp as $Bomslaporanhpps) {
                        Laporanhpp::where('KODE_BARANG', $Bomslaporanhpps->KODE_BARANG)->update([
                            'Profit' => Laporanhpp::raw('round(round(laporanhpps.Revenue,2) - round(laporanhpps.COGS,2),2)'),
                            'Margin' => Laporanhpp::raw(' round(((round(laporanhpps.Revenue,2) - round(laporanhpps.COGS,2)) / round(laporanhpps.Revenue,2)) * 100,2)'),
                            'Revenue' => Laporanhpp::raw('round(laporanhpps.Revenue,2)')
                        ]);
                    }
            $dprrckbomhargabarang = Dprrckbom::select(
                            'dprrckboms.KODE_BARANG',
                            Dprrckbom::raw('sum(dprrckboms.Harga) as Harga1')
                        )->groupBy('dprrckboms.KODE_BARANG')->get();

                        foreach ($dprrckbomhargabarang as $dprrckbomhargabarangs) {
                            Dprrckbom::where('KODE_BARANG', $dprrckbomhargabarangs->KODE_BARANG)
                                ->update(['dprrckboms.HargaBarang' => $dprrckbomhargabarangs->Harga1]);
                        }

                        $dprbomhargabarang = Dprbom::select(
                            'dprboms.KODE_BARANG',
                            Dprbom::raw('sum(dprboms.Harga) as Harga1')
                        )->groupBy('dprboms.KODE_BARANG')->get();

                        foreach ($dprbomhargabarang as $dprbomhargabarangs) {
                            Dprbom::where('KODE_BARANG', $dprbomhargabarangs->KODE_BARANG)
                                ->update(['dprboms.HargaBarang' => $dprbomhargabarangs->Harga1]);
                        }


                        $items1123 = Item::select('dprrckboms.NAMA_BARANG', 'dprrckboms.HargaBarang')->join(
                            'dprrckboms',
                            'items.KODE_DESKRIPSI_BARANG_SAGE',
                            '=',
                            'dprrckboms.NAMA_BARANG'
                        )->get();

                        foreach ($items1123 as $itemss1123) {
                            Item::where('KODE_DESKRIPSI_BARANG_SAGE', $itemss1123->NAMA_BARANG)->update(['items.Harga' => $itemss1123->HargaBarang]);
                        }

                        $items11234 = Item::select('dprboms.NAMA_BARANG', 'dprboms.HargaBarang')->join(
                            'dprboms',
                            'items.KODE_DESKRIPSI_BARANG_SAGE',
                            '=',
                            'dprboms.NAMA_BARANG'
                        )->get();

                        foreach ($items11234 as $itemss11234) {
                            Item::where('KODE_DESKRIPSI_BARANG_SAGE', $itemss11234->NAMA_BARANG)->update(['items.Harga' => $itemss11234->HargaBarang]);
                        }

                        $bom2 = Bom::select('boms.NAMA_BAHAN', 'items.Harga')->join(
                            'items',
                            'items.KODE_DESKRIPSI_BARANG_SAGE',
                            '=',
                            'boms.NAMA_BAHAN'
                        )->groupBy('boms.NAMA_BAHAN')->get();
                        foreach ($bom2 as $bom2s) {
                            Bom::where('NAMA_BAHAN', $bom2s->NAMA_BAHAN)
                                ->update(['boms.Harga' => $bom2s->Harga]);
                        }

                        $bom3 = Bom::select(
                            'boms.KODE_BARANG',
                            Bom::raw('sum(boms.Harga) as Harga2')
                        )->groupBy('boms.KODE_BARANG')->get();

                        foreach ($bom3 as $bom3s) {
                            Bom::where('KODE_BARANG', $bom3s->KODE_BARANG)
                                ->update(['boms.HargaBarang' => $bom3s->Harga2]);
                        }
            $items1234 = Item::join(
                        'pembelians',
                        'pembelians.KD_BRG',
                        '=',
                        'items.KODE_BARANG_PURCHASING'
                    )->select(
                        'items.KODE_BARANG_PURCHASING',
                        Item::raw('round(sum(pembelians.JUMLAH)/((sum(pembelians.BANYAK) * items.RUMUS_Untuk_Purchase) / items.RUMUS_untuk_BOM),2) as Harga123')
                    )->groupBy('pembelians.KD_BRG')->get();

                    foreach ($items1234 as $items1234s) {
                        Item::where('KODE_BARANG_PURCHASING', $items1234s->KODE_BARANG_PURCHASING)
                            ->update(['items.Harga' => $items1234s->Harga123]);
                    }

                    $dprrckbomhargabahan = Dprrckbom::join('items', 'items.KODE_BARANG_SAGE', '=', Dprrckbom::raw('RIGHT(dprrckboms.KODE_BAHAN,11)'))
                        ->where('items.Harga', '!=', null)->select(
                            'dprrckboms.KODE_BAHAN',
                            'items.Harga as Harga2'
                        )
                        ->get();

                    foreach ($dprrckbomhargabahan as $dprrckbomhargabahans) {
                        Dprrckbom::where('KODE_BAHAN', $dprrckbomhargabahans->KODE_BAHAN)
                            ->update(['dprrckboms.Harga' => $dprrckbomhargabahans->Harga2]);
                    }

                    $dprbomitem = Dprbom::join('items', 'items.KODE_BARANG_SAGE', '=',  Dprbom::raw('RIGHT(dprboms.KODE_BAHAN,11)'))
                        ->where('items.Harga', '!=', null)->select(
                            'dprboms.KODE_BAHAN',
                            'items.Harga as Harga22'
                        )->get();

                    foreach ($dprbomitem as $dprbomitems) {
                        Dprbom::where('KODE_BAHAN', $dprbomitems->KODE_BAHAN)->update(['dprboms.Harga' => $dprbomitems->Harga22]);
                    }

                    $bom12322 = Bom::join('items', 'items.KODE_DESKRIPSI_BARANG_SAGE', '=', 'boms.NAMA_BAHAN')
                        ->where('items.Harga', '!=', null)->select(
                            'boms.NAMA_BAHAN',
                            'items.Harga as Harga12'
                        )->get();

                    foreach ($bom12322 as $bom12322s) {
                        Bom::where('NAMA_BAHAN', $bom12322s->NAMA_BAHAN)->update(['boms.Harga' => $bom12322s->Harga12]);
                    }
                    $Boms1 = Laporanhpp::join(
                        'boms',
                        Laporanhpp::raw('RIGHT(boms.KODE_BARANG,13)'),
                        '=',
                        'laporanhpps.KODE_BARANG'
                    )->select(
                        'laporanhpps.TANGGAL',
                        'laporanhpps.KODE_OUTLET',
                        'laporanhpps.Outlet',
                        'boms.NAMA_BAHAN',
                        'boms.NAMA_BARANG',
                        'boms.SATUAN_BAHAN',
                        Laporanhpp::raw('laporanhpps.Banyak *boms.BANYAK as quantit2y ')
                    )->get();

                    $dataconvertboms = [];
                    foreach ($Boms1 as $Boms11) {
                        $dataconvertboms = [
                            'TANGGAL' => $Boms11->TANGGAL,
                            'KODE' => $Boms11->KODE_OUTLET,
                            'NAMA' => $Boms11->Outlet,
                            'KODE_BARANG_SAGE' => $Boms11->NAMA_BAHAN,
                            'KODE_DESKRIPSI_BARANG_SAGE' => $Boms11->NAMA_BARANG,
                            'STOKING_UNIT_BOM' => $Boms11->SATUAN_BAHAN,
                            'QUANTITY' => $Boms11->quantit2y,
                            'HARGA' => 0,
                            'JUMLAH' => 0
                        ];
                        Convertbom::insert($dataconvertboms);
                    }
            
                        $bom1234 = Convertbom::join('boms', 'boms.NAMA_BAHAN', '=', 'convertboms.KODE_BARANG_SAGE')
                            ->select(
                                'convertboms.KODE_BARANG_SAGE',
                                Convertbom::raw('convertboms.QUANTITY *items.Harga as harga22 ')
                            )->get();
                        foreach ($bom1234 as $bom1234s) {
                            Convertbom::where('KODE_BARANG_SAGE', $bom1234s->KODE_BARANG_SAGE)
                                ->update(['HARGA' => $bom1234s->harga22]);
                        }

                        $bom1234sum = Convertbom::select(
                            'convertboms.KODE_DESKRIPSI_BARANG_SAGE',
                            Convertbom::raw('sum(convertboms.HARGA) as Harga21')
                        )->groupBy(
                            'convertboms.KODE_DESKRIPSI_BARANG_SAGE'
                        )->get();

                        foreach ($bom1234sum as $bom1234sums) {
                            Convertbom::where('KODE_DESKRIPSI_BARANG_SAGE', $bom1234sums->KODE_DESKRIPSI_BARANG_SAGE)
                                ->update(['JUMLAH' => $bom1234sums->Harga21]);
                        }
            //penerimaan dari

                $penerimaan = Convertpenerimaan::select(
                    'convertpenerimaans.TANGGAL',
                    'convertpenerimaans.DARI',
                    'convertpenerimaans.NAMADARI',
                    'convertpenerimaans.KODE_BARANG_SAGE',
                    'convertpenerimaans.KODE_DESKRIPSI_BARANG_SAGE',
                    'convertpenerimaans.STOKING_UNIT_BOM',
                    Convertpenerimaan::raw('sum(convertpenerimaans.QUANTITY) as unit'),
                    'convertpenerimaans.HARGA',
                    'convertpenerimaans.JUMLAH',
                )->groupBy('convertpenerimaans.TANGGAL', 'convertpenerimaans.DARI', 'convertpenerimaans.KODE_BARANG_SAGE')->get();

                foreach ($penerimaan as $Boms11) {
                    $temp = Laporan::Where('TANGGAL', $Boms11->TANGGAL)->where('KODE', $Boms11->DARI)->where('KODE_BARANG_SAGE', $Boms11->KODE_BARANG_SAGE)
                        ->update([
                            'Penerimaan_Unit' => $Boms11->unit, 'Penerimaan_Quantity' => $Boms11->HARGA,
                            'Penerimaan_Price' => $Boms11->JUMLAH, 'Pengiriman_Unit' => $Boms11->unit
                        ]);
                    if ($temp) {
                        continue;
                    } else {
                        Laporan::where('TANGGAL', '!=', $Boms11->TANGGAL)->where('KODE', '!=', $Boms11->DARI)->where('KODE_BARANG_SAGE', '!=', $Boms11->KODE_BARANG_SAGE)
                            ->create([
                                'TANGGAL' => $Boms11->TANGGAL,
                                'KODE' => $Boms11->DARI,
                                'NAMA' => $Boms11->NAMADARI,
                                'KODE_BARANG_SAGE' => $Boms11->KODE_BARANG_SAGE,
                                'KODE_DESKRIPSI_BARANG_SAGE' => $Boms11->KODE_DESKRIPSI_BARANG_SAGE,
                                'STOKING_UNIT_BOM' => $Boms11->STOKING_UNIT_BOM,
                                'Penerimaan_Unit' => $Boms11->unit,
                                'Penerimaan_Quantity' => $Boms11->HARGA,
                                'Penerimaan_Price' => $Boms11->JUMLAH,
                                'Pengiriman_Unit' => $Boms11->unit
                            ]);
                    }
                }
                // penerimaan penerima
                $penerimaan2 = Convertpenerimaan::select(
                    'convertpenerimaans.TANGGAL',
                    'convertpenerimaans.PENERIMA',
                    'convertpenerimaans.NAMAPENERIMA',
                    'convertpenerimaans.KODE_BARANG_SAGE',
                    'convertpenerimaans.KODE_DESKRIPSI_BARANG_SAGE',
                    'convertpenerimaans.STOKING_UNIT_BOM',
                    Convertpenerimaan::raw('sum(convertpenerimaans.QUANTITY) as unit'),
                    'convertpenerimaans.HARGA',
                    'convertpenerimaans.JUMLAH',
                )->groupBy('convertpenerimaans.TANGGAL', 'convertpenerimaans.PENERIMA', 'convertpenerimaans.KODE_BARANG_SAGE')->get();

                foreach ($penerimaan2 as $Boms112) {
                    $temp = Laporan::where('TANGGAL', $Boms112->TANGGAL)->where('KODE', $Boms112->PENERIMA)->where('KODE_BARANG_SAGE', $Boms112->KODE_BARANG_SAGE)
                        ->update([
                            'Penerimaan_Unit' => $Boms112->unit, 'Penerimaan_Quantity' => $Boms112->HARGA,
                            'Penerimaan_Price' => $Boms112->JUMLAH
                        ]);
                    if ($temp) {
                        continue;
                    } else {
                        Laporan::create([
                            'TANGGAL' => $Boms112->TANGGAL,
                            'KODE' => $Boms112->PENERIMA,
                            'NAMA' => $Boms112->NAMAPENERIMA,
                            'KODE_BARANG_SAGE' => $Boms112->KODE_BARANG_SAGE,
                            'KODE_DESKRIPSI_BARANG_SAGE' => $Boms112->KODE_DESKRIPSI_BARANG_SAGE,
                            'STOKING_UNIT_BOM' => $Boms112->STOKING_UNIT_BOM,
                            'Penerimaan_Unit' => $Boms112->unit,
                            'Penerimaan_Quantity' => $Boms112->HARGA,
                            'Penerimaan_Price' => $Boms112->JUMLAH,
                        ]);
                    }
                }


                //pembelian
                $pembelian = Convertpembelian::get();

                foreach ($pembelian as $pembelians) {
                    $temp = Laporan::where('TANGGAL', $pembelians->TANGGAL)->where('KODE', $pembelians->KODE)->where('KODE_BARANG_SAGE', $pembelians->KODE_BARANG_SAGE)
                        ->update([
                            'Pembelian_Unit' => $pembelians->QUANTITY, 'Pembelian_Quantity' => $pembelians->HARGA,
                            'Pembelian_Price' => $pembelians->JUMLAH
                        ]);
                    if ($temp) {
                        continue;
                    } else {
                        Laporan::where('TANGGAL', '!=', $pembelians->TANGGAL)->Where('KODE', '!=', $pembelians->KODE)->Where('KODE_BARANG_SAGE', '!=', $pembelians->KODE_BARANG_SAGE)->create([
                            'TANGGAL' => $pembelians->TANGGAL,
                            'KODE' => $pembelians->KODE,
                            'NAMA' => $pembelians->NAMA,
                            'KODE_BARANG_SAGE' => $pembelians->KODE_BARANG_SAGE,
                            'KODE_DESKRIPSI_BARANG_SAGE' => $pembelians->KODE_DESKRIPSI_BARANG_SAGE,
                            'STOKING_UNIT_BOM' => $pembelians->STOKING_UNIT_BOM,
                            'Pembelian_Unit' => $pembelians->QUANTITY,
                            'Pembelian_Quantity' => $pembelians->HARGA,
                            'Pembelian_Price' => $pembelians->JUMLAH,
                        ]);
                    }
                }

                //bom
                $bomconvert = Convertbom::select(
                    'convertboms.TANGGAL',
                    'convertboms.KODE',
                    'convertboms.NAMA',
                    'convertboms.KODE_BARANG_SAGE',
                    'convertboms.KODE_DESKRIPSI_BARANG_SAGE',
                    'convertboms.STOKING_UNIT_BOM',
                    Convertpenerimaan::raw('sum(convertboms.QUANTITY) as unit'),
                )->groupBy('convertboms.TANGGAL', 'convertboms.KODE', 'convertboms.KODE_BARANG_SAGE')->get();

                foreach ($bomconvert as $Bomsconvert1132) {
                    $temp = Laporan::where('TANGGAL', $Bomsconvert1132->TANGGAL)->where('KODE', $Bomsconvert1132->KODE)->where('KODE_BARANG_SAGE', $Bomsconvert1132->KODE_BARANG_SAGE)
                        ->update([
                            'Bom_Unit' => $Bomsconvert1132->unit
                        ]);
                    if ($temp) {
                        continue;
                    } else {
                        Laporan::create([
                            'TANGGAL' => $Bomsconvert1132->TANGGAL,
                            'KODE' => $Bomsconvert1132->KODE,
                            'NAMA' => $Bomsconvert1132->NAMA,
                            'KODE_BARANG_SAGE' => $Bomsconvert1132->KODE_BARANG_SAGE,
                            'KODE_DESKRIPSI_BARANG_SAGE' => $Bomsconvert1132->KODE_DESKRIPSI_BARANG_SAGE,
                            'STOKING_UNIT_BOM' => $Bomsconvert1132->STOKING_UNIT_BOM,
                            'Bom_Unit' => $Bomsconvert1132->unit,
                        ]);
                    }
                }

                $saldoawallaporan = Laporan::get();
                foreach ($saldoawallaporan as $saldoawallaporans) {
                    Saldoawal::create([
                        'KODE' => $saldoawallaporans->KODE,
                        'NAMA' => $saldoawallaporans->NAMA,
                        'KODE_BARANG_SAGE' => $saldoawallaporans->KODE_BARANG_SAGE,
                        'KODE_DESKRIPSI_BARANG_SAGE' => $saldoawallaporans->KODE_DESKRIPSI_BARANG_SAGE,
                        'STOKING_UNIT_BOM' => $saldoawallaporans->STOKING_UNIT_BOM,
                        'SAwalUnit' => 0,
                        'SAwalQuantity' => 0,
                        'SAwalPrice' => 0
                    ]);
                }

                //Transin Trans OUT SALDO AKHIR
                $laporansdatates = Laporan::orderBy('TANGGAL', 'ASC')->get();
                foreach ($laporansdatates as $Laporandata1s) {
                    Laporan::Where('laporans.TANGGAL', $Laporandata1s->TANGGAL)->where('laporans.KODE', $Laporandata1s->KODE)->where('laporans.KODE_BARANG_SAGE', $Laporandata1s->KODE_BARANG_SAGE)
                        ->join('saldoawals', function ($join) {
                            $join->on(
                                'saldoawals.KODE',
                                '=',
                                'laporans.KODE'
                            )->on(
                                'saldoawals.KODE_BARANG_SAGE',
                                '=',
                                'laporans.KODE_BARANG_SAGE'
                            );
                        })->update([

                            // saldo awal bikin tabel baru yang isi nya kode, kode sage dll gapake tanggal, isinya di update terus sesuai saldo akhir
                            // pake join sebelum update nya pake tabel yang baru

                            'laporans.SAwalUnit' => Laporan::raw('saldoawals.SAwalUnit'),
                            'laporans.SAwalQuantity' => Laporan::raw('saldoawals.SAwalQuantity'),
                            'laporans.SAwalPrice' => Laporan::raw('saldoawals.SAwalPrice'),

                            'laporans.TransferIn_Unit' => $Laporandata1s->SAwalUnit + $Laporandata1s->Pembelian_Unit + $Laporandata1s->Penerimaan_Unit,
                            'laporans.TransferIn_Price' => $Laporandata1s->SAwalPrice + $Laporandata1s->Pembelian_Price + $Laporandata1s->Penerimaan_Price,
                            'laporans.TransferIn_Quantity' => ($Laporandata1s->SAwalPrice + $Laporandata1s->Pembelian_Price + $Laporandata1s->Penerimaan_Price) / ($Laporandata1s->SAwalUnit + $Laporandata1s->Pembelian_Unit + $Laporandata1s->Penerimaan_Unit),

                            'laporans.Pengiriman_Quantity' => ($Laporandata1s->SAwalPrice + $Laporandata1s->Pembelian_Price + $Laporandata1s->Penerimaan_Price) / ($Laporandata1s->SAwalUnit + $Laporandata1s->Pembelian_Unit + $Laporandata1s->Penerimaan_Unit),
                            'laporans.Pengiriman_Price' => (($Laporandata1s->SAwalPrice + $Laporandata1s->Pembelian_Price + $Laporandata1s->Penerimaan_Price) / ($Laporandata1s->SAwalUnit + $Laporandata1s->Pembelian_Unit + $Laporandata1s->Penerimaan_Unit)) *  $Laporandata1s->Pengiriman_Unit,

                            'laporans.Bom_Quantity' => ($Laporandata1s->SAwalPrice + $Laporandata1s->Pembelian_Price + $Laporandata1s->Penerimaan_Price) / ($Laporandata1s->SAwalUnit + $Laporandata1s->Pembelian_Unit + $Laporandata1s->Penerimaan_Unit),
                            'laporans.Bom_Price' => (($Laporandata1s->SAwalPrice + $Laporandata1s->Pembelian_Price + $Laporandata1s->Penerimaan_Price) / ($Laporandata1s->SAwalUnit + $Laporandata1s->Pembelian_Unit + $Laporandata1s->Penerimaan_Unit)) *  $Laporandata1s->Bom_Unit,

                            'laporans.TransferOut_Unit' => $Laporandata1s->Pengiriman_Unit + $Laporandata1s->Bom_Unit,
                            'laporans.TransferOut_Quantity' => ($Laporandata1s->SAwalPrice + $Laporandata1s->Pembelian_Price + $Laporandata1s->Penerimaan_Price) / ($Laporandata1s->SAwalUnit + $Laporandata1s->Pembelian_Unit + $Laporandata1s->Penerimaan_Unit),
                            'laporans.TransferOut_Price' => (($Laporandata1s->SAwalPrice + $Laporandata1s->Pembelian_Price + $Laporandata1s->Penerimaan_Price) / ($Laporandata1s->SAwalUnit + $Laporandata1s->Pembelian_Unit + $Laporandata1s->Penerimaan_Unit)) * ($Laporandata1s->Pengiriman_Unit + $Laporandata1s->Bom_Unit),

                            'laporans.SAkhirUnit' => ($Laporandata1s->SAwalUnit + $Laporandata1s->Pembelian_Unit + $Laporandata1s->Penerimaan_Unit) - ($Laporandata1s->Pengiriman_Unit + $Laporandata1s->Bom_Unit),
                            'laporans.SAkhirQuantity' => ($Laporandata1s->SAwalPrice + $Laporandata1s->Pembelian_Price + $Laporandata1s->Penerimaan_Price) / ($Laporandata1s->SAwalUnit + $Laporandata1s->Pembelian_Unit + $Laporandata1s->Penerimaan_Unit),
                            'laporans.SAkhirPrice' => (($Laporandata1s->SAwalPrice + $Laporandata1s->Pembelian_Price + $Laporandata1s->Penerimaan_Price) / ($Laporandata1s->SAwalUnit + $Laporandata1s->Pembelian_Unit + $Laporandata1s->Penerimaan_Unit)) * (($Laporandata1s->SAwalUnit + $Laporandata1s->Pembelian_Unit + $Laporandata1s->Penerimaan_Unit) - ($Laporandata1s->Pengiriman_Unit + $Laporandata1s->Bom_Unit)),

                            'saldoawals.SAwalUnit' => ($Laporandata1s->SAwalUnit + $Laporandata1s->Pembelian_Unit + $Laporandata1s->Penerimaan_Unit) - ($Laporandata1s->Pengiriman_Unit + $Laporandata1s->Bom_Unit),
                            'saldoawals.SAwalQuantity' => ($Laporandata1s->SAwalPrice + $Laporandata1s->Pembelian_Price + $Laporandata1s->Penerimaan_Price) / ($Laporandata1s->SAwalUnit + $Laporandata1s->Pembelian_Unit + $Laporandata1s->Penerimaan_Unit),
                            'saldoawals.SAwalPrice' => (($Laporandata1s->SAwalPrice + $Laporandata1s->Pembelian_Price + $Laporandata1s->Penerimaan_Price) / ($Laporandata1s->SAwalUnit + $Laporandata1s->Pembelian_Unit + $Laporandata1s->Penerimaan_Unit)) * (($Laporandata1s->SAwalUnit + $Laporandata1s->Pembelian_Unit + $Laporandata1s->Penerimaan_Unit) - ($Laporandata1s->Pengiriman_Unit + $Laporandata1s->Bom_Unit)),

                        ]);
                }

                public function LaporanTanggal(Request $request)
            {
                if (Auth::check()) {
                    // menangkap data pencarian
                    $date = $request->date;
                    // Convertdprbom
                    Laporanakhir::truncate();

                    // SELECT `KODE`,`NAMA`,`KODE_BARANG_SAGE`,`KODE_DESKRIPSI_BARANG_SAGE`,sum(Pembelian_Unit),sum(Penerimaan_Unit),sum(Pengiriman_Unit),sum(Bom_Unit) FROM `laporans` WHERE `TANGGAL` < '2023-01-05' GROUP BY `KODE`,`KODE_BARANG_SAGE`;
                    // select menentukan saldo awal
                    $LaporanSaldoAwal = Laporan::select(
                        'KODE',
                        'NAMA',
                        'KODE_BARANG_SAGE',
                        'KODE_DESKRIPSI_BARANG_SAGE',
                        'STOKING_UNIT_BOM',
                        Laporan::raw('sum(Pembelian_Unit)as Pemunit'),
                        Laporan::raw('sum(Pembelian_Price)as Pemprice'),

                        Laporan::raw('sum(Penerimaan_Unit)as Peneunit'),
                        Laporan::raw('sum(Penerimaan_Unit) * Pembelian_Quantity as Peneprice'),

                        Laporan::raw('sum(Pengiriman_Unit)as pengiunit'),

                        Laporan::raw('sum(Bom_Unit)as Bomunit'),

                    )->groupBy('KODE', 'KODE_BARANG_SAGE')->whereDate('TANGGAL', '<', $date)->get();

                    // memasukan nilai saldo awal
                    foreach ($LaporanSaldoAwal as $LaporanSaldoAwals) {
                        Laporanakhir::create([
                            'KODE' => $LaporanSaldoAwals->KODE,
                            'NAMA' => $LaporanSaldoAwals->NAMA,
                            'KODE_BARANG_SAGE' => $LaporanSaldoAwals->KODE_BARANG_SAGE,
                            'KODE_DESKRIPSI_BARANG_SAGE' => $LaporanSaldoAwals->KODE_DESKRIPSI_BARANG_SAGE,
                            'STOKING_UNIT_BOM' => $LaporanSaldoAwals->STOKING_UNIT_BOM,

                            'SAkhirUnit' => $LaporanSaldoAwals->Pemunit + $LaporanSaldoAwals->Peneunit,
                            'SAkhirPrice' => $LaporanSaldoAwals->Pemprice + $LaporanSaldoAwals->Peneprice,

                            'SAkhirQuantity' => Laporanakhir::raw('IFNULL(SAkhirPrice / NULLIF( SAkhirUnit, 0 ), 0)  '),

                            'Pengiriman_Price' => $LaporanSaldoAwals->pengiunit,
                            'Bom_Price' => $LaporanSaldoAwals->Bomunit,

                            'SAwalUnit' => ($LaporanSaldoAwals->Pemunit + $LaporanSaldoAwals->Peneunit) - ($LaporanSaldoAwals->pengiunit + $LaporanSaldoAwals->Bomunit),
                            'SAwalPrice' => Laporanakhir::raw('SAkhirPrice - ((SAkhirQuantity * IFNULL( Pengiriman_Price, 0 )) +( SAkhirQuantity * IFNULL( Bom_Price, 0 )))'),
                            'SAwalQuantity' => Laporanakhir::raw('IFNULL(SAwalPrice / NULLIF( SAwalUnit, 0 ), 0)')

                        ]);
                    }

                    $UpdateBiayaLaporan1 = Laporanakhir::get();

                    foreach ($UpdateBiayaLaporan1 as $LaporanSaldoAwals123) {
                        Laporanakhir::where('KODE', '<>', 7301)->where('KODE', '<>', 7302)
                            ->where('KODE', '<', 9000)
                            ->where(Laporanakhir::raw('LEFT(KODE_BARANG_SAGE,2)'), '<>', '12')
                            ->where(Laporanakhir::raw('LEFT(KODE_BARANG_SAGE,2)'), '<>', '11')
                            ->update([

                                'SAwalUnit' => Laporanakhir::raw('(SAkhirUnit -(Pengiriman_Price + Bom_Price)) - SAkhirUnit'),
                                'SAwalPrice' => Laporanakhir::raw('(SAkhirPrice - ((SAkhirQuantity * IFNULL( Pengiriman_Price, 0 )) +( SAkhirQuantity * IFNULL( Bom_Price, 0 )))) - SAkhirPrice'),
                                'SAwalQuantity' => Laporanakhir::raw('IFNULL(SAwalPrice / NULLIF( SAwalUnit, 0 ), 0)')

                            ]);
                    }

                    $LaporanSaldoAwalupdate = Laporanakhir::get();

                    foreach ($LaporanSaldoAwalupdate as $LaporanSaldoAwals) {
                        Laporanakhir::where('KODE', $LaporanSaldoAwals->KODE)->where('KODE_BARANG_SAGE', $LaporanSaldoAwals->KODE_BARANG_SAGE)
                            ->update([
                                'Pembelian_Unit' => 0,
                                'Pembelian_Quantity' => 0,
                                'Pembelian_Price' => 0,

                                'Penerimaan_Unit' => 0,
                                'Penerimaan_Quantity' => 0,
                                'Penerimaan_Price' => 0,

                                'TransferIn_Unit' => $LaporanSaldoAwals->SAwalUnit,
                                'TransferIn_Price' => $LaporanSaldoAwals->SAwalPrice,
                                'TransferIn_Quantity' => $LaporanSaldoAwals->SAwalQuantity,

                                'Pengiriman_Price' => 0,
                                'Bom_Price' => 0,

                                'TransferOut_Quantity' => 0,
                                'TransferOut_Price' => 0,

                                'SAkhirUnit' => $LaporanSaldoAwals->SAwalUnit,
                                'SAkhirQuantity' => $LaporanSaldoAwals->SAwalQuantity,
                                'SAkhirPrice' => $LaporanSaldoAwals->SAwalPrice
                            ]);
                    }
                    $LaporanSaldoAkhir = Laporan::select(
                        'KODE',
                        'NAMA',
                        'KODE_BARANG_SAGE',
                        'KODE_DESKRIPSI_BARANG_SAGE',
                        'STOKING_UNIT_BOM',

                        Laporan::raw('sum(Pembelian_Unit)as Pemunit'),
                        Laporan::raw('sum(Pembelian_Price)as Pemprice'),

                        Laporan::raw('sum(Penerimaan_Unit)as Peneunit'),
                        Laporan::raw('sum(Penerimaan_Unit) * Pembelian_Quantity as Peneprice'),

                        Laporan::raw('sum(Pengiriman_Unit)as pengiunit'),

                        Laporan::raw('sum(Bom_Unit)as Bomunit'),

                    )->groupBy('KODE', 'KODE_BARANG_SAGE')->whereDate('TANGGAL', '=', $date)->get();

                    foreach ($LaporanSaldoAkhir as $LaporanSaldoAkhirs) {

                        $temp = Laporanakhir::where('KODE', $LaporanSaldoAkhirs->KODE)->where('KODE_BARANG_SAGE', $LaporanSaldoAkhirs->KODE_BARANG_SAGE)
                            ->update([


                                'Pembelian_Unit' => $LaporanSaldoAkhirs->Pemunit,
                                'Pembelian_Price' => $LaporanSaldoAkhirs->Pemprice,
                                'Pembelian_Quantity' => Laporanakhir::raw(' IFNULL(Pembelian_Price / NULLIF( Pembelian_Unit, 0 ), 0)'),

                                'Penerimaan_Unit' => $LaporanSaldoAkhirs->Peneunit,
                                'Penerimaan_Price' => $LaporanSaldoAkhirs->Peneprice,
                                'Penerimaan_Quantity' => Laporanakhir::raw(' IFNULL(Penerimaan_Price / NULLIF( Penerimaan_Unit, 0 ), 0)'),


                                'TransferIn_Unit' => Laporanakhir::raw('IFNULL(SAwalUnit, 0)+ IFNULL(Pembelian_Unit, 0) +IFNULL(Penerimaan_Unit, 0)'),
                                'TransferIn_Price' => Laporanakhir::raw('IFNULL(SAwalPrice, 0)+ IFNULL(Pembelian_Price, 0) +IFNULL(Penerimaan_Price, 0)'),
                                'TransferIn_Quantity' => Laporanakhir::raw(' IFNULL(TransferIn_Price / NULLIF( TransferIn_Unit, 0 ), 0)'),


                                'Pengiriman_Unit' => $LaporanSaldoAkhirs->pengiunit,
                                'Pengiriman_Quantity' => Laporanakhir::raw('IF(Pengiriman_Unit IS NULL, 0, TransferIn_Quantity)'),
                                'Pengiriman_Price' => Laporanakhir::raw('IFNULL(TransferIn_Quantity, 0) * IFNULL(Pengiriman_Unit, 0)'),


                                'Bom_Unit' => $LaporanSaldoAkhirs->Bomunit,
                                'Bom_Quantity' => Laporanakhir::raw('IF(Bom_Unit IS NULL, 0, TransferIn_Quantity)'),
                                'Bom_Price' => Laporanakhir::raw('IFNULL(TransferIn_Quantity, 0) * IFNULL(Bom_Unit, 0)'),


                                'TransferOut_Unit' => $LaporanSaldoAkhirs->pengiunit + $LaporanSaldoAkhirs->Bomunit,
                                'TransferOut_Quantity' => Laporanakhir::raw('IF(TransferOut_Unit IS NULL, 0, TransferIn_Quantity) '),
                                'TransferOut_Price' => Laporanakhir::raw('IFNULL(TransferIn_Quantity, 0) *IFNULL(TransferOut_Unit, 0)'),

                                'SAkhirUnit' => Laporanakhir::raw('IFNULL(TransferIn_Unit, 0) - IFNULL(TransferOut_Unit, 0)  '),
                                'SAkhirQuantity' => Laporanakhir::raw('TransferIn_Quantity'),
                                'SAkhirPrice' => Laporanakhir::raw('TransferIn_Quantity * SAkhirUnit')

                            ]);
                        if ($temp) {
                            continue;
                        } else {
                            Laporanakhir::create([
                                'KODE' => $LaporanSaldoAkhirs->KODE,
                                'NAMA' => $LaporanSaldoAkhirs->NAMA,
                                'KODE_BARANG_SAGE' => $LaporanSaldoAkhirs->KODE_BARANG_SAGE,
                                'KODE_DESKRIPSI_BARANG_SAGE' => $LaporanSaldoAkhirs->KODE_DESKRIPSI_BARANG_SAGE,
                                'STOKING_UNIT_BOM' => $LaporanSaldoAkhirs->STOKING_UNIT_BOM,

                                'Pembelian_Unit' => $LaporanSaldoAkhirs->Pemunit,
                                'Pembelian_Price' => $LaporanSaldoAkhirs->Pemprice,
                                'Pembelian_Quantity' => Laporanakhir::raw(' IFNULL(Pembelian_Price / NULLIF( Pembelian_Unit, 0 ), 0)'),

                                'Penerimaan_Unit' => $LaporanSaldoAkhirs->Peneunit,
                                'Penerimaan_Price' => $LaporanSaldoAkhirs->Peneprice,
                                'Penerimaan_Quantity' => Laporanakhir::raw(' IFNULL(Penerimaan_Price / NULLIF( Penerimaan_Unit, 0 ), 0)'),

                                'TransferIn_Unit' => Laporanakhir::raw('IFNULL(SAwalUnit, 0)+ IFNULL(Pembelian_Unit, 0) +IFNULL(Penerimaan_Unit, 0)'),
                                'TransferIn_Price' => Laporanakhir::raw('IFNULL(SAwalPrice, 0)+ IFNULL(Pembelian_Price, 0) +IFNULL(Penerimaan_Price, 0)'),
                                'TransferIn_Quantity' => Laporanakhir::raw(' IFNULL(TransferIn_Price / NULLIF( TransferIn_Unit, 0 ), 0)'),

                                'Pengiriman_Unit' => $LaporanSaldoAkhirs->pengiunit,
                                'Pengiriman_Quantity' => Laporanakhir::raw(' IF(Pengiriman_Unit IS NULL, 0, TransferIn_Quantity)'),
                                'Pengiriman_Price' => Laporanakhir::raw('IFNULL(TransferIn_Quantity, 0) * IFNULL(Pengiriman_Unit, 0)'),

                                'Bom_Unit' => $LaporanSaldoAkhirs->Bomunit,
                                'Bom_Quantity' => Laporanakhir::raw('IF(Bom_Unit IS NULL, 0, TransferIn_Quantity)'),
                                'Bom_Price' => Laporanakhir::raw('IFNULL(TransferIn_Quantity, 0) * IFNULL(Bom_Unit, 0)'),


                                'TransferOut_Unit' => $LaporanSaldoAkhirs->pengiunit + $LaporanSaldoAkhirs->Bomunit,
                                'TransferOut_Quantity' => Laporanakhir::raw(' IF(TransferOut_Unit IS NULL, 0, TransferIn_Quantity)'),
                                'TransferOut_Price' => Laporanakhir::raw('IFNULL(TransferIn_Quantity, 0) *IFNULL(TransferOut_Unit, 0)'),


                                'SAkhirUnit' => Laporanakhir::raw('IFNULL(TransferIn_Unit, 0) - IFNULL(TransferOut_Unit, 0)  '),
                                'SAkhirQuantity' => Laporanakhir::raw(' IFNULL(TransferIn_Price / NULLIF( TransferIn_Unit, 0 ), 0)'),
                                'SAkhirPrice' => Laporanakhir::raw('TransferIn_Quantity * SAkhirUnit')



                            ]);
                        }
                    }


                    $UpdateBiayaLaporan = Laporanakhir::get();

                    foreach ($UpdateBiayaLaporan as $LaporanSaldoAwals) {
                        Laporanakhir::where('KODE', '<>', 7301)->where('KODE', '<>', 7302)
                            ->where('KODE', '<', 9000)
                            ->where(Laporanakhir::raw('LEFT(KODE_BARANG_SAGE,2)'), '<>', '12')
                            ->where(Laporanakhir::raw('LEFT(KODE_BARANG_SAGE,2)'), '<>', '11')
                            ->update([

                                'BiayaUnit' => Laporanakhir::raw('IFNULL(TransferIn_Unit, 0)'),
                                'BiayaQuantity' => Laporanakhir::raw('IFNULL(TransferIn_Quantity, 0)'),
                                'BiayaPrice' => Laporanakhir::raw('IFNULL(TransferIn_Price, 0)'),

                                'SAkhirUnit' => Laporanakhir::raw('(TransferIn_Unit - TransferOut_Unit) - TransferIn_Unit '),
                                'SAkhirQuantity' => Laporanakhir::raw('TransferIn_Quantity '),
                                'SAkhirPrice' => Laporanakhir::raw('SAkhirUnit*TransferIn_Quantity')
                            ]);
                    }

                    $UpdateLaporanharian = Laporanakhir::get();
                    foreach ($UpdateLaporanharian as $UpdateLaporanharians) {
                        Laporanakhir::whereDate('TANGGAL', '=', $date)->where('KODE', $UpdateLaporanharians->KODE)->where('KODE_BARANG_SAGE', $UpdateLaporanharians->KODE_BARANG_SAGE)
                            ->update([

                                'SAwalUnit' => $UpdateLaporanharians->SAwalUnit,
                                'SAwalPrice' => $UpdateLaporanharians->SAwalPrice,
                                'SAwalQuantity' => $UpdateLaporanharians->SAwalQuantity,

                                'TransferIn_Unit' => $UpdateLaporanharians->TransferIn_Unit,
                                'TransferIn_Price' => $UpdateLaporanharians->TransferIn_Price,
                                'TransferIn_Quantity' => $UpdateLaporanharians->TransferIn_Quantity,

                                'SAkhirUnit' => $UpdateLaporanharians->SAkhirUnit,
                                'SAkhirQuantity' => $UpdateLaporanharians->SAkhirQuantity,
                                'SAkhirPrice' => $UpdateLaporanharians->SAkhirPrice
                            ]);
                    }

                    $laporanakhirview = Laporanakhir::get();
                    return view('Laporans', compact('laporanakhirview'));
                }
    */
}
