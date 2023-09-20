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


                    <table id="example1" class="table table-bordered table-responsive ">
                        <thead>
                            <tr>
                                <th> Kode Outlet </th>
                                <th> Nama Outlet</th>
                                <th> Kode Item</th>
                                <th> Nama Item</th>
                                <th> Satuan</th>
                                <th> Harga</th>

                                <th> Saldo Awal Quantity </th>
                                <th> Saldo Awal Nilai </th>

                                <th> Pembelian </th>
                                <th> Penerimaan Internal</th>
                                <th> Total Transfer IN</th>
                                <th> Pengiriman Internal</th>
                                <th> Bom </th>
                                <th> Total Transfer Out</th>
                                <th> Biaya</th>
                                <th> Saldo Akhir Quantity</th>
                                <th> Saldo Akhir Nilai </th>

                            </tr>
                        </thead>
                        <tbody>

                            @foreach($laporanakhirview as $Item)
                            <tr>
                                <td>{{ $Item->KODE }}</td>
                                <td>{{ $Item->NAMA }}</td>

                                <td>{{ $Item->KODE_BARANG_SAGE }}</td>
                                <td>{{ $Item->KODE_DESKRIPSI_BARANG_SAGE }}</td>

                                <td>{{ $Item->STOKING_UNIT_BOM }}</td>
                                <td>{{ $Item->SAwalQuantity }}</td>
                                <td>{{ $Item->SAwalUnit }}</td>
                                <td>{{ $Item->SAwalPrice }}</td>
                                <td>{{ $Item->Pembelian_Unit }}</td>
                                <td>{{ $Item->Penerimaan_Unit }}</td>
                                <td>{{ $Item->TransferIn_Unit }}</td>
                                <td>{{ $Item->Pengiriman_Unit }}</td>
                                <td>{{ $Item->Bom_Unit }}</td>
                                <td>{{ $Item->TransferOut_Unit }}</td>
                                <td>{{ $Item->BiayaUnit }}</td>
                                <td>{{ $Item->SAkhirUnit }}</td>
                                <td>{{ $Item->SAkhirPrice }}</td>
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