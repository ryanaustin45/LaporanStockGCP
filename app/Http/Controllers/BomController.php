<?php

namespace App\Http\Controllers;

use App\Exports\BomsExport;
use App\Exports\Laporanhpps;
use App\Models\Bom;
use App\Models\Item;
use App\Models\Laporan;
use App\Models\Laporanakhir;
use App\Models\Dprbom;
use App\Models\Dprrckbom;
use App\Models\Laporanhpp;
use App\Models\Penjualan;
use App\Models\Convertbom;
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

            $laporanakhirview = Laporanakhir::get();
            return view('Laporans', compact('laporanakhirview'));
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



    public function Laporanhppstanggal(Request $request)
    {
        if (Auth::check()) {
            // menangkap data pencarian
            $Tanggal = $request->date;

            Laporanhpp::truncate();
            Convertbom::truncate();

            /*

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

                */

            $Boms23 =  Penjualan::select(
                'penjualans.TANGGAL',
                'penjualans.KODE_OUTLET',
                'penjualans.Outlet',
                'penjualans.KODE_BARANG',
                'penjualans.Barang',
                'penjualans.Banyak',
                'penjualans.Jumlah'
            )->whereDate('TANGGAL', '=', $Tanggal)->get();

            foreach ($Boms23 as $Boms23s) {
                if ($Boms23s->Banyak != 0) {
                    Laporanhpp::create([
                        'TANGGAL' => $Boms23s->TANGGAL,
                        'KODE_OUTLET' => $Boms23s->KODE_OUTLET,
                        'Outlet' => $Boms23s->Outlet,
                        'KODE_BARANG' => $Boms23s->KODE_BARANG,
                        'Barang' => $Boms23s->Barang,
                        'Banyak' => $Boms23s->Banyak,
                        'Jumlah' => $Boms23s->Jumlah,
                        'Revenue' => $Boms23s->Jumlah / 1.1
                    ]);
                }
            }

            /*memasukan nilai harga pada bahan baku bom dapur racik dari pembelian */
            $Boms1 = Laporanhpp::join('boms', function ($join) {
                $join->on(
                    Laporanhpp::raw('RIGHT(boms.KODE_BARANG,13)'),
                    '=',
                    'laporanhpps.KODE_BARANG'
                )->on(
                    Laporanhpp::raw('LEFT(boms.KODE_BARANG,4)'),
                    '=',
                    'laporanhpps.KODE_OUTLET'
                );
            })->select(
                'laporanhpps.TANGGAL',
                'laporanhpps.KODE_OUTLET',
                'laporanhpps.Outlet',
                'boms.NAMA_BAHAN',
                'boms.NAMA_BARANG',
                'boms.SATUAN_BAHAN',
                Laporanhpp::raw('laporanhpps.Banyak *boms.BANYAK as quantit2y ')
            )->get();

            foreach ($Boms1 as $Boms11) {
                $temp = Convertbom::where('KODE_BARANG_SAGE', $Boms11->NAMA_BAHAN)
                    ->where('KODE_DESKRIPSI_BARANG_SAGE', $Boms11->NAMA_BARANG)
                    ->update([
                        'JUMLAH' => 0 + 0
                    ]);
                if ($temp) {
                    continue;
                } else {
                    Convertbom::create([
                        'TANGGAL' => $Boms11->TANGGAL,
                        'KODE' => $Boms11->KODE_OUTLET,
                        'NAMA' => $Boms11->Outlet,
                        'KODE_BARANG_SAGE' => $Boms11->NAMA_BAHAN,
                        'KODE_DESKRIPSI_BARANG_SAGE' => $Boms11->NAMA_BARANG,
                        'STOKING_UNIT_BOM' => $Boms11->SATUAN_BAHAN,
                        'QUANTITY' => $Boms11->quantit2y,
                        'HARGA' => 0,
                        'JUMLAH' => 0
                    ]);
                }
            }

            $bom1234 = Convertbom::join('items', 'items.KODE_DESKRIPSI_BARANG_SAGE', '=', 'convertboms.KODE_BARANG_SAGE')
                ->select(
                    'convertboms.KODE_BARANG_SAGE',
                    Convertbom::raw('convertboms.QUANTITY * items.Harga as harga22 ')
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

            $Bomslaporanhpp = Laporanhpp::join('convertboms', 'convertboms.KODE_DESKRIPSI_BARANG_SAGE', '=', 'laporanhpps.Barang')
                ->select(
                    'laporanhpps.Barang',
                    'laporanhpps.Banyak',
                    'laporanhpps.Jumlah',
                    'convertboms.JUMLAH as jumlah21'
                )->get();

            foreach ($Bomslaporanhpp as $Bomslaporanhpps) {
                Laporanhpp::where('Barang', $Bomslaporanhpps->Barang)->update([
                    'COGS' => $Bomslaporanhpps->jumlah21,
                    'Profit' => ($Bomslaporanhpps->Jumlah  / 1.1) - $Bomslaporanhpps->jumlah21,
                    'Margin' => ((($Bomslaporanhpps->Jumlah / 1.1) - $Bomslaporanhpps->jumlah21) / ($Bomslaporanhpps->Jumlah  / 1.1)) * 100
                ]);
            }


            $penjualanss = Laporanhpp::get();
            return view('Laporanhpps', compact('penjualanss'));
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
    */
}
