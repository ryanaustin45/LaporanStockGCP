<!DOCTYPE html>
<html>

<head>
    @include('Template.Head')
</head>

<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed">
    @include('Template.Navbar')
    @include('Template.Sidebar2')
    <div class="content-wrapper">
        <div class="container-fluid"">
        <div class=" card-deck ">
            <div class=" card mt-3 mb-3">
            <div class="card-body">
                <h5 class="card-title">Import Data Penerimaan</h5>
                <form action="{{ route('laporanpenerimaans.import') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="file" name="file" class="form-control">
                    <br>
                    <button class="btn btn-primary">Submit</button>
                </form>
            </div>
        </div>
        <div class="card mt-3 mb-3">
            <div class="card-body">
                <h5 class="card-title">Import Data Pengiriman</h5>
                <form action="{{ route('laporanpengirimans.import') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="file" name="file" class="form-control">
                    <br>
                    <button class="btn btn-primary">Submit</button>
                </form>
            </div>
        </div>

    </div>
    <a class="btn btn-danger float-left" href="{{ route('deleteperbandingan.database') }}">Delete Database</a>


    </div>
    </div>

    @include('Template.Script')

</body>

</html>