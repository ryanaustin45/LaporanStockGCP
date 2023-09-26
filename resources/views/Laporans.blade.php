<!DOCTYPE html>
<html>

<head>
    @include('Template.Head')
    <title> Laporan Stock </title>

</head>

<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed">
    @include('Template.Navbar')
    @include('Template.Sidebar')
    <div class="content-wrapper main">
        <div class="container-fluid">
            <div class="card mt-3 mb-3">
                <div class="card-header text-center">
                    <h4>Laporan Stock</h4>
                </div>
                <div class="card-body">
                    <p>Input Tanggal :</p>

                    <form action="{{ route('laporans.tanggal') }}" method="GET">
                        <div class="container float-left">
                            <div class="row">
                                <div class="col p-4"><label>
                                        Tanggal :
                                    </label>
                                    <input type="date" name="date" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 pt-4 p-4">
                            <button type="submit" class="btn btn-primary">Submit Tanggal</button>
                        </div>
                    </form>


                    <table id="example1" class="table table-bordered table-responsive ">
                        <thead>
                            <tr>
                                <th colspan="4"> </th>
                                <th colspan="3"> Saldo Awal </th>
                                <th colspan="3"> Pembelian </th>
                                <th colspan="3"> Penerimaan Internal</th>
                                <th colspan="3"> Total Transfer IN</th>
                                <th colspan="3"> Pengiriman Internal</th>
                                <th colspan="3"> Bom </th>
                                <th colspan="3"> Total Transfer Out</th>
                                <th colspan="3"> Biaya</th>
                                <th colspan="3"> Saldo Akhir</th>

                            </tr>
                            <tr>
                                <th>Tanggal</th>
                                <th>Kode Outlet</th>
                                <th>Nama Item</th>
                                <th>Satuan</th>
                                <th>Quantity</th>
                                <th>Price</th>
                                <th>Amount</th>
                                <th>Quantity</th>
                                <th>Price</th>
                                <th>Amount</th>
                                <th>Quantity</th>
                                <th>Price</th>
                                <th>Amount</th>
                                <th>Quantity</th>
                                <th>Price</th>
                                <th>Amount</th>
                                <th>Quantity</th>
                                <th>Price</th>
                                <th>Amount</th>
                                <th>Quantity</th>
                                <th>Price</th>
                                <th>Amount</th>
                                <th>Quantity</th>
                                <th>Price</th>
                                <th>Amount</th>
                                <th>Quantity</th>
                                <th>Price</th>
                                <th>Amount</th>
                                <th>Quantity</th>
                                <th>Price</th>
                                <th>Amount</th>
                            </tr>
                        </thead>
                        <tbody>

                            @foreach($laporanakhirview as $Item)
                            <tr>
                                <td>{{ $Item->TANGGAL }}</td>
                                <td>{{ $Item->KODE }}</td>
                                <td>{{ $Item->KODE_DESKRIPSI_BARANG_SAGE }}</td>
                                <td>{{ $Item->STOKING_UNIT_BOM }}</td>
                                <td>{{ number_format($Item->SAwalUnit,2) }}</td>
                                <td>{{ number_format($Item->SAwalQuantity,2) }}</td>
                                <td>{{ number_format($Item->SAwalPrice,2) }}</td>
                                <td>{{ number_format($Item->Pembelian_Unit,2) }}</td>
                                <td>{{ number_format($Item->Pembelian_Quantity,2) }}</td>
                                <td>{{ number_format($Item->Pembelian_Price,2) }}</td>
                                <td>{{ number_format($Item->Penerimaan_Unit,2) }}</td>
                                <td>{{ number_format($Item->Penerimaan_Quantity,2) }}</td>
                                <td>{{ number_format($Item->Penerimaan_Price,2) }}</td>
                                <td>{{ number_format($Item->TransferIn_Unit,2) }}</td>
                                <td>{{ number_format($Item->TransferIn_Quantity,2) }}</td>
                                <td>{{ number_format($Item->TransferIn_Price,2) }}</td>
                                <td>{{ number_format($Item->Pengiriman_Unit,2) }}</td>
                                <td>{{ number_format($Item->TransferIn_Quantity,2) }}</td>
                                <td>{{ number_format($Item->Pengiriman_Price,2) }}</td>
                                <td>{{ number_format($Item->Bom_Unit,2) }}</td>
                                <td>{{ number_format($Item->TransferIn_Quantity,2) }}</td>
                                <td>{{ number_format($Item->Bom_Price,2) }}</td>
                                <td>{{ number_format($Item->TransferOut_Unit,2) }}</td>
                                <td>{{ number_format($Item->TransferIn_Quantity,2) }}</td>
                                <td>{{ number_format($Item->TransferOut_Price,2) }}</td>
                                <td>{{ number_format($Item->BiayaUnit,2) }}</td>
                                <td>{{ number_format($Item->TransferIn_Quantity,2) }}</td>
                                <td>{{ number_format($Item->BiayaPrice,2) }}</td>
                                <td>{{ number_format($Item->SAkhirUnit,2) }}</td>
                                <td>{{ number_format($Item->TransferIn_Quantity,2) }}</td>
                                <td>{{ number_format($Item->SAkhirPrice,2) }}</td>
                            </tr>
                            @endforeach
                        <tbody>

                    </table>

                    <?php /* .
                    <p>Cari Data Kode Outlet :</p>
                    <form action="{{ route('laporans.cari') }}" method="GET">
                        <input type="text" name="cari" placeholder="Masukan kode Outlet .." value="{{ old('cari') }}">
                        <input type="submit" value="CARI">
                    </form>
                    <a class="btn btn-danger float-left " href="{{ route('boms1.export') }}">Export Laporan Excel</a>
                    */ ?>
                </div>
            </div>
        </div>
    </div>


    @include('Template.Script')
</body>

</html>