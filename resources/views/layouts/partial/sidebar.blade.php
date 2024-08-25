<!-- ======= Sidebar ======= -->
<aside id="sidebar" class="sidebar">
    @admin
        @include('layouts.partial.menu.menu_admin')
    @endadmin

    @cluster
        @include('layouts.partial.menu.menu_cluster')
    @endcluster

    @depo
        @include('layouts.partial.menu.menu_depo')
    @enddepo

</aside><!-- End Sidebar-->
