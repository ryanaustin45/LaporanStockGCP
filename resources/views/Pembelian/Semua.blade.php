<!DOCTYPE html>
<html>

<head>
    @include('Template.Head')
</head>

<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed">
    @include('Template.Navbar')
    @include('Template.Sidebar')
    <div class="content-wrapper">
        <div class="container-fluid">
            <div class="card mt-3 mb-3">
                <div class="card-header text-center">
                    <h4>Data Base Pembelian</h4>
                </div>
                <div class="card-body">
                    <table class="table table-bordered mt-3">
                        <?php /*  
                        <tr>
                            <th colspan="12">
                                <p>Cari Data Kode Outlet :</p>
                                <form action="{{ route('pembelians.cari') }}" method="GET">
                                    <input type="text" name="cari" placeholder="Masukan kode Outlet .." value="{{ old('cari') }}">
                                    <input type="submit" value="CARI">
                                </form>
                            </th>
                        </tr>
                        
                        */ ?>
                        <tr>
                            <th colspan="12">
                                <p>Cari Data Filter Tanggal :</p>

                                <form action="{{ route('pembelians.filter') }}" method="GET">
                                    <div class="container">
                                        <div class="row">
                                            <div class="col"><label>
                                                    Tanggal Awal :
                                                </label>
                                                <input type="date" name="start_date" class="form-control">
                                            </div>
                                            <div class="col"><label>
                                                    Tanggal Akhir:
                                                </label>
                                                <input type="date" name="end_date" class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3 pt-4">
                                        <button type="submit" class="btn btn-primary">Filter Tanggal</button>
                                    </div>
                                </form>
                            </th>
                        </tr>
                        <tr>
                            <th colspan="12">
                                <a class="btn btn-danger float-right " href="{{ route('pembelians.export') }}">Export Convert Import Data Pembelian</a>
                            </th>
                        </tr>
                        <tr>
                            <th>No</th>
                            <th>Tanggal</th>
                            <th>Kode Outlet</th>
                            <th>Nama Outlet</th>
                            <th>Kode Item</th>
                            <th>Nama Item</th>
                            <th>Satuan</th>
                            <th>Quantity</th>
                            <th>Price</th>
                            <th>Amount</th>
                        </tr>
                        @foreach($pembelians as $Item)
                        <tr>
                            <td class="counterCell"></td>
                            <td>{{ $Item->TANGGAL }}</td>
                            <td>{{ $Item->KODE }}</td>
                            <td>{{ $Item->NAMA }}</td>
                            <td>{{ $Item->KODE_BARANG_SAGE }}</td>
                            <td>{{ $Item->KODE_DESKRIPSI_BARANG_SAGE }}</td>
                            <td>{{ $Item->STOKING_UNIT_BOM }}</td>
                            <td>{{ $Item->QUANTITY }}</td>
                            <td>{{ $Item->HARGA }}</td>
                            <td>{{ $Item->JUMLAH }}</td>

                        </tr>
                        @endforeach
                    </table>

                </div>
            </div>
        </div>
    </div>
    @include('Template.Script')

</body>

</html>