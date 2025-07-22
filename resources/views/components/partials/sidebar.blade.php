<aside class="left-sidebar">
    {{-- Sidebar scroll --}}
    <div>
        <div class="brand-logo d-flex align-items-center justify-content-between">
            <a href="{{ route('dashboard') }}" class="text-nowrap logo-img" wire:navigate>
                <h3 class="fw-bolder ps-4 pt-2">Dolfin Brain</h3>
            </a>
            <div class="close-btn d-lg-none d-block sidebartoggler cursor-pointer" id="sidebarCollapse">
                <i class="ti ti-x fs-8 text-muted"></i>
            </div>
        </div>

        {{-- Navigasi Sidebar --}}
        <nav class="sidebar-nav scroll-sidebar" data-simplebar>
            <ul id="sidebarnav">
                <li class="sidebar-item">
                    <a class="sidebar-link {{ request()->routeIs('dashboard') ? 'active' : '' }}"
                        href="{{ route('dashboard') }}" wire:navigate aria-expanded="false">
                        <span><i class="ti ti-home"></i></span>
                        <span class="hide-menu">Home</span>
                    </a>
                </li>

                {{-- =================================== --}}
                {{--         MENU UNTUK ADMIN            --}}
                {{-- =================================== --}}
                @role('admin')
                    <li class="sidebar-item">
                        <a class="sidebar-link {{ request()->routeIs('admin.formations.*', 'admin.positions.*') ? 'active' : '' }}"
                            href="{{ route('admin.formations.index') }}" wire:navigate aria-expanded="false">
                            <span><i class="ti ti-sitemap"></i></span>
                            <span class="hide-menu">Manajemen Formasi</span>
                        </a>
                    </li>
                    <li class="sidebar-item">
                        <a class="sidebar-link {{ request()->routeIs('admin.materials.*') ? 'active' : '' }}"
                            href="{{ route('admin.materials.index') }}" wire:navigate aria-expanded="false">
                            <span><i class="ti ti-book"></i></span>
                            <span class="hide-menu">Manajemen Materi</span>
                        </a>
                    </li>
                @endrole

                {{-- =================================== --}}
                {{--         MENU UNTUK STUDENT          --}}
                {{-- =================================== --}}
                @role('student')
                    <li class="sidebar-item">
                        <a class="sidebar-link {{ request()->routeIs('beli-paket') ? 'active' : '' }}" href="#"
                            aria-expanded="false">
                            <span><i class="ti ti-shopping-cart"></i></span>
                            <span class="hide-menu">Beli Paket</span>
                        </a>
                    </li>
                    <li class="sidebar-item">
                        <a class="sidebar-link {{ request()->routeIs('paket-saya') ? 'active' : '' }}" href="#"
                            aria-expanded="false">
                            <span><i class="ti ti-wallet"></i></span>
                            <span class="hide-menu">Paket Saya</span>
                        </a>
                    </li>
                    <li class="sidebar-item">
                        <a class="sidebar-link {{ request()->routeIs('materi') ? 'active' : '' }}" href="#"
                            aria-expanded="false">
                            <span><i class="ti ti-book"></i></span>
                            <span class="hide-menu">Materi</span>
                        </a>
                    </li>
                    <li class="sidebar-item">
                        <a class="sidebar-link {{ request()->routeIs('soal') ? 'active' : '' }}" href="#"
                            aria-expanded="false">
                            <span><i class="ti ti-file-text"></i></span>
                            <span class="hide-menu">Soal</span>
                        </a>
                    </li>
                    <li class="sidebar-item">
                        <a class="sidebar-link {{ request()->routeIs('lms-space') ? 'active' : '' }}" href="#"
                            aria-expanded="false">
                            <span><i class="ti ti-layout-grid"></i></span>
                            <span class="hide-menu">LMS Space</span>
                        </a>
                    </li>
                    <li class="sidebar-item">
                        <a class="sidebar-link {{ request()->routeIs('profile') ? 'active' : '' }}" href="#"
                            aria-expanded="false">
                            <span><i class="ti ti-user-circle"></i></span>
                            <span class="hide-menu">Profile</span>
                        </a>
                    </li>
                @endrole
            </ul>

            {{-- 👇 Tombol Logout Dikembalikan ke Versi Awal --}}
            <div class="logout-wrapper px-4 mt-auto">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="btn btn-outline-danger w-100">
                        <i class="ti ti-logout me-2"></i>
                        Keluar
                    </button>
                </form>
            </div>
        </nav>
    </div>
</aside>

@push('styles')
    <style>
        aside.left-sidebar .sidebar-nav ul .sidebar-item .sidebar-link.active,
        .sidebar-nav ul .sidebar-item.selected>.sidebar-link.active {
            background-color: #eef5ff !important;
            color: #5D87FF !important;
            border-left: 4px solid #5D87FF !important;
            box-shadow: 0 4px 12px -2px rgba(93, 135, 255, 0.3) !important;
            font-weight: 600 !important;
        }

        aside.left-sidebar .sidebar-nav ul .sidebar-item .sidebar-link.active i,
        .sidebar-nav ul .sidebar-item.selected>.sidebar-link.active i {
            color: #5D87FF !important;
        }

        .scroll-sidebar {
            display: flex;
            flex-direction: column;
            height: calc(100vh - 100px);
        }

        .logout-wrapper {
            margin-top: auto;
            padding-bottom: 20px;
        }

        .sidebar-nav .sidebar-item {
            margin-bottom: 5px;
        }
    </style>
@endpush
