<aside class="main-sidebar sidebar-light-primary elevation-4">
    <a href="#" class="brand-link">
        <img src="{{ asset('images/admin.png') }}" alt="Logo" class="brand-image" style="opacity: .8">
        <span class="brand-text font-weight-bold">LaptopService</span>
    </a>

    <div class="sidebar">
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                
                <li class="nav-item">
                    <a href="{{ route('admin.MasterData.customers.index') }}" class="nav-link {{ request()->routeIs('admin.MasterData.customers.*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-user-friends"></i>
                        <p>Pelanggan</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('admin.MasterData.DeviceRepair.index') }}" class="nav-link {{ request()->routeIs('admin.MasterData.DeviceRepair.*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-desktop"></i>
                        <p>Perangkat</p>
                    </a>
                </li>

                <li class="nav-item has-treeview {{ request()->routeIs('admin.MasterData.Report.*') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ request()->routeIs('admin.MasterData.Report.*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-chart-bar"></i>
                        <p>
                            Laporan
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('admin.MasterData.Report.index') }}" class="nav-link {{ request()->routeIs('admin.MasterData.Report.index') ? 'active' : '' }}">
                                
                                <p>Dashboard Laporan</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.MasterData.Report.daily') }}" class="nav-link {{ request()->routeIs('admin.MasterData.Report.daily') ? 'active' : '' }}">
                                
                                <p>Laporan Harian</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.MasterData.Report.weekly') }}" class="nav-link {{ request()->routeIs('admin.MasterData.Report.weekly') ? 'active' : '' }}">
                                
                                <p>Laporan Mingguan</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.MasterData.Report.monthly') }}" class="nav-link {{ request()->routeIs('admin.MasterData.Report.monthly') ? 'active' : '' }}">
                                
                                <p>Laporan Bulanan</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.MasterData.Report.brand') }}" class="nav-link {{ request()->routeIs('admin.MasterData.Report.brand') ? 'active' : '' }}">
                                
                                <p>Laporan per Brand</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.MasterData.Report.history') }}" class="nav-link {{ request()->routeIs('admin.MasterData.Report.history') ? 'active' : '' }}">
                                
                                <p>Riwayat Semua Transaksi</p>
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </nav>
    </div>
</aside>