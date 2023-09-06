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
                    <h4>Data Base pengiriman</h4>
                </div>
                <div class="card-body">
                    <table class="table table-bordered mt-3">
                        <tr>
                            <th colspan="12">
                                <a class="btn btn-danger float-end" href="{{ route('penerimaans.export') }}">Export Convert Data Penerimaan Internal</a>
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
                        @foreach($penerimaanss as $Item)
                        <tr>
                            <td class="counterCell"></td>
                            <td>{{ $Item->TANGGAL }}</td>
                            <td>{{ $Item->DARI }}</td>
                            <td>{{ $Item->NAMADARI }}</td>
                            <td>{{ $Item->KODE_BARANG_SAGE }}</td>
                            <td>{{ $Item->KODE_DESKRIPSI_BARANG_SAGE }}</td>
                            <td>{{ $Item->STOKING_UNIT_BOM }}</td>
                            <td>{{ $Item->QUANTITY }}</td>
                            <td>{{ $Item->HARGA }}</td>
                            <td>{{ $Item->COST }}</td>


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