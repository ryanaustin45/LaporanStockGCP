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
                    <h4>Data Base Bom</h4>
                </div>
                <div class="card-body">
                    <table class="table table-bordered table-responsive">
                        <tr>
                            <th colspan="12">
                                <p>Cari Data Kode Outlet :</p>
                                <form action="{{ route('boms.cari') }}" method="GET">
                                    <input type="text" name="cari" placeholder="Masukan kode Outlet .." value="{{ old('cari') }}">
                                    <input type="submit" value="CARI">
                                </form>
                            </th>
                        </tr>
                        <tr>
                            <th>KODE BAHAN</th>
                            <th>NAMA BAHAN</th>
                            <th>BANYAK</th>
                            <th>SATUAN BAHAN</th>
                            <th>KODE BARANG</th>
                            <th>NAMA BARANG</th>
                            <th>SATUAN BARANG</th>
                        </tr>
                        @foreach($boms1 as $bom)
                        <tr>
                            <td>{{ $bom->KODE_BAHAN }}</td>
                            <td>{{ $bom->NAMA_BAHAN }}</td>
                            <td>{{ $bom->BANYAK }}</td>
                            <td>{{ $bom->SATUAN_BAHAN }}</td>
                            <td>{{ $bom->KODE_BARANG }}</td>
                            <td>{{ $bom->NAMA_BARANG }}</td>
                            <td>{{ $bom->SATUAN_BARANG }}</td>

                        </tr>
                        @endforeach
                        @foreach($boms2 as $bom)
                        <tr>
                            <td>{{ $bom->KODE_BAHAN }}</td>
                            <td>{{ $bom->NAMA_BAHAN }}</td>
                            <td>{{ $bom->BANYAK }}</td>
                            <td>{{ $bom->SATUAN_BAHAN }}</td>
                            <td>{{ $bom->KODE_BARANG }}</td>
                            <td>{{ $bom->NAMA_BARANG }}</td>
                            <td>{{ $bom->SATUAN_BARANG }}</td>

                        </tr>
                        @endforeach
                        @foreach($boms3 as $bom)
                        <tr>
                            <td>{{ $bom->KODE_BAHAN }}</td>
                            <td>{{ $bom->NAMA_BAHAN }}</td>
                            <td>{{ $bom->BANYAK }}</td>
                            <td>{{ $bom->SATUAN_BAHAN }}</td>
                            <td>{{ $bom->KODE_BARANG }}</td>
                            <td>{{ $bom->NAMA_BARANG }}</td>
                            <td>{{ $bom->SATUAN_BARANG }}</td>

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