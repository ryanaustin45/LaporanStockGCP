<!DOCTYPE html>
<html>

<head>
    @include('Template.Head')

</head>

<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed">
    @include('Template.Navbar')
    @include('Template.Sidebar')
    <div class="content-wrapper main">
        <div class="container-fluid">
            <div class="card mt-3 mb-3">
                <div class="card-header text-center">
                    <h4>Laporan</h4>
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
                    <p>Cari Data Kode Outlet :</p>
                    <form action="{{ route('laporans.cari') }}" method="GET">
                        <input type="text" name="cari" placeholder="Masukan kode Outlet .." value="{{ old('cari') }}">
                        <input type="submit" value="CARI">
                    </form>

                    <table id="example1" class="table table-bordered ">
                        <thead>
                            <tr>
                                <th colspan="3"> </th>
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
                                <td>{{ $Item->KODE }}</td>
                                <td>{{ $Item->KODE_DESKRIPSI_BARANG_SAGE }}</td>
                                <td>{{ $Item->STOKING_UNIT_BOM }}</td>
                                <td>{{ $Item->SAwalUnit }}</td>
                                <td>{{ $Item->SAwalQuantity }}</td>
                                <td>{{ $Item->SAwalPrice }}</td>
                                <td>{{ $Item->Pembelian_Unit }}</td>
                                <td>{{ $Item->Pembelian_Quantity }}</td>
                                <td>{{ $Item->Pembelian_Price }}</td>
                                <td>{{ $Item->Penerimaan_Unit }}</td>
                                <td>{{ $Item->Penerimaan_Quantity }}</td>
                                <td>{{ $Item->Penerimaan_Price }}</td>
                                <td>{{ $Item->TransferIn_Unit }}</td>
                                <td>{{ $Item->TransferIn_Quantity }}</td>
                                <td>{{ $Item->TransferIn_Price }}</td>
                                <td>{{ $Item->Pengiriman_Unit }}</td>
                                <td>{{ $Item->Pengiriman_Quantity }}</td>
                                <td>{{ $Item->Pengiriman_Price }}</td>
                                <td>{{ $Item->Bom_Unit }}</td>
                                <td>{{ $Item->Bom_Quantity }}</td>
                                <td>{{ $Item->Bom_Price }}</td>
                                <td>{{ $Item->TransferOut_Unit }}</td>
                                <td>{{ $Item->TransferOut_Quantity }}</td>
                                <td>{{ $Item->TransferOut_Price }}</td>
                                <td>{{ $Item->BiayaUnit }}</td>
                                <td>{{ $Item->BiayaQuantity }}</td>
                                <td>{{ $Item->BiayaPrice }}</td>
                                <td>{{ $Item->SAkhirUnit }}</td>
                                <td>{{ $Item->SAkhirQuantity }}</td>
                                <td>{{ $Item->SAkhirPrice }}</td>
                            </tr>
                            @endforeach
                        <tbody>

                    </table>

                    <?php /* 
                    <a class="btn btn-danger float-left " href="{{ route('boms1.export') }}">Export Laporan Excel</a>
                    */ ?>
                </div>
            </div>
        </div>
    </div>


    @include('Template.Script')
</body>

</html>