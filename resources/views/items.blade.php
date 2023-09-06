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
                    <h4>Data Base Item</h4>
                </div>
                <div class="card-body">
                    <table id="tblStocks" class="table table-bordered mt-3 table-responsive ">
                        <tr colspan='12'>
                            <a class="btn btn-danger float-end" href="{{ route('items.export') }}">Export Data Item</a>
                        </tr>
                        <tr>
                            <th>KODE BARANG PURCHASING</th>
                            <th>KODE DESKRIPSI BARANG PURCHASING</th>
                            <th>SATUAN</th>
                            <th>KODE BARANG SAGE</th>
                            <th>KODE DESKRIPSI BARANG SAGE</th>
                            <th>BUYING UNIT SAGE</th>
                            <th>RUMUS Untuk Purchase</th>
                            <th>STOKING UNIT BOM</th>
                            <th>RUMUS untuk BOM</th>
                            <th>Acc. Persediaan</th>
                            <th>Acc. Biaya</th>
                            <th>Acc. Rev</th>
                        </tr>
                        @foreach($items as $Item)
                        <tr>
                            <td>{{ $Item->KODE_BARANG_PURCHASING }}</td>
                            <td>{{ $Item->KODE_DESKRIPSI_BARANG_PURCHASING }}</td>
                            <td>{{ $Item->SATUAN }}</td>
                            <td>{{ $Item->KODE_BARANG_SAGE }}</td>
                            <td>{{ $Item->KODE_DESKRIPSI_BARANG_SAGE }}</td>
                            <td>{{ $Item->BUYING_UNIT_SAGE }}</td>
                            <td>{{ $Item->RUMUS_Untuk_Purchase }}</td>
                            <td>{{ $Item->STOKING_UNIT_BOM }}</td>
                            <td>{{ $Item->RUMUS_untuk_BOM }}</td>
                            <td>{{ $Item->AccPersediaan }}</td>
                            <td>{{ $Item->AccBiaya }}</td>
                            <td>{{ $Item->AccRev }}</td>

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