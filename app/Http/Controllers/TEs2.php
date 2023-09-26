public function LaporanTanggal(Request $request)
{
if (Auth::check()) {
// menangkap data pencarian
$date = $request->date;
// Convertdprbom
Laporanakhir::truncate();

// SELECT `KODE`,`NAMA`,`KODE_BARANG_SAGE`,`KODE_DESKRIPSI_BARANG_SAGE`,sum(Pembelian_Unit),sum(Penerimaan_Unit),sum(Pengiriman_Unit),sum(Bom_Unit) FROM `laporans` WHERE `TANGGAL` < '2023-01-05' GROUP BY `KODE`,`KODE_BARANG_SAGE`; // select menentukan saldo awal $LaporanSaldoAwal=Laporan::whereDate('TANGGAL', '<' , $date)->select(
    'KODE',
    'NAMA',
    'KODE_BARANG_SAGE',
    'KODE_DESKRIPSI_BARANG_SAGE',
    'STOKING_UNIT_BOM',
    Laporan::raw('sum(Pembelian_Unit)as Pemunit'),

    Laporan::raw('sum(Penerimaan_Unit)as Peneunit'),

    Laporan::raw('sum(Pengiriman_Unit)as pengiunit'),

    Laporan::raw('sum(Bom_Unit)as Bomunit'),

    )->groupBy('KODE', 'KODE_BARANG_SAGE')->get();

    // memasukan nilai saldo awal
    foreach ($LaporanSaldoAwal as $LaporanSaldoAwals) {
    Laporanakhir::create([
    'KODE' => $LaporanSaldoAwals->KODE,
    'NAMA' => $LaporanSaldoAwals->NAMA,
    'KODE_BARANG_SAGE' => $LaporanSaldoAwals->KODE_BARANG_SAGE,
    'KODE_DESKRIPSI_BARANG_SAGE' => $LaporanSaldoAwals->KODE_DESKRIPSI_BARANG_SAGE,
    'STOKING_UNIT_BOM' => $LaporanSaldoAwals->STOKING_UNIT_BOM,

    'SAwalUnit' => ($LaporanSaldoAwals->Pemunit + $LaporanSaldoAwals->Peneunit) - ($LaporanSaldoAwals->pengiunit + $LaporanSaldoAwals->Bomunit)

    ]);
    Laporanakhir::where('KODE', '<>', 7301)->where('KODE', '<>', 7302)
            ->where('KODE', '<', 9000) ->where(Laporanakhir::raw('LEFT(KODE_BARANG_SAGE,2)'), '<>', '12')
                    ->where(Laporanakhir::raw('LEFT(KODE_BARANG_SAGE,2)'), '<>', '11')
                        ->update([

                        'SAwalUnit' => (($LaporanSaldoAwals->Pemunit + $LaporanSaldoAwals->Peneunit) - ($LaporanSaldoAwals->pengiunit + $LaporanSaldoAwals->Bomunit)) - ($LaporanSaldoAwals->Pemunit + $LaporanSaldoAwals->Peneunit)

                        ]);
                        }


                        $LaporanSaldoAkhir = Laporan::whereDate('TANGGAL', '=', $date)->select(
                        'KODE',
                        'NAMA',
                        'KODE_BARANG_SAGE',
                        'KODE_DESKRIPSI_BARANG_SAGE',
                        'STOKING_UNIT_BOM',

                        Laporan::raw('sum(Pembelian_Unit)as Pemunit'),
                        Laporan::raw('sum(Pembelian_Price)as Pemprice'),
                        Laporan::raw('IFNULL(sum(Pembelian_Price), 1) / IFNULL(sum(Pembelian_Unit), 1) as sAunit'),
                        Laporan::raw('sum(Penerimaan_Unit)as Peneunit'),

                        Laporan::raw('sum(Pengiriman_Unit)as pengiunit'),

                        Laporan::raw('sum(Bom_Unit)as Bomunit'),

                        )->groupBy('KODE', 'KODE_BARANG_SAGE')->get();

                        foreach ($LaporanSaldoAkhir as $LaporanSaldoAkhirs) {

                        $temp = Laporanakhir::where('KODE', $LaporanSaldoAkhirs->KODE)->where('KODE_BARANG_SAGE', $LaporanSaldoAkhirs->KODE_BARANG_SAGE)
                        ->update([
                        'Pembelian_Unit' => $LaporanSaldoAkhirs->Pemunit,
                        'Pembelian_Price' => $LaporanSaldoAkhirs->Pemprice,
                        'Pembelian_Quantity' => $LaporanSaldoAkhirs->sAunit,
                        'Penerimaan_Unit' => $LaporanSaldoAkhirs->Peneunit,
                        'TransferIn_Unit' => Laporanakhir::raw('IFNULL(SAwalUnit, 0)+ IFNULL(Pembelian_Unit, 0) +IFNULL(Penerimaan_Unit, 0)'),
                        'Pengiriman_Unit' => $LaporanSaldoAkhirs->pengiunit,
                        'Bom_Unit' => $LaporanSaldoAkhirs->Bomunit,
                        'TransferOut_Unit' => $LaporanSaldoAkhirs->pengiunit + $LaporanSaldoAkhirs->Bomunit,
                        'SAkhirUnit' => Laporanakhir::raw('IFNULL(TransferIn_Unit, 0) - IFNULL(TransferOut_Unit, 0) '),
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
                        'Pembelian_Quantity' => $LaporanSaldoAkhirs->sAunit,
                        'Penerimaan_Unit' => $LaporanSaldoAkhirs->Peneunit,
                        'TransferIn_Unit' => ($LaporanSaldoAwals->Pemunit + $LaporanSaldoAwals->Peneunit),
                        'Pengiriman_Unit' => $LaporanSaldoAkhirs->pengiunit,
                        'Bom_Unit' => $LaporanSaldoAkhirs->Bomunit,
                        'TransferOut_Unit' => $LaporanSaldoAkhirs->pengiunit + $LaporanSaldoAkhirs->Bomunit,
                        'SAkhirUnit' => Laporanakhir::raw('IFNULL(TransferIn_Unit, 0) - IFNULL(TransferOut_Unit, 0) '),
                        ]);

                        Laporanakhir::where('KODE', '<>', 7301)->where('KODE', '<>', 7302)
                                ->where('KODE', '<', 9000) ->where(Laporanakhir::raw('LEFT(KODE_BARANG_SAGE,2)'), '<>', '12')
                                        ->where(Laporanakhir::raw('LEFT(KODE_BARANG_SAGE,2)'), '<>', '11')
                                            ->update([
                                            'BiayaUnit' => Laporanakhir::raw('IFNULL(TransferIn_Unit, 0)'),
                                            'SAkhirUnit' => Laporanakhir::raw('(TransferIn_Unit - TransferOut_Unit) - TransferIn_Unit '),
                                            ]);
                                            }
                                            }

                                            $pembelians1 = Pembelian::where('pembelians.JUMLAH', '<>', null)->where('pembelians.BANYAK', '<>', null)
                                                    ->whereDate('pembelians.TANGGAL', '<=', $date)->orderBy('pembelians.TANGGAL', 'asc')->select(
                                                        'pembelians.TANGGAL',
                                                        'items.KODE_BARANG_SAGE',
                                                        Pembelian::raw('round(pembelians.JUMLAH / ((pembelians.BANYAK * items.RUMUS_Untuk_Purchase) / items.RUMUS_untuk_BOM),2) as QUANTITY'),
                                                        )->join('items', 'pembelians.KD_BRG', '=', 'items.KODE_BARANG_PURCHASING')->groupBy('items.KODE_BARANG_SAGE', 'pembelians.TANGGAL')->get();

                                                        foreach ($pembelians1 as $UpdateLaporanharians2) {
                                                        if ($UpdateLaporanharians2->QUANTITY != null) {
                                                        Laporanakhir::where('KODE_BARANG_SAGE', $UpdateLaporanharians2->KODE_BARANG_SAGE)
                                                        ->update([

                                                        'SAwalQuantity' => $UpdateLaporanharians2->QUANTITY,
                                                        'SAwalPrice' => Laporanakhir::raw('round(round(SAwalUnit,2) * ' . $UpdateLaporanharians2->QUANTITY . ',2) '),

                                                        'Penerimaan_Price' => Laporanakhir::raw('round(round(Penerimaan_Unit,2) * ' . $UpdateLaporanharians2->QUANTITY . ',2) '),
                                                        'TransferIn_Price' => Laporanakhir::raw('round(round(TransferIn_Unit,2) * ' . $UpdateLaporanharians2->QUANTITY . ',2) '),
                                                        'Pengiriman_Price' => Laporanakhir::raw('round(round(Pengiriman_Unit,2) * ' . $UpdateLaporanharians2->QUANTITY . ',2) '),
                                                        'Bom_Price' => Laporanakhir::raw('round(round(Bom_Unit,2) * ' . $UpdateLaporanharians2->QUANTITY . ',2) '),
                                                        'TransferOut_Price' => Laporanakhir::raw('round(round(TransferOut_Unit,2,2) * ' . $UpdateLaporanharians2->QUANTITY . ',2) '),
                                                        'BiayaPrice' => Laporanakhir::raw('round(round(BiayaUnit,2) * ' . $UpdateLaporanharians2->QUANTITY . ',2) '),

                                                        'SAkhirPrice' => Laporanakhir::raw('round(round(SAkhirUnit,2) * ' . $UpdateLaporanharians2->QUANTITY . ',2)')
                                                        ]);
                                                        Dprrckbom::where('dprrckboms.KODE_BAHAN', 'LIKE', '%' . $UpdateLaporanharians2->KODE_BARANG_SAGE . '%')
                                                        ->update([
                                                        'dprrckboms.Harga' => Dprrckbom::raw('round(round(dprrckboms.BANYAK,2) * ' . $UpdateLaporanharians2->QUANTITY . ',2) ')

                                                        ]);
                                                        Dprbom::where('dprboms.KODE_BAHAN', 'LIKE', '%' . $UpdateLaporanharians2->KODE_BARANG_SAGE . '%')
                                                        ->update([
                                                        'dprboms.Harga' => Dprbom::raw('round(round(dprboms.BANYAK,2) *' . $UpdateLaporanharians2->QUANTITY . ',2) ')

                                                        ]);
                                                        }
                                                        }

                                                        $dprrckbomhargabarang = Dprrckbom::select(
                                                        'dprrckboms.KODE_BARANG',
                                                        Dprrckbom::raw('RIGHT(dprrckboms.KODE_BARANG, 11) as kode'),
                                                        Dprrckbom::raw('round(sum(dprrckboms.Harga),2) as QUANTITY')
                                                        )->groupBy('dprrckboms.KODE_BARANG')->get();

                                                        foreach ($dprrckbomhargabarang as $UpdateLaporanharians2) {
                                                        if ($UpdateLaporanharians2->QUANTITY != null) {
                                                        Dprbom::where('dprboms.KODE_BAHAN', 'LIKE', '%' . $UpdateLaporanharians2->kode . '%')->update([
                                                        'dprboms.Harga' => Dprbom::raw('round(round(dprboms.BANYAK,2) *' . $UpdateLaporanharians2->QUANTITY . ',2) ')

                                                        ]);
                                                        Laporanakhir::where('KODE_BARANG_SAGE', $UpdateLaporanharians2->kode)
                                                        ->update([

                                                        'SAwalQuantity' => $UpdateLaporanharians2->QUANTITY,
                                                        'SAwalPrice' => Laporanakhir::raw('round(round(SAwalUnit,2) * ' . $UpdateLaporanharians2->QUANTITY . ',2) '),

                                                        'Penerimaan_Price' => Laporanakhir::raw('round(round(Penerimaan_Unit,2) * ' . $UpdateLaporanharians2->QUANTITY . ',2) '),
                                                        'TransferIn_Price' => Laporanakhir::raw('round(round(TransferIn_Unit,2) * ' . $UpdateLaporanharians2->QUANTITY . ',2) '),
                                                        'Pengiriman_Price' => Laporanakhir::raw('round(round(Pengiriman_Unit,2) * ' . $UpdateLaporanharians2->QUANTITY . ',2) '),
                                                        'Bom_Price' => Laporanakhir::raw('round(round(Bom_Unit,2) * ' . $UpdateLaporanharians2->QUANTITY . ',2) '),
                                                        'TransferOut_Price' => Laporanakhir::raw('round(round(TransferOut_Unit,2,2) * ' . $UpdateLaporanharians2->QUANTITY . ',2) '),
                                                        'BiayaPrice' => Laporanakhir::raw('round(round(BiayaUnit,2) * ' . $UpdateLaporanharians2->QUANTITY . ',2) '),

                                                        'SAkhirPrice' => Laporanakhir::raw('round(round(SAkhirUnit,2) * ' . $UpdateLaporanharians2->QUANTITY . ',2)')

                                                        ]);
                                                        }
                                                        }
                                                        $dprbomhargabarang = Dprbom::select(
                                                        'dprboms.KODE_BARANG',
                                                        Dprbom::raw('RIGHT(dprboms.KODE_BARANG, 11) as kode'),
                                                        Dprbom::raw('round(sum(dprboms.Harga),2) as QUANTITY')
                                                        )->groupBy('dprboms.KODE_BARANG')->get();

                                                        /*memasukan nilai harga pada bahan jadi bom dapur pusat dari penjunmlahan bahan baku dapur pusat */
                                                        foreach ($dprbomhargabarang as $UpdateLaporanharians2) {
                                                        if ($UpdateLaporanharians2->QUANTITY != null) {
                                                        Laporanakhir::where('KODE_BARANG_SAGE', $UpdateLaporanharians2->kode)
                                                        ->update([
                                                        'SAwalQuantity' => $UpdateLaporanharians2->QUANTITY,
                                                        'SAwalPrice' => Laporanakhir::raw('round(round(SAwalUnit,2) * ' . $UpdateLaporanharians2->QUANTITY . ',2) '),

                                                        'Penerimaan_Price' => Laporanakhir::raw('round(round(Penerimaan_Unit,2) * ' . $UpdateLaporanharians2->QUANTITY . ',2) '),
                                                        'TransferIn_Price' => Laporanakhir::raw('round(round(TransferIn_Unit,2) * ' . $UpdateLaporanharians2->QUANTITY . ',2) '),
                                                        'Pengiriman_Price' => Laporanakhir::raw('round(round(Pengiriman_Unit,2) * ' . $UpdateLaporanharians2->QUANTITY . ',2) '),
                                                        'Bom_Price' => Laporanakhir::raw('round(round(Bom_Unit,2) * ' . $UpdateLaporanharians2->QUANTITY . ',2) '),
                                                        'TransferOut_Price' => Laporanakhir::raw('round(round(TransferOut_Unit,2,2) * ' . $UpdateLaporanharians2->QUANTITY . ',2) '),
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

                                                        $Boms23 = Penjualan::whereDate('TANGGAL', '=', $Tanggal)->select(
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

                                                        $pembelians1 = Pembelian::where('pembelians.JUMLAH', '<>', null)->where('pembelians.BANYAK', '<>', null)
                                                                ->whereDate('pembelians.TANGGAL', '<=', $Tanggal)->orderBy('pembelians.TANGGAL', 'asc')->select(
                                                                    'pembelians.TANGGAL',
                                                                    'items.KODE_BARANG_SAGE',
                                                                    Pembelian::raw('round(pembelians.JUMLAH / ((pembelians.BANYAK * items.RUMUS_Untuk_Purchase) / items.RUMUS_untuk_BOM),2) as QUANTITY'),
                                                                    )->join('items', 'pembelians.KD_BRG', '=', 'items.KODE_BARANG_PURCHASING')->groupBy('items.KODE_BARANG_SAGE', 'pembelians.TANGGAL')->get();


                                                                    foreach ($pembelians1 as $items1234s) {
                                                                    if ($items1234s->QUANTITY != null) {
                                                                    Dprrckbom::where('dprrckboms.KODE_BAHAN', 'LIKE', '%' . $items1234s->KODE_BARANG_SAGE . '%')
                                                                    ->update([
                                                                    'dprrckboms.Harga' => Dprrckbom::raw('round(round(dprrckboms.BANYAK,2) * ' . $items1234s->QUANTITY . ',2) ')

                                                                    ]);

                                                                    Dprbom::where('dprboms.KODE_BAHAN', 'LIKE', '%' . $items1234s->KODE_BARANG_SAGE . '%')
                                                                    ->update([
                                                                    'dprboms.Harga' => Dprbom::raw('round(round(dprboms.BANYAK,2) *' . $items1234s->QUANTITY . ',2) ')
                                                                    ]);

                                                                    Bom::where('boms.KODE_BAHAN', 'LIKE', '%' . $items1234s->KODE_BARANG_SAGE . '%')
                                                                    ->update([
                                                                    'boms.Harga' => Bom::raw('round(round(boms.BANYAK,2) * ' . $items1234s->QUANTITY . ',2) ')
                                                                    ]);
                                                                    }
                                                                    }

                                                                    /*memasukan nilai harga pada bahan jadi bom dapur racik dari penjunmlahan bahan baku dapur racik */
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


                                                                    $bomharga123 = Bom::select(
                                                                    'boms.KODE_BARANG',
                                                                    Bom::raw('round(sum(boms.Harga),2) as Harga2'),
                                                                    Bom::raw('RIGHT(boms.KODE_BARANG, 13) as koode'),
                                                                    )->groupBy('boms.KODE_BARANG')->get();

                                                                    /*memasukan nilai harga pada bahan jadi bom dapur pusat dari penjunmlahan bahan baku dapur pusat */
                                                                    foreach ($bomharga123 as $bomhargas123) {
                                                                    if ($bomhargas123->Harga2 != null) {
                                                                    Laporanhpp::where('KODE_BARANG', $bomhargas123->koode)->update([
                                                                    'COGS' => Laporanhpp::raw('round(laporanhpps.Banyak * ' . $bomhargas123->Harga2 . ',2) '),
                                                                    'Profit' => Laporanhpp::raw('round(round(laporanhpps.Revenue,2) - round(laporanhpps.Banyak * ' . $bomhargas123->Harga2 . ',2)'),
                                                                    'Margin' => Laporanhpp::raw(' round(((round(laporanhpps.Revenue,2) - round(laporanhpps.Banyak * ' . $bomhargas123->Harga2 . ',2)) / round(laporanhpps.Revenue,2)) * 100,2)'),
                                                                    'Revenue' => Laporanhpp::raw('round(laporanhpps.Revenue,2)')
                                                                    ]);
                                                                    }
                                                                    }




                                                                    $penjualanss = Laporanhpp::get();
                                                                    return view('Laporanhpps', compact('penjualanss'));
                                                                    }

                                                                    return redirect("/")->withSuccess('Opps! You do not have access');
                                                                    }