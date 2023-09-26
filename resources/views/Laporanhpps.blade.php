<!DOCTYPE html>
<html>

<head>
    @include('Template.Head')
    <title> Laporan HPP </title>

</head>


<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed">
    @include('Template.Navbar')
    @include('Template.Sidebar')
    <div class="content-wrapper main">
        <div class="container-fluid">
            <div class="card mt-3 mb-3">
                <div class="card-header text-center">
                    <h4>Laporan HPP</h4>
                </div>
                <div class="card-body">
                    <p>Input Tanggal :</p>

                    <form action="{{ route('Laporanhpps.tanggal') }}" method="GET">
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


                    <table id="example1" class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Tanggal</th>
                                <th>Kode Outlet</th>
                                <th>Outlet</th>
                                <th>Kode Barang</th>
                                <th>Barang</th>
                                <th>Unit</th>
                                <th>Price</th>
                                <th>Revenue</th>
                                <th>COGS</th>
                                <th>Profit</th>
                                <th>Margin</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($penjualanss as $Item)
                            <tr>
                                <td>{{ $Item->TANGGAL }}</td>
                                <td>{{ $Item->KODE_OUTLET }}</td>
                                <td>{{ $Item->Outlet }}</td>
                                <td>{{ $Item->KODE_BARANG }}</td>
                                <td>{{ $Item->Barang }}</td>
                                <td>{{ number_format($Item->Banyak,2) }}</td>
                                <td>{{ number_format($Item->Jumlah,2) }}</td>
                                <td>{{ number_format($Item->Revenue,2) }}</td>
                                <td>{{ number_format($Item->COGS,2) }}</td>
                                <td>{{ number_format($Item->Profit,2) }}</td>
                                <td>{{ number_format($Item->Margin,2)  }}%</td>

                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <?php /* 
                    <div class="col-md-3 pt-4 p-4"><label>
                                        Outlet :
                                    </label>
                                    <input type="text" name="cari" placeholder="Masukan kode Outlet .." value="{{ old('cari') }}">
                                </div>
                    <a class="btn btn-danger float-left" href="{{ route('hpp.export') }}">Export Laporan Excel</a>
                    */ ?>

                </div>
            </div>
        </div>
    </div>
    @include('Template.Script')

</body>

</html>