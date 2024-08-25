<ul class="sidebar-nav" id="sidebar-nav">

    <li class="nav-item">
        <a class="nav-link {{ Route::currentRouteName() == 'dashboard' ? '' : 'collapsed' }}" href={{ route('dashboard')}}>
            <i class="bi bi-grid"></i>
            <span>Dashboard</span>
        </a>
    </li><!-- End Dashboard Nav -->
    
    <li class="nav-item">
        <a class="nav-link {{ Route::currentRouteName() == 'admin.depo' ? '' : 'collapsed' }}" href={{ route('admin.depo')}}>
            <i class="bi bi-building"></i>
            <span>Depo</span>
        </a>
    </li>

    <li class="nav-item">
        <a class="nav-link {{ Route::currentRouteName() == 'admin.sales' ? '' : 'collapsed' }}" href={{ route('admin.sales')}}>
            <i class="bi bi-person-badge"></i>
            <span>Sales</span>
        </a>
    </li>

    <li class="nav-item">
        <a class="nav-link {{ Route::currentRouteName() == 'admin.bts' ? '' : 'collapsed' }}" href={{ route('admin.bts')}}>
            <i class="bi bi-broadcast-pin"></i>
            <span>BTS</span>
        </a>
    </li>

    <li class="nav-item">
        <a class="nav-link {{ in_array(Route::currentRouteName(), ['admin.outlet', 'admin.jenis_outlet']) ? '' : 'collapsed' }}" data-bs-target="#outlet-nav" data-bs-toggle="collapse" href="#">
            <i class="bi bi-shop"></i><span>Outlet</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="outlet-nav" class="nav-content collapse {{ in_array(Route::currentRouteName(), ['admin.outlet', 'admin.jenis_outlet']) ? 'show' : '' }}" data-bs-parent="#sidebar-nav">
            <li>
                <a href="{{ route('admin.outlet') }}" class="{{ Route::currentRouteName() == 'admin.outlet' ? 'active' : '' }}">
                    <i class="bi bi-circle"></i><span>Data Outlet</span>
                </a>
            </li>
            <li>
                <a href="{{ route('admin.jenis_outlet') }}" class="{{ Route::currentRouteName() == 'admin.jenis_outlet' ? 'active' : '' }}">
                    <i class="bi bi-circle"></i><span>Jenis Outlet</span>
                </a>
            </li>
        </ul>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ in_array(Route::currentRouteName(), ['admin.barang_masuk', 'admin.barang', 'admin.jenis_barang', 'admin.harga_barang', 'admin.histori_barang']) ? '' : 'collapsed' }}" data-bs-target="#barang-nav" data-bs-toggle="collapse" href="#">
            <i class="bi bi-box-seam"></i><span>Manajemen Barang</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="barang-nav" class="nav-content collapse {{ in_array(Route::currentRouteName(), ['admin.barang_masuk', 'admin.barang', 'admin.jenis_barang', 'admin.harga_barang', 'admin.histori_barang']) ? 'show' : '' }}" data-bs-parent="#sidebar-nav">
            <li>
                <a href="{{ route('admin.barang_masuk') }}" class="{{ Route::currentRouteName() == 'admin.barang_masuk' ? 'active' : '' }}">
                    <i class="bi bi-circle"></i><span>Barang Masuk</span>
                </a>
            </li>
            <li>
                <a href="{{ route('admin.barang') }}" class="{{ Route::currentRouteName() == 'admin.barang' ? 'active' : '' }}">
                    <i class="bi bi-circle"></i><span>Data Barang</span>
                </a>
            </li>
            <li>
                <a href="{{ route('admin.jenis_barang') }}" class="{{ Route::currentRouteName() == 'admin.jenis_barang' ? 'active' : '' }}">
                    <i class="bi bi-circle"></i><span>Jenis Barang</span>
                </a>
            </li>
            <li>
                <a href="{{ route('admin.harga_barang') }}" class="{{ Route::currentRouteName() == 'admin.harga_barang' ? 'active' : '' }}">
                    <i class="bi bi-circle"></i><span>Harga Barang</span>
                </a>
            </li>
            <li>
                <a href="{{ route('admin.detail_barang') }}" class="{{ Route::currentRouteName() == 'admin.detail_barang' ? 'active' : '' }}">
                    <i class="bi bi-circle"></i><span>Detail Barang</span>
                </a>
            </li>
            <li>
                <a href="{{ route('admin.histori_barang') }}" class="{{ Route::currentRouteName() == 'admin.histori_barang' ? 'active' : '' }}">
                    <i class="bi bi-circle"></i><span>Histori Barang</span>
                </a>
            </li>
        </ul>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ in_array(Route::currentRouteName(), ['admin.transaksi_distribusi_depo', 'admin.transaksi_distribusi_sales']) ? '' : 'collapsed' }}" data-bs-target="#transaksi-distribusi-nav" data-bs-toggle="collapse" href="#">
            <i class="bi bi-truck"></i><span>Transaksi Distribusi</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="transaksi-distribusi-nav" class="nav-content collapse {{ in_array(Route::currentRouteName(), ['admin.transaksi_distribusi_depo', 'admin.transaksi_distribusi_sales']) ? 'show' : '' }}" data-bs-parent="#sidebar-nav">
            <li>
                <a href="{{ route('admin.transaksi_distribusi_depo') }}" class="{{ Route::currentRouteName() == 'admin.transaksi_distribusi_depo' ? 'active' : '' }}">
                    <i class="bi bi-circle"></i><span>Distribusi ke Depo</span>
                </a>
            </li>
            <li>
                <a href="{{ route('admin.transaksi_distribusi_sales') }}" class="{{ Route::currentRouteName() == 'admin.transaksi_distribusi_sales' ? 'active' : '' }}">
                    <i class="bi bi-circle"></i><span>Distribusi ke Sales</span>
                </a>
            </li>
        </ul>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ Route::currentRouteName() == 'admin.pembayaran' ? '' : 'collapsed' }}" href={{ route('admin.pembayaran')}}>
            <i class="bi bi-credit-card"></i>
            <span>Pembayaran</span>
        </a>
    </li>
</ul>
