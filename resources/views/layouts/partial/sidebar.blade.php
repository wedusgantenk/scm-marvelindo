<!-- ======= Sidebar ======= -->
<aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">

        <li class="nav-item">
            <a class="nav-link {{ Route::currentRouteName() == 'dashboard' ? '' : 'collapsed' }}" href={{ route('dashboard')}}>
                <i class="bi bi-grid"></i>
                <span>Dashboard</span>
            </a>
        </li><!-- End Dashboard Nav -->

        <li class="nav-item">
            <a class="nav-link {{ Route::currentRouteName() == 'admin.cluster' ? '' : 'collapsed' }}" href={{ route('admin.cluster')}}>
                <i class="bi bi-diagram-3"></i>
                <span>Cluster</span>
            </a>
        </li>
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
            <a class="nav-link {{ Route::currentRouteName() == 'admin.petugas' ? '' : 'collapsed' }}" href={{ route('admin.petugas')}}>
                <i class="bi bi-person-vcard"></i>
                <span>Petugas</span>
            </a>
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
                    <a href="{{ route('admin.histori_barang') }}" class="{{ Route::currentRouteName() == 'admin.histori_barang' ? 'active' : '' }}">
                        <i class="bi bi-circle"></i><span>Histori Barang</span>
                    </a>
                </li>
            </ul>
        </li>

        <li class="nav-item">
            <a class="nav-link {{ in_array(Route::currentRouteName(), ['components-alerts', 'components-accordion', 'components-badges', 'components-breadcrumbs', 'components-buttons', 'components-cards', 'components-carousel', 'components-list-group', 'components-modal', 'components-tabs', 'components-pagination', 'components-progress', 'components-spinners', 'components-tooltips']) ? '' : 'collapsed' }}" data-bs-target="#components-nav" data-bs-toggle="collapse" href="#">
                <i class="bi bi-menu-button-wide"></i><span>Components</span><i class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="components-nav" class="nav-content collapse {{ in_array(Route::currentRouteName(), ['components-alerts', 'components-accordion', 'components-badges', 'components-breadcrumbs', 'components-buttons', 'components-cards', 'components-carousel', 'components-list-group', 'components-modal', 'components-tabs', 'components-pagination', 'components-progress', 'components-spinners', 'components-tooltips']) ? 'show' : '' }}" data-bs-parent="#sidebar-nav">
                <li>
                    <a href="components-alerts.html" class="{{ Route::currentRouteName() == 'components-alerts' ? 'active' : '' }}">
                        <i class="bi bi-circle"></i><span>Alerts</span>
                    </a>
                </li>
                <li>
                    <a href="components-accordion.html" class="{{ Route::currentRouteName() == 'components-accordion' ? 'active' : '' }}">
                        <i class="bi bi-circle"></i><span>Accordion</span>
                    </a>
                </li>
                <li>
                    <a href="components-badges.html" class="{{ Route::currentRouteName() == 'components-badges' ? 'active' : '' }}">
                        <i class="bi bi-circle"></i><span>Badges</span>
                    </a>
                </li>
                <li>
                    <a href="components-breadcrumbs.html" class="{{ Route::currentRouteName() == 'components-breadcrumbs' ? 'active' : '' }}">
                        <i class="bi bi-circle"></i><span>Breadcrumbs</span>
                    </a>
                </li>
                <li>
                    <a href="components-buttons.html" class="{{ Route::currentRouteName() == 'components-buttons' ? 'active' : '' }}">
                        <i class="bi bi-circle"></i><span>Buttons</span>
                    </a>
                </li>
                <li>
                    <a href="components-cards.html" class="{{ Route::currentRouteName() == 'components-cards' ? 'active' : '' }}">
                        <i class="bi bi-circle"></i><span>Cards</span>
                    </a>
                </li>
                <li>
                    <a href="components-carousel.html" class="{{ Route::currentRouteName() == 'components-carousel' ? 'active' : '' }}">
                        <i class="bi bi-circle"></i><span>Carousel</span>
                    </a>
                </li>
                <li>
                    <a href="components-list-group.html" class="{{ Route::currentRouteName() == 'components-list-group' ? 'active' : '' }}">
                        <i class="bi bi-circle"></i><span>List group</span>
                    </a>
                </li>
                <li>
                    <a href="components-modal.html" class="{{ Route::currentRouteName() == 'components-modal' ? 'active' : '' }}">
                        <i class="bi bi-circle"></i><span>Modal</span>
                    </a>
                </li>
                <li>
                    <a href="components-tabs.html" class="{{ Route::currentRouteName() == 'components-tabs' ? 'active' : '' }}">
                        <i class="bi bi-circle"></i><span>Tabs</span>
                    </a>
                </li>
                <li>
                    <a href="components-pagination.html" class="{{ Route::currentRouteName() == 'components-pagination' ? 'active' : '' }}">
                        <i class="bi bi-circle"></i><span>Pagination</span>
                    </a>
                </li>
                <li>
                    <a href="components-progress.html" class="{{ Route::currentRouteName() == 'components-progress' ? 'active' : '' }}">
                        <i class="bi bi-circle"></i><span>Progress</span>
                    </a>
                </li>
                <li>
                    <a href="components-spinners.html" class="{{ Route::currentRouteName() == 'components-spinners' ? 'active' : '' }}">
                        <i class="bi bi-circle"></i><span>Spinners</span>
                    </a>
                </li>
                <li>
                    <a href="components-tooltips.html" class="{{ Route::currentRouteName() == 'components-tooltips' ? 'active' : '' }}">
                        <i class="bi bi-circle"></i><span>Tooltips</span>
                    </a>
                </li>
            </ul>
        </li><!-- End Components Nav -->

        <li class="nav-item">
            <a class="nav-link {{ in_array(Route::currentRouteName(), ['forms-elements', 'forms-layouts', 'forms-editors', 'forms-validation']) ? '' : 'collapsed' }}" data-bs-target="#forms-nav" data-bs-toggle="collapse" href="#">
                <i class="bi bi-journal-text"></i><span>Forms</span><i class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="forms-nav" class="nav-content collapse {{ in_array(Route::currentRouteName(), ['forms-elements', 'forms-layouts', 'forms-editors', 'forms-validation']) ? 'show' : '' }}" data-bs-parent="#sidebar-nav">
                <li>
                    <a href="forms-elements.html" class="{{ Route::currentRouteName() == 'forms-elements' ? 'active' : '' }}">
                        <i class="bi bi-circle"></i><span>Form Elements</span>
                    </a>
                </li>
                <li>
                    <a href="forms-layouts.html" class="{{ Route::currentRouteName() == 'forms-layouts' ? 'active' : '' }}">
                        <i class="bi bi-circle"></i><span>Form Layouts</span>
                    </a>
                </li>
                <li>
                    <a href="forms-editors.html" class="{{ Route::currentRouteName() == 'forms-editors' ? 'active' : '' }}">
                        <i class="bi bi-circle"></i><span>Form Editors</span>
                    </a>
                </li>
                <li>
                    <a href="forms-validation.html" class="{{ Route::currentRouteName() == 'forms-validation' ? 'active' : '' }}">
                        <i class="bi bi-circle"></i><span>Form Validation</span>
                    </a>
                </li>
            </ul>
        </li><!-- End Forms Nav -->

        <li class="nav-item">
            <a class="nav-link {{ in_array(Route::currentRouteName(), ['tables-general', 'tables-data']) ? '' : 'collapsed' }}" data-bs-target="#tables-nav" data-bs-toggle="collapse" href="#">
                <i class="bi bi-layout-text-window-reverse"></i><span>Tables</span><i class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="tables-nav" class="nav-content collapse {{ in_array(Route::currentRouteName(), ['tables-general', 'tables-data']) ? 'show' : '' }}" data-bs-parent="#sidebar-nav">
                <li>
                    <a href="tables-general.html" class="{{ Route::currentRouteName() == 'tables-general' ? 'active' : '' }}">
                        <i class="bi bi-circle"></i><span>General Tables</span>
                    </a>
                </li>
                <li>
                    <a href="tables-data.html" class="{{ Route::currentRouteName() == 'tables-data' ? 'active' : '' }}">
                        <i class="bi bi-circle"></i><span>Data Tables</span>
                    </a>
                </li>
            </ul>
        </li><!-- End Tables Nav -->

        <li class="nav-item">
            <a class="nav-link {{ in_array(Route::currentRouteName(), ['charts-chartjs', 'charts-apexcharts', 'charts-echarts']) ? '' : 'collapsed' }}" data-bs-target="#charts-nav" data-bs-toggle="collapse" href="#">
                <i class="bi bi-bar-chart"></i><span>Charts</span><i class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="charts-nav" class="nav-content collapse {{ in_array(Route::currentRouteName(), ['charts-chartjs', 'charts-apexcharts', 'charts-echarts']) ? 'show' : '' }}" data-bs-parent="#sidebar-nav">
                <li>
                    <a href="charts-chartjs.html" class="{{ Route::currentRouteName() == 'charts-chartjs' ? 'active' : '' }}">
                        <i class="bi bi-circle"></i><span>Chart.js</span>
                    </a>
                </li>
                <li>
                    <a href="charts-apexcharts.html" class="{{ Route::currentRouteName() == 'charts-apexcharts' ? 'active' : '' }}">
                        <i class="bi bi-circle"></i><span>ApexCharts</span>
                    </a>
                </li>
                <li>
                    <a href="charts-echarts.html" class="{{ Route::currentRouteName() == 'charts-echarts' ? 'active' : '' }}">
                        <i class="bi bi-circle"></i><span>ECharts</span>
                    </a>
                </li>
            </ul>
        </li><!-- End Charts Nav -->

        <li class="nav-item">
            <a class="nav-link {{ in_array(Route::currentRouteName(), ['icons-bootstrap', 'icons-remix', 'icons-boxicons']) ? '' : 'collapsed' }}" data-bs-target="#icons-nav" data-bs-toggle="collapse" href="#">
                <i class="bi bi-gem"></i><span>Icons</span><i class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="icons-nav" class="nav-content collapse {{ in_array(Route::currentRouteName(), ['icons-bootstrap', 'icons-remix', 'icons-boxicons']) ? 'show' : '' }}" data-bs-parent="#sidebar-nav">
                <li>
                    <a href="icons-bootstrap.html" class="{{ Route::currentRouteName() == 'icons-bootstrap' ? 'active' : '' }}">
                        <i class="bi bi-circle"></i><span>Bootstrap Icons</span>
                    </a>
                </li>
                <li>
                    <a href="icons-remix.html" class="{{ Route::currentRouteName() == 'icons-remix' ? 'active' : '' }}">
                        <i class="bi bi-circle"></i><span>Remix Icons</span>
                    </a>
                </li>
                <li>
                    <a href="icons-boxicons.html" class="{{ Route::currentRouteName() == 'icons-boxicons' ? 'active' : '' }}">
                        <i class="bi bi-circle"></i><span>Boxicons</span>
                    </a>
                </li>
            </ul>
        </li><!-- End Icons Nav -->

        <li class="nav-heading">Pages</li>

        <li class="nav-item">
            <a class="nav-link {{ Route::currentRouteName() == 'users-profile' ? '' : 'collapsed' }}" href="users-profile.html">
                <i class="bi bi-person"></i>
                <span>Profile</span>
            </a>
        </li><!-- End Profile Page Nav -->

        <li class="nav-item">
            <a class="nav-link {{ Route::currentRouteName() == 'pages-faq' ? '' : 'collapsed' }}" href="pages-faq.html">
                <i class="bi bi-question-circle"></i>
                <span>F.A.Q</span>
            </a>
        </li><!-- End F.A.Q Page Nav -->

        <li class="nav-item">
            <a class="nav-link {{ Route::currentRouteName() == 'pages-contact' ? '' : 'collapsed' }}" href="pages-contact.html">
                <i class="bi bi-envelope"></i>
                <span>Contact</span>
            </a>
        </li><!-- End Contact Page Nav -->

        <li class="nav-item">
            <a class="nav-link {{ Route::currentRouteName() == 'pages-register' ? '' : 'collapsed' }}" href="pages-register.html">
                <i class="bi bi-card-list"></i>
                <span>Register</span>
            </a>
        </li><!-- End Register Page Nav -->

        <li class="nav-item">
            <a class="nav-link {{ Route::currentRouteName() == 'pages-login' ? '' : 'collapsed' }}" href="pages-login.html">
                <i class="bi bi-box-arrow-in-right"></i>
                <span>Login</span>
            </a>
        </li><!-- End Login Page Nav -->

        <li class="nav-item">
            <a class="nav-link {{ Route::currentRouteName() == 'pages-error-404' ? '' : 'collapsed' }}" href="pages-error-404.html">
                <i class="bi bi-dash-circle"></i>
                <span>Error 404</span>
            </a>
        </li><!-- End Error 404 Page Nav -->

        <li class="nav-item">
            <a class="nav-link {{ Route::currentRouteName() == 'pages-blank' ? '' : 'collapsed' }}" href="pages-blank.html">
                <i class="bi bi-file-earmark"></i>
                <span>Blank</span>
            </a>
        </li><!-- End Blank Page Nav -->

    </ul>

</aside><!-- End Sidebar-->
