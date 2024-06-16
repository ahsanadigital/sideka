<ul id="sidebarnav">
    <!-- ============================= -->
    <!-- Home -->
    <!-- ============================= -->
    <li class="nav-small-cap">
        <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
        <span class="hide-menu">Dasbor</span>
    </li>

    <li class="sidebar-item {{ request()->routeIs('home') ? 'active' : '' }}">
        <a class="sidebar-link" href="{{ route('home') }}" aria-expanded="false">
            <span>
                <i class="ti ti-home"></i>
            </span>
            <span class="hide-menu">Dasbor</span>
        </a>
    </li>

    @role('region')
    <!-- ============================= -->
    <!-- Master Data -->
    <!-- ============================= -->
    <li class="nav-small-cap">
        <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
        <span class="hide-menu">Master Data</span>
    </li>

    <li class="sidebar-item {{ request()->routeIs('council-category.*') ? 'active' : '' }}">
        <a class="sidebar-link" href="{{ route('council-category.index') }}" aria-expanded="false">
            <span>
                <i class="ti ti-package"></i>
            </span>
            <span class="hide-menu">Kategori Data</span>
        </a>
    </li>

    <li class="sidebar-item {{ request()->routeIs('user.*') ? 'active' : '' }}">
        <a class="sidebar-link" href="{{ route('user.index') }}" aria-expanded="false">
            <span>
                <i class="ti ti-users"></i>
            </span>
            <span class="hide-menu">Pengguna</span>
        </a>
    </li>

    <li class="sidebar-item disabled">
        <a class="sidebar-link disabled" href="#" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-title="Fitur ini masih belum tersedia." aria-expanded="false">
            <span>
                <i class="ti ti-stack"></i>
            </span>
            <span class="hide-menu">SPK</span>
        </a>
    </li>
    @endif

    <!-- ============================= -->
    <!-- Aktivitas Dewan Kerja -->
    <!-- ============================= -->
    <li class="nav-small-cap">
        <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
        <span class="hide-menu">Aktivitas Dewan Kerja</span>
    </li>

    <li class="sidebar-item {{ request()->routeIs('decree.*') ? 'active' : '' }}">
        <a class="sidebar-link" href="{{ route('decree.index') }}" aria-expanded="false">
            <span>
                <i class="ti ti-file-type-pdf"></i>
            </span>
            <span class="hide-menu">Surat Keputusan</span>
        </a>
    </li>

    <li class="sidebar-item {{ request()->routeIs('meeting.*') ? 'active' : '' }}">
        <a class="sidebar-link" href="{{ route('meeting.index') }}" aria-expanded="false">
            <span>
                <i class="ti ti-messages"></i>
            </span>
            <span class="hide-menu">Pertemuan</span>
        </a>
    </li>

    <li class="sidebar-item {{ request()->routeIs('letter.*') ? 'active' : '' }}">
        <a class="sidebar-link" href="{{ route('letter.index') }}" aria-expanded="false">
            <span>
                <i class="ti ti-file"></i>
            </span>
            <span class="hide-menu">Surat-Menyurat</span>
        </a>
    </li>
{{--
    <li class="sidebar-item {{ request()->routeIs('council.*') ? 'active' : '' }}">
        <a class="sidebar-link" href="{{ route('council.index') }}" aria-expanded="false">
            <span>
                <i class="ti ti-building"></i>
            </span>
            <span class="hide-menu">Kwartir</span>
        </a>
    </li> --}}

    <!-- ============================= -->
    <!-- Manajemen Dewan Kerja -->
    <!-- ============================= -->
    <li class="nav-small-cap">
        <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
        <span class="hide-menu">Manajemen Dewan Kerja</span>
    </li>

    <li class="sidebar-item {{ request()->routeIs('event-*') ? 'active' : '' }}">
        <a class="sidebar-link has-arrow" href="javascript:void(0)" aria-expanded="false">
            <span class="d-flex">
                <i class="ti ti-run"></i>
            </span>
            <span class="hide-menu">Kegiatan</span>
        </a>
        <ul aria-expanded="false" class="collapse {{ request()->routeIs('event-*') ? 'in' : '' }} first-level">
            <li class="sidebar-item">
                <a href="{{ route('event-report.index') }}" class="sidebar-link">
                    <div class="round-16 d-flex align-items-center justify-content-center">
                        <i class="ti ti-circle"></i>
                    </div>
                    <span class="hide-menu">Laporan Giat</span>
                </a>
            </li>
            <li class="sidebar-item">
                <a href="{{ route('event-agenda.index') }}" class="sidebar-link">
                    <div class="round-16 d-flex align-items-center justify-content-center">
                        <i class="ti ti-circle"></i>
                    </div>
                    <span class="hide-menu">Agenda Kegiatan</span>
                </a>
            </li>
        </ul>
    </li>

    <li class="sidebar-item {{ request()->routeIs('member.*') ? 'active' : '' }}">
        <a class="sidebar-link" href="{{ route('member.index') }}" aria-expanded="false">
            <span>
                <i class="ti ti-users"></i>
            </span>
            <span class="hide-menu">Keanggotaan</span>
        </a>
    </li>

    <li class="sidebar-item {{ request()->routeIs('member.*') ? 'active' : '' }}">
        <a class="sidebar-link" href="{{ route('member.index') }}" aria-expanded="false">
            <span>
                <i class="ti ti-plane-tilt"></i>
            </span>
            <span class="hide-menu">Delegasi</span>
        </a>
    </li>

    <li class="sidebar-item {{ request()->routeIs('achievement.*') ? 'active' : '' }}">
        <a class="sidebar-link" href="{{ route('achievement.index') }}" aria-expanded="false">
            <span>
                <i class="ti ti-trophy"></i>
            </span>
            <span class="hide-menu">Prestasi</span>
        </a>
    </li>

    <!-- ============================= -->
    <!-- Pengaturan dan Tentang -->
    <!-- ============================= -->
    <li class="nav-small-cap">
        <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
        <span class="hide-menu">Informasi</span>
    </li>

    <li class="sidebar-item">
        <a class="sidebar-link" href="#" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-title="Fitur ini masih belum tersedia." aria-expanded="false">
            <span>
                <i class="ti ti-history"></i>
            </span>
            <span class="hide-menu">Riwayat Aktivitas</span>
        </a>
    </li>

    <li class="sidebar-item">
        <a class="sidebar-link" href="#" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-title="Fitur ini masih belum tersedia." aria-expanded="false">
            <span>
                <i class="ti ti-history"></i>
            </span>
            <span class="hide-menu">Riwayat Autentikasi</span>
        </a>
    </li>

    <li class="sidebar-item">
        <a class="sidebar-link" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-title="Fitur ini masih belum tersedia." aria-expanded="false">
            <span>
                <i class="ti ti-info-circle"></i>
            </span>
            <span class="hide-menu">Tentang Aplikasi</span>
        </a>
    </li>
</ul>
