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
                    <h4>Data Base Outlet</h4>
                </div>
                <div class="card-body">
                    <table class="table table-bordered mt-3">
                        <tr>
                            <th colspan="5">
                                <a class="btn btn-danger float-end" href="{{ route('outlets.export') }}">Export Database Outlet</a>
                            </th>
                        </tr>
                        <tr>
                            <th>KODE</th>
                            <th>NAMA</th>
                            <th>ALAMAT</th>
                            <th>ADMIN_PO</th>
                            <th>ADMIN_SPB</th>
                        </tr>
                        @foreach($outlets as $Outlet)
                        <tr>
                            <td>{{ $Outlet->KODE }}</td>
                            <td>{{ $Outlet->NAMA }}</td>
                            <td>{{ $Outlet->ALAMAT }}</td>
                            <td>{{ $Outlet->ADMIN_PO }}</td>
                            <td>{{ $Outlet->ADMIN_SPB }}</td>
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