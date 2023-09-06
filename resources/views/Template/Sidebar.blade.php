<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{ 'dashboard' }}" class="brand-link">
        <span class="brand-text font-weight-light">Dashboard</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- SidebarSearch Form -->
        <div class="form-inline">
            <div class="input-group" data-widget="sidebar-search">
                <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
                <div class="input-group-append">
                    <button class="btn btn-sidebar">
                        <i class="fas fa-search fa-fw"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
                <li class="nav-item">
                    <a href="{{ 'items' }}" class="nav-link">
                        <i class="nav-icon fas fa-th"></i>
                        <p>
                            Data Items
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ 'outlets' }}" class="nav-link">
                        <i class="nav-icon fas fa-th"></i>
                        <p>
                            Data Outlets
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ 'boms' }}" class="nav-link">
                        <i class="nav-icon fas fa-th"></i>
                        <p>
                            Data Boms
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ 'dashboard' }}" class="nav-link">
                        <i class="nav-icon fas fa-copy"></i>
                        <p>
                            Upload Data
                        </p>
                    </a>
                </li>

                <!-- DATA BASE PEMBELIAN -->
                <li class="nav-item"">
                    <a href=" /pembelian" class="nav-link">
                    <p>
                        Data Convert Pembelian </p>
                    </a>
                </li>
                <!-- /.DATA BASE PEMBELIAN -->

                <!-- DATA BASE PENERIMAAN -->


                <li class="nav-item"">
                    <a href=" /penerimaan" class="nav-link">
                    <p>
                        Data Convert Penerimaan </p>
                    </a>
                </li>
                <li class="nav-item"">
                    <a href=" /pengiriman" class="nav-link">
                    <p>
                        Data Convert Pengiriman </p>
                    </a>
                </li>

                <li class="nav-item"">
                    <a href=" /penjualan" class="nav-link">
                    <p>
                        Data Convert Bom </p>
                    </a>
                </li>
                <li class="nav-item"">
                    <a href=" /laporan" class="nav-link">
                    <p>
                        Laporan Stock</p>
                    </a>
                </li>
                <li class="nav-item"">
                    <a href=" /laporandua" class="nav-link">
                    <p>
                        Laporan Stock Range Tanggal</p>
                    </a>
                </li>
                <li class="nav-item"">
                    <a href=" /Laporanhpps" class="nav-link">
                    <p>
                        Laporan HPP</p>
                    </a>
                </li>
                <!-- /.DATA BASE SALDO AKHIR                     <i class="nav-icon fas fa-file-alt"></i>-->
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>