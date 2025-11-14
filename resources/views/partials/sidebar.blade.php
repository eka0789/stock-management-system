<aside class="main-sidebar sidebar-dark-primary elevation-4">

    {{-- BRAND --}}
    <a href="/" class="brand-link text-center">
        <span class="brand-text fw-bold">{{ config('app.name') }}</span>
    </a>

    <div class="sidebar">

        {{-- USER PANEL --}}
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="info">
                <span class="d-block text-white fw-bold">{{ auth()->user()->name }}</span>
                <small class="text-muted">{{ ucfirst(auth()->user()->role) }}</small>
            </div>
        </div>

        {{-- NAVIGATION --}}
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column"
                data-widget="treeview"
                role="menu"
                data-accordion="false">

                {{-- =========================
                    DASHBOARD (Role-based)
                ========================== --}}
                @if(auth()->user()->role === 'admin')
                    <li class="nav-item">
                        <a href="{{ route('admin.dashboard') }}"
                           class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-chart-line"></i>
                            <p>Dashboard Admin</p>
                        </a>
                    </li>
                @endif

                @if(auth()->user()->role === 'leader')
                    <li class="nav-item">
                        <a href="{{ route('leader.dashboard') }}"
                           class="nav-link {{ request()->routeIs('leader.dashboard') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-coffee"></i>
                            <p>Dashboard Leader</p>
                        </a>
                    </li>
                @endif

                @if(auth()->user()->role === 'finance')
                    <li class="nav-item">
                        <a href="{{ route('finance.dashboard') }}"
                           class="nav-link {{ request()->routeIs('finance.dashboard') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-file-invoice-dollar"></i>
                            <p>Dashboard Finance</p>
                        </a>
                    </li>
                @endif


                {{-- =========================
                    ADMIN MENU
                ========================== --}}
                @if(auth()->user()->role === 'admin')

                    <li class="nav-header text-secondary text-uppercase small">DATA MASTER</li>

                    <li class="nav-item">
                        <a href="{{ route('admin.users.index') }}"
                           class="nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-users-cog"></i>
                            <p>Manajemen Pengguna</p>
                        </a>
                    </li>

                    {{-- Items & Stock --}}
                    <li class="nav-item {{ request()->is('admin/items*') || request()->is('admin/stock-transactions*') ? 'menu-open' : '' }}">
                        <a class="nav-link {{ request()->is('admin/items*') || request()->is('admin/stock-transactions*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-boxes"></i>
                            <p>
                                Bahan & Stok
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>

                        <ul class="nav nav-treeview">

                            <li class="nav-item">
                                <a href="{{ route('admin.items.index') }}"
                                   class="nav-link {{ request()->routeIs('admin.items.*') ? 'active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Daftar Bahan</p>
                                </a>
                            </li>

                            <li class="nav-item">
                                <a href="{{ route('admin.stock_transactions.index') }}"
                                   class="nav-link {{ request()->routeIs('admin.stock_transactions.index') ? 'active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Riwayat Stok</p>
                                </a>
                            </li>

                            <li class="nav-item">
                                <a href="{{ route('admin.stock_transactions.create_manual') }}"
                                   class="nav-link {{ request()->routeIs('admin.stock_transactions.create_manual') ? 'active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Input Stok Manual</p>
                                </a>
                            </li>

                        </ul>
                    </li>

                    {{-- Request Approval --}}
                    <li class="nav-item">
                        <a href="{{ route('admin.requests.index') }}"
                           class="nav-link {{ request()->routeIs('admin.requests.*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-check-circle"></i>
                            <p>Verifikasi Permintaan</p>
                        </a>
                    </li>

                @endif


                {{-- =========================
                    LEADER MENU
                ========================== --}}
                @if(auth()->user()->role === 'leader')

                    <li class="nav-header text-secondary text-uppercase small">PERMINTAAN BAHAN</li>

                    <li class="nav-item">
                        <a href="{{ route('leader.requests.index') }}"
                           class="nav-link {{ request()->routeIs('leader.requests.*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-clipboard-list"></i>
                            <p>Permintaan Saya</p>
                        </a>
                    </li>

                    {{-- Browse stock --}}
                    <li class="nav-item">
                        <a href="{{ route('items.public.index') }}"
                           class="nav-link {{ request()->routeIs('items.public.*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-box-open"></i>
                            <p>Lihat Stok</p>
                        </a>
                    </li>

                @endif


                {{-- =========================
                    FINANCE MENU
                ========================== --}}
                @if(auth()->user()->role === 'finance')

                    <li class="nav-header text-secondary text-uppercase small">PURCHASE ORDER</li>

                    <li class="nav-item">
                        <a href="{{ route('finance.po.index') }}"
                           class="nav-link {{ request()->routeIs('finance.po.*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-file-invoice"></i>
                            <p>Purchase Order</p>
                        </a>
                    </li>

                @endif


                {{-- =========================
                    REPORTS (ADMIN ONLY)
                ========================== --}}
                @if(auth()->user()->role === 'admin')

                    <li class="nav-header text-secondary text-uppercase small">LAPORAN</li>

                    <li class="nav-item {{ request()->is('admin/reports/*') ? 'menu-open' : '' }}">
                        <a class="nav-link {{ request()->is('admin/reports/*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-chart-pie"></i>
                            <p>
                                Semua Laporan
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>

                        <ul class="nav nav-treeview">

                            <li class="nav-item">
                                <a href="{{ route('admin.reports.dashboard') }}"
                                   class="nav-link {{ request()->routeIs('admin.reports.dashboard') ? 'active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Dashboard Statistik</p>
                                </a>
                            </li>

                            <li class="nav-item">
                                <a href="{{ route('admin.reports.stock') }}"
                                   class="nav-link {{ request()->routeIs('admin.reports.stock') ? 'active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Laporan Stok</p>
                                </a>
                            </li>

                            <li class="nav-item">
                                <a href="{{ route('admin.reports.movement') }}"
                                   class="nav-link {{ request()->routeIs('admin.reports.movement') ? 'active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Laporan Penggunaan</p>
                                </a>
                            </li>

                            <li class="nav-item">
                                <a href="{{ route('admin.reports.request') }}"
                                   class="nav-link {{ request()->routeIs('admin.reports.request') ? 'active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Laporan Permintaan</p>
                                </a>
                            </li>

                            <li class="nav-item">
                                <a href="{{ route('admin.reports.po') }}"
                                   class="nav-link {{ request()->routeIs('admin.reports.po') ? 'active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Laporan Pembelian</p>
                                </a>
                            </li>

                        </ul>
                    </li>

                @endif


                {{-- =========================
                    LOGOUT
                ========================== --}}
                <li class="nav-item mt-3">
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button class="nav-link btn btn-danger text-start w-100">
                            <i class="nav-icon fas fa-sign-out-alt"></i>
                            <p>Logout</p>
                        </button>
                    </form>
                </li>

            </ul>
        </nav>
    </div>

</aside>
