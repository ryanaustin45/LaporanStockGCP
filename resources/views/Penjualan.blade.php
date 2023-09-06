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
                    <h4>Data Penjualan</h4>
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <tr>
                            <th colspan="12">
                            </th>
                        </tr>
                        <tr>
                            <th>No</th>
                            <th>Tanggal</th>
                            <th>Kode Outlet</th>
                            <th>Outlet</th>
                            <th>Kode Barang</th>
                            <th>Barang</th>
                            <th>Satuan</th>
                            <th>Jumlah</th>
                        </tr>
                        @foreach($penjualanss as $Item)
                        <tr>
                            <td class="counterCell"></td>
                            <td>{{ $Item->TANGGAL }}</td>
                            <td>{{ $Item->KODE }}</td>
                            <td>{{ $Item->NAMA }}</td>
                            <td>{{ $Item->KODE_BARANG_SAGE }}</td>
                            <td>{{ $Item->KODE_DESKRIPSI_BARANG_SAGE }}</td>
                            <td>{{ $Item->STOKING_UNIT_BOM }}</td>
                            <td>{{ $Item->QUANTITY }}</td>

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