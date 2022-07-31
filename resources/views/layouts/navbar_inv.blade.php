<nav class="topnav navbar navbar-expand shadow navbar-light bg-white" id="sidenavAccordion">
    <a class="navbar-brand" href="#">
        <i class="fas fa-boxes mr-3"></i>
        Sistem Inventory
    </a>
    <button class="btn btn-icon btn-transparent-dark order-1 order-lg-0 mr-lg-2" id="sidebarToggle" href="#"><i
            data-feather="menu"></i></button>
    <ul class="navbar-nav align-items-center ml-auto">
        <li class="nav-item dropdown no-caret mr-2 dropdown-user">

            <a class="btn btn-icon btn-transparent-dark dropdown-toggle" id="navbarDropdownUserImage"
                href="javascript:void(0);" role="button" data-toggle="dropdown" aria-haspopup="true"
                aria-expanded="false"><img class="img-fluid"
                    src="/template/src/assets/img/freepik/profiles/profile-6.png" />
            </a>
            <div class="dropdown-menu dropdown-menu-right border-0 shadow animated--fade-in-up"
                aria-labelledby="navbarDropdownUserImage">
                <h6 class="dropdown-header d-flex align-items-center">
                    <img class="dropdown-user-img" src="/template/src/assets/img/freepik/profiles/profile-6.png" />
                    <div class="dropdown-user-details">
                        <div class="dropdown-user-details-name">Welcome,</div>
                        <div class="dropdown-user-details-email">{{ Auth::user()->nama_panggilan }}</div>
                    </div>
                </h6>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="#">
                    <div class="dropdown-item-icon"><i data-feather="columns"></i></div>
                    Dashboard Inventory
                </a>
                
                <a class="dropdown-item" href="{{ route('dashboard-penjualan-owner') }}">
                    <div class="dropdown-item-icon"><i data-feather="columns"></i></div>
                    Dashboard Penjualan
                </a>
               

                <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                        document.getElementById('logout-form').submit();">
                    <div class="dropdown-item-icon"><i data-feather="log-out"></i></div>
                    Logout
                </a>

                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </div>
        </li>
    </ul>
</nav>

<div id="layoutSidenav">
    <div id="layoutSidenav_nav">
        <nav class="sidenav shadow-right sidenav-light">
            <div class="sidenav-menu">
                <div class="nav accordion" id="accordionSidenav">
                    <div class="sidenav-menu-heading">Dashboard</div>

                    <a class="nav-link" href="{{ route('dashboard') }}">
                        <div class="nav-link-icon"><i class="fas fa-warehouse"></i></div>
                        Dashboard
                    </a>

                    <div class="sidenav-menu-heading">Master Data</div>
                    <a class="nav-link collapsed" href="javascript:void(0);" data-toggle="collapse"
                        data-target="#collapseDashboards" aria-expanded="false" aria-controls="collapseDashboards">
                        <div class="nav-link-icon"><i class="fas fa-database"></i></div>
                        Master Data
                        <div class="sidenav-collapse-arrow">
                            <i class="fas fa-angle-down"></i>
                        </div>
                    </a>
                    <div class="collapse .allow-focus" id="collapseDashboards" data-parent="#accordionSidenav">
                        <nav class="sidenav-menu-nested nav accordion" id="accordionSidenavPages">
                            <a class="nav-link" href="{{ route('master-user.index') }}">
                                Pegawai
                            </a>
                            <a class="nav-link" href="{{ route('master-jenis-supplier.index') }}">
                                Jenis Supplier
                            </a>
                            <a class="nav-link" href="{{ route('master-supplier.index') }}">
                                Supplier
                            </a>
                            <a class="nav-link" href="{{ route('master-kategori.index') }}">
                                Kategori
                            </a>
                            <a class="nav-link" href="{{ route('master-produk.index') }}">
                                Produk
                            </a>
                        </nav>
                    </div>


                    <div class="sidenav-menu-heading">Inventory System</div>
                    <a class="nav-link collapsed" href="javascript:void(0);" data-toggle="collapse"
                        data-target="#collapseUtilities" aria-expanded="false" aria-controls="collapseUtilities">
                        <div class="nav-link-icon">
                            <i class="fas fa-cubes"></i>
                        </div>
                        Inventory
                        <div class="sidenav-collapse-arrow">
                            <i class="fas fa-angle-down"></i>
                        </div>
                    </a>
                    <div class="collapse" id="collapseUtilities" data-parent="#accordionSidenav" style="">
                        <nav class="sidenav-menu-nested nav">
                            <a class="nav-link" href="{{ route('pembelian.index') }}">
                                Pembelian
                            </a>
                            <a class="nav-link " href="{{ route('penerimaan.index') }}">
                                Penerimaan
                            </a>
                        </nav>
                    </div>
                    <div class="sidenav-menu-heading">Kelola Stok</div>
                    <a class="nav-link collapsed" href="javascript:void(0);" data-toggle="collapse"
                        data-target="#collapseComponents" aria-expanded="false" aria-controls="collapseComponents">
                        <div class="nav-link-icon"><i class="fas fa-box-open"></i></div>
                        Kelola Stok
                        <div class="sidenav-collapse-arrow">
                            <i class="fas fa-angle-down"></i>
                        </div>
                    </a>
                    <div class="collapse" id="collapseComponents" data-parent="#accordionSidenav">
                        <nav class="sidenav-menu-nested nav">
                            <a class="nav-link " href="{{ route('kartu-gudang.index') }}">
                                Kartu Gudang
                            </a>
                        </nav>
                    </div>

                    @if (Auth::user()->role == 'Owner')
                    <div class="sidenav-menu-heading">Pelaporan</div>
                    <a class="nav-link collapsed" href="javascript:void(0);" data-toggle="collapse"
                        data-target="#collapseLayouts" aria-expanded="false" aria-controls="collapseLayouts">
                        <div class="nav-link-icon"><i data-feather="check-square"></i></div>
                        Laporan Pembelian
                        <div class="sidenav-collapse-arrow">
                            <i class="fas fa-angle-down">
                            </i></div>
                    </a>
                    <div class="collapse" id="collapseLayouts" data-parent="#accordionSidenav">
                        <nav class="sidenav-menu-nested nav accordion" id="accordionSidenavLayout">
                            <a class="nav-link" href="{{ route('laporan-pembelian-harian.index') }}">
                                Laporan Harian
                            </a>
                            <a class="nav-link" href="{{ route('laporan-pembelian.index') }}">
                                Laporan Keseluruhan
                            </a>
                            <a class="nav-link" href="{{ route('laporan-pembelian-bulanan.index') }}">
                                Laporan Bulanan
                            </a>
                        </nav>
                    </div>
                    @endif

                    @if (Auth::user()->role == 'Owner' || Auth::user()->role == 'Admin')
                    <div class="sidenav-menu-heading">System Penjualan</div>
                    <a class="nav-link" href="{{ route('dashboard-penjualan-owner') }}">
                        <div class="nav-link-icon"><i data-feather="log-out"></i></div>
                        Menuju Penjualan
                    </a>
                    @endif


                </div>

            </div>

            {{-- USER ROLE Side Bar --}}
            <div class="sidenav-footer">
                <div class="sidenav-footer-content">
                    <div class="sidenav-footer-subtitle">Role :</div>
                    <div class="sidenav-footer-title">{{ Auth::user()->role }}</div>
                </div>
            </div>
        </nav>
    </div>
