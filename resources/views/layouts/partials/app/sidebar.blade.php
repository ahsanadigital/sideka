<ul id="sidebarnav">
    <!-- ============================= -->
    <!-- Home -->
    <!-- ============================= -->
    <li class="nav-small-cap">
        <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
        <span class="hide-menu">Dasbor</span>
    </li>

    <li class="sidebar-item {{ request()->routeIs('home') }}">
        <a class="sidebar-link" href="{{ route('home') }}" aria-expanded="false">
            <span>
                <i class="ti ti-home"></i>
            </span>
            <span class="hide-menu">Dasbor</span>
        </a>
    </li>

    <!-- ============================= -->
    <!-- Manajemen Dewan Kerja -->
    <!-- ============================= -->
    <li class="nav-small-cap">
        <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
        <span class="hide-menu">Manajemen Dewan Kerja</span>
    </li>

    <!-- ============================= -->
    <!-- Pengaturan dan Tentang -->
    <!-- ============================= -->
    <li class="nav-small-cap">
        <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
        <span class="hide-menu">Informasi dan Pengguna</span>
    </li>

    <li class="sidebar-item">
        <a class="sidebar-link" href="#" aria-expanded="false">
            <span>
                <i class="ti ti-home"></i>
            </span>
            <span class="hide-menu">Dasbor</span>
        </a>
    </li>
</ul>
