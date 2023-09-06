<!DOCTYPE html>
<html>

<head>
    @include('Template.Head')
</head>

<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed">
    @include('Template.Navbar')
    @include('Template.Sidebar')
    <div class="content-wrapper">
        <div class="container-fluid"">
        <div class=" card-deck ">
            <div class=" card mt-3 mb-3">
            <div class="card-body">
                <h5 class="card-title">Import Data Pembelian</h5>
                <form action="{{ route('pembelians.import') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="file" name="file" class="form-control">
                    <br>
                    <button class="btn btn-primary">Submit</button>
                </form>
            </div>
        </div>
        <div class="card mt-3 mb-3">
            <div class="card-body">
                <h5 class="card-title">Import Data Penerimaan Internal</h5>
                <form action="{{ route('penerimaans.import') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="file" name="file" class="form-control">
                    <br>
                    <button class="btn btn-primary">Submit</button>
                </form>
            </div>
        </div>
        <div class="card mt-3 mb-3">
            <div class="card-body">
                <h5 class="card-title">Import Data Penjualan</h5>
                <form action="{{ route('penjualans.import') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="file" name="file" class="form-control">
                    <br>
                    <button class="btn btn-primary">Submit</button>
                </form>
            </div>
        </div>
    </div>
    <?php /*  
        <div class=" card mt-3 mb-3">
            <div class="card-header text-center">
                <h4>Import Data Pembelian</h4>
            </div>
            <div class="card-header text-center">
                <div class="card-body">
                    <form action="{{ route('pembelians.import') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="file" name="file" class="form-control">
                        <br>
                        <button class="btn btn-primary">Import User Data</button>
                    </form>
                </div>
            </div>
        </div>
        
        <div class=" card mt-3 mb-3">
            <div class="card-header text-center">
                <h4>Import Data Penerimaan Internal</h4>
            </div>
            <div class="card-header text-center">
                <div class="card-body">
                    <form action="{{ route('penerimaans.import') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="file" name="file" class="form-control">
                        <br>
                        <button class="btn btn-primary">Import User Data</button>
                    </form>
                </div>
            </div>
        </div>
        <div class=" card w-50">
            <div class="card-header text-center">
                <h4>Import Data Penjualan</h4>
            </div>
            <div class="card-header text-center">
                <div class="card-body">
                    <form action="{{ route('penjualans.import') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="file" name="file" class="form-control">
                        <br>
                        <button class="btn btn-primary">Import User Data</button>
                    </form>
                </div>
            </div>
        </div>
         */ ?>
    <a class="btn btn-danger float-left" href="{{ route('delete.database') }}">Delete Database</a>


    </div>

    </div>

    @include('Template.Script')

</body>

</html>