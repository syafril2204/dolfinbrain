<aside class="left-sidebar">
    <div>
        <div class="brand-logo d-flex align-items-center justify-content-between">
            <a href="{{ route('dashboard') }}" class="text-nowrap logo-img" wire:navigate>
                <h3 class="fw-bolder ps-4 pt-2">Dolfin Brain</h3>
            </a>
            <div class="close-btn d-lg-none d-block sidebartoggler cursor-pointer" id="sidebarCollapse">
                <i class="ti ti-x fs-8 text-muted"></i>
            </div>
        </div>

        <nav class="sidebar-nav scroll-sidebar" data-simplebar>
            <ul id="sidebarnav">

                {{-- ========== MENU UTAMA ========= --}}
                <li class="nav-small-cap">
                    <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                    <span class="hide-menu">Menu Utama</span>
                </li>

                <li class="sidebar-item">
                    <a class="sidebar-link {{ request()->routeIs('dashboard') ? 'active' : '' }}"
                        href="{{ route('dashboard') }}" wire:navigate aria-expanded="false">
                        <span><i class="ti ti-home"></i></span>
                        <span class="hide-menu">Home</span>
                    </a>
                </li>

                {{-- ========== PENGATURAN STRUKTUR & PENGGUNA (ADMIN) ========= --}}
                @role('admin')
                    <li class="nav-small-cap mt-4">
                        <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                        <span class="hide-menu">Struktur & Pengguna</span>
                    </li>

                    <li class="sidebar-item">
                        <a class="sidebar-link {{ request()->routeIs('admin.formations.*', 'admin.positions.*') ? 'active' : '' }}"
                            href="{{ route('admin.formations.index') }}" wire:navigate aria-expanded="false">
                            <span><i class="ti ti-sitemap"></i></span>
                            <span class="hide-menu">Formasi & Posisi</span>
                        </a>
                    </li>
                    <li class="sidebar-item">
                        <a class="sidebar-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}"
                            href="{{ route('admin.users.index') }}" wire:navigate aria-expanded="false">
                            <span><i class="ti ti-users"></i></span>
                            <span class="hide-menu">Pengguna</span>
                        </a>
                    </li>

                    {{-- ========== KONTEN PEMBELAJARAN (ADMIN) ========= --}}
                    <li class="nav-small-cap mt-4">
                        <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                        <span class="hide-menu">Konten Pembelajaran</span>
                    </li>

                    <li class="sidebar-item">
                        <a class="sidebar-link {{ request()->routeIs('admin.materials.*') ? 'active' : '' }}"
                            href="{{ route('admin.materials.index') }}" wire:navigate aria-expanded="false">
                            <span><i class="ti ti-book"></i></span>
                            <span class="hide-menu">Materi</span>
                        </a>
                    </li>
                    <li class="sidebar-item">
                        <a class="sidebar-link {{ request()->routeIs('admin.quiz-packages.*') ? 'active' : '' }}"
                            href="{{ route('admin.quiz-packages.index') }}" wire:navigate aria-expanded="false">
                            <span><i class="ti ti-file-text"></i></span>
                            <span class="hide-menu">Kuis</span>
                        </a>
                    </li>
                    <li class="sidebar-item">
                        <a class="sidebar-link {{ request()->routeIs('admin.lms-spaces.*') ? 'active' : '' }}"
                            href="{{ route('admin.lms-spaces.index') }}" wire:navigate aria-expanded="false">
                            <span><i class="ti ti-device-laptop"></i></span>
                            <span class="hide-menu">LMS Space</span>
                        </a>
                    </li>
                    <li class="nav-small-cap">
                        <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                        <span class="hide-menu">Akun Saya</span>
                    </li>

                    <li class="sidebar-item">
                        <a class="sidebar-link {{ request()->routeIs('students.profile.update') ? 'active' : '' }}"
                            href="{{ route('students.profile.update') }}" wire:navigate aria-expanded="false">
                            <span><i class="ti ti-user-circle"></i></span>
                            <span class="hide-menu">Profil</span>
                        </a>
                    </li>
                @endrole

                {{-- ========== MENU SISWA (DENGAN KONDISI CEK PROFIL) ========= --}}
                @role('student')
                    {{-- Kondisi jika user belum melengkapi profil (position_id == null) --}}
                    @if (is_null(auth()->user()->position_id))
                        <li class="nav-small-cap mt-4">
                            <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                            <span class="hide-menu">Pembelajaran Siswa</span>
                        </li>
                        <li class="sidebar-item">
                            <a class="sidebar-link" style="cursor: not-allowed;"
                                onclick="alert('Harap lengkapi profil serta formasi Anda untuk mengakses menu ini.')"
                                aria-expanded="false">
                                <span><i class="ti ti-lock"></i></span>
                                <span class="hide-menu">Beli Paket</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a class="sidebar-link" style="cursor: not-allowed;"
                                onclick="alert('Harap lengkapi profil serta formasi Anda untuk mengakses menu ini.')"
                                aria-expanded="false">
                                <span><i class="ti ti-lock"></i></span>
                                <span class="hide-menu">Paket Saya</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a class="sidebar-link" style="cursor: not-allowed;"
                                onclick="alert('Harap lengkapi profil serta formasi Anda untuk mengakses menu ini.')"
                                aria-expanded="false">
                                <span><i class="ti ti-lock"></i></span>
                                <span class="hide-menu">Materi</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a class="sidebar-link" style="cursor: not-allowed;"
                                onclick="alert('Harap lengkapi profil serta formasi Anda untuk mengakses menu ini.')"
                                aria-expanded="false">
                                <span><i class="ti ti-lock"></i></span>
                                <span class="hide-menu">Soal</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a class="sidebar-link" style="cursor: not-allowed;"
                                onclick="alert('Harap lengkapi profil serta formasi Anda untuk mengakses menu ini.')"
                                aria-expanded="false">
                                <span><i class="ti ti-lock"></i></span>
                                <span class="hide-menu">LMS Space</span>
                            </a>
                        </li>
                        <li class="nav-small-cap mt-4">
                            <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                            <span class="hide-menu">Akun Saya</span>
                        </li>
                        <li class="sidebar-item">
                            <a class="sidebar-link" style="cursor: not-allowed;"
                                onclick="alert('Harap lengkapi profil serta formasi Anda untuk mengakses menu ini.')"
                                aria-expanded="false">
                                <span><i class="ti ti-lock"></i></span>
                                <span class="hide-menu">History Pembelian</span>
                            </a>
                        </li>
                        {{-- Menu Profil TETAP AKTIF agar user bisa melengkapi profilnya --}}
                        <li class="sidebar-item">
                            <a class="sidebar-link {{ request()->routeIs('students.profile.index') ? 'active' : '' }}"
                                href="{{ route('students.profile.index') }}" wire:navigate aria-expanded="false">
                                <span><i class="ti ti-user-circle"></i></span>
                                <span class="hide-menu">Profil</span>
                            </a>
                        </li>

                        {{-- Kondisi jika user SUDAH melengkapi profil (menu normal) --}}
                    @else
                        <li class="nav-small-cap mt-4">
                            <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                            <span class="hide-menu">Pembelajaran Siswa</span>
                        </li>
                        <li class="sidebar-item">
                            <a class="sidebar-link {{ request()->routeIs('students.packages.index') ? 'active' : '' }}"
                                href="{{ route('students.packages.index') }}" wire:navigate aria-expanded="false">
                                <span><i class="ti ti-shopping-cart"></i></span>
                                <span class="hide-menu">Beli Paket</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a class="sidebar-link {{ request()->routeIs('students.my-packages.index') ? 'active' : '' }}"
                                href="{{ route('students.my-packages.index') }}" wire:navigate aria-expanded="false">
                                <span><i class="ti ti-wallet"></i></span>
                                <span class="hide-menu">Paket Saya</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a class="sidebar-link {{ request()->routeIs('students.materi.index') ? 'active' : '' }}"
                                href="{{ route('students.materi.index') }}" wire:navigate aria-expanded="false">
                                <span><i class="ti ti-book"></i></span>
                                <span class="hide-menu">Materi</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a class="sidebar-link {{ request()->routeIs('students.soal.*') ? 'active' : '' }}"
                                href="{{ route('students.soal.index') }}" wire:navigate aria-expanded="false">
                                <span><i class="ti ti-file-text"></i></span>
                                <span class="hide-menu">Soal</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a class="sidebar-link {{ request()->routeIs('students.lms.*') ? 'active' : '' }}"
                                href="{{ route('students.lms.index') }}" wire:navigate aria-expanded="false">
                                <span><i class="ti ti-layout-grid"></i></span>
                                <span class="hide-menu">LMS Space</span>
                            </a>
                        </li>
                        <li class="nav-small-cap mt-4">
                            <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                            <span class="hide-menu">Akun Saya</span>
                        </li>
                        <li class="sidebar-item">
                            <a class="sidebar-link {{ request()->routeIs('students.transactions.index') ? 'active' : '' }}"
                                href="{{ route('students.transactions.index') }}" wire:navigate aria-expanded="false">
                                <span><i class="ti ti-receipt"></i></span>
                                <span class="hide-menu">History Pembelian</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a class="sidebar-link {{ request()->routeIs('students.profile.index') ? 'active' : '' }}"
                                href="{{ route('students.profile.index') }}" wire:navigate aria-expanded="false">
                                <span><i class="ti ti-user-circle"></i></span>
                                <span class="hide-menu">Profil</span>
                            </a>
                        </li>
                    @endif
                @endrole
            </ul>

            {{-- LOGOUT --}}
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
