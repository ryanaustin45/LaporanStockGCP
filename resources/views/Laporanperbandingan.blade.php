<!DOCTYPE html>
<html>

<head>
    @include('Template.Head')
</head>

<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed">
    @include('Template.Navbar')
    @include('Template.Sidebar2')
    <div class="content-wrapper">
        <div class="container-fluid">
            <div class="card mt-3 mb-3">
                <div class="card-header text-center">
                    <h4>Laporan Pengiriman</h4>
                </div>
                <div class="card-body">
                    <p>Input Tanggal :</p>

                    <form action="{{ route('laporans.perbandingan') }}" method="GET">
                        <div class="container float-left">
                            <div class="row">
                                <div class="col p-4"><label>
                                        Tanggal Awal :
                                    </label>
                                    <input type="date" name="Tanggal_awal" class="form-control">
                                </div>
                            </div>
                            <div class="row">

                                <div class="col p-4"><label>
                                        Tanggal Akhir:
                                    </label>
                                    <input type="date" name="Tanggal_akhir" class="form-control">
                                </div>
                            </div>

                        </div>
                        <div class="col-md-3 pt-4 p-4">
                            <button type="submit" class="btn btn-primary">Submit Tanggal</button>
                        </div>
                    </form>
                    <p>Cari Data Kode Outlet :</p>
                    <form action="{{ route('perbandingan.cari') }}" method="GET">
                        <input type="text" name="cari" placeholder="Masukan kode Outlet .." value="{{ old('cari') }}">
                        <input type="submit" value="CARI">
                    </form>
                    <div class="card-body">
                        <table class="table table-bordered mt-3">
                            <tr>
                                <th>NO</th>
                                <th>BUKTI KIRIM</th>
                                <th>TGL KIRIM</th>
                                <th>DARI</th>
                                <th>NAMA DARI</th>
                                <th>TGL TERIMA</th>
                                <th>PENERIMA</th>
                                <th>NAMA PENERIMA</th>
                                <th>KD BARANG</th>
                                <th>NAMA BARANG</th>
                                <th>SATUAN</th>
                                <th>QT KIRIM</th>
                                <th>QT TERIMA</th>
                                <th>QT SISA</th>
                            </tr>
                            @foreach($laporanpengirimans2 as $Item)
                            <tr>
                                <td class="counterCell"></td>
                                <td>{{ $Item->BUKTI_KIRIM }}</td>
                                <td>{{ $Item->TGL_KIRIM }}</td>
                                <td>{{ $Item->DARI }}</td>
                                <td>{{ $Item->NAMADARI }}</td>
                                <td>{{ $Item->TGL_TERIMA }}</td>
                                <td>{{ $Item->PENERIMA }}</td>
                                <td>{{ $Item->NAMAPENERIMA }}</td>
                                <td>{{ $Item->KD_BHN }}</td>
                                <td>{{ $Item->NAMABARANG }}</td>
                                <td>{{ $Item->SATUAN }}</td>
                                <td>{{ $Item->QT_KIRIM }}</td>
                                <td>{{ $Item->QT_TERIMA }}</td>
                                <td>{{ $Item->QT_SISA }}</td>

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