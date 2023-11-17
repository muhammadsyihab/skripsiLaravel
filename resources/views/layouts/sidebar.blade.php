        <div class="alert alert-danger" role="alert" id="alertPageMinimum" style="margin-top: 300px;">
            Harap aplikasi dengan perangkat dekstop atau perangkat dengan lebar 700 pixel
        </div>
        <div id="layoutSidenav">
            <div id="layoutSidenav_nav">
                <nav class="sidenav shadow-right sidenav-light">
                    <div class="sidenav-menu">
                        <div class="nav accordion" id="accordionSidenav">
                            <div class="sidenav-menu-heading d-sm-none">Halaman Utama</div>
                            <a class="nav-link{{ Route::is('home') ? ' active' : '' }}" href="{{ route('home') }}">
                                <div class="nav-link-icon"><i data-feather="home"></i></div>
                                Halaman Utama
                            </a>

                            @if (auth()->user()->role == 0 || auth()->user()->role == 5)
                                <!-- Sidenav Menu Heading (Core)-->
                                <div class="sidenav-menu-heading">User</div>
                                <!-- Sidenav Accordion (Dashboard)-->
                                <a class="nav-link{{ Route::is('user.index') ? ' active' : '' }}"
                                    href="{{ route('user.index') }}">
                                    <div class="nav-link-icon"><i data-feather="user"></i></div>
                                    Pengguna
                                </a>
                            @endif

                            @if (auth()->user()->role == 0)
                                <!-- Sidenav Menu Heading (Core)-->
                                <div class="sidenav-menu-heading">Head Office</div>
                                <!-- Sidenav Accordion (Dashboard)-->
                                <a class="nav-link{{ Route::is('lokasi.index') ? ' active' : '' }}"
                                    href="{{ route('lokasi.index') }}">
                                    <div class="nav-link-icon"><i data-feather="user"></i></div>
                                    Lokasi
                                </a>
                            @endif

                            @if (auth()->user()->role == 2 || auth()->user()->role == 0)
                                <!-- Sidenav Menu Heading (Core)-->
                                <div class="sidenav-menu-heading">Logistik</div>
                                <!-- Sidenav Accordion (Dashboard)-->
                                <a class="nav-link collapsed" href="javascript:void(0);" data-bs-toggle="collapse"
                                    data-bs-target="#collapseSparepart" aria-expanded="false"
                                    aria-controls="collapseSparepart">
                                    <div class="nav-link-icon"><i data-feather="box"></i></div>
                                    Warehouse
                                    <div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                                </a>
                                <div class="collapse{{ Route::is('sparepart.index') || Route::is('sparepart.create') || Route::is('sparepart.edit') || Route::is('oli.index') ? ' show' : '' }}"
                                    id="collapseSparepart" data-bs-parent="#accordionSidenav">
                                    <nav class="sidenav-menu-nested nav accordion" id="accordionSidenavPages">
                                        <a class="nav-link{{ Route::is('sparepart.index') || Route::is('sparepart.create') || Route::is('sparepart.edit') ? ' active' : '' }}"
                                            href="{{ route('sparepart.index') }}">
                                            Daftar Sparepart
                                        </a>
                                        {{--  <a class="nav-link{{ Route::is('oli.index') ? ' active' : '' }}"
                                            href="{{ route('oli.index') }}">
                                            Daftar Oli
                                        </a>  --}}
                                    </nav>
                                </div>
                                <a class="nav-link{{ Route::is('brgmasuk.index') || Route::is('brgmasuk.create') || Route::is('brgmasuk.edit') ? ' active' : '' }}"
                                    href="{{ route('brgmasuk.index') }}">
                                    <div class="nav-link-icon"><i data-feather="arrow-down-circle"></i></div>
                                    Barang Masuk
                                </a>
                                <a class="nav-link{{ Route::is('brgkeluar.index') || Route::is('brgkeluar.create') || Route::is('brgkeluar.edit') ? ' active' : '' }}"
                                    href="{{ route('brgkeluar.index') }}">
                                    <div class="nav-link-icon"><i data-feather="arrow-up-circle"></i></div>
                                    Barang Keluar
                                </a>
                                {{-- <a class="nav-link{{ Route::is('purchasing.order.index') || Route::is('purchasing.order.create') || Route::is('purchasing.order.edit') ? ' active' : '' }}"
                                    href="{{ route('purchasing.order.index') }}">
                                    <div class="nav-link-icon"><i data-feather="clipboard"></i></div>
                                    Purchasing Order
                                </a> --}}
                                {{--  <a class="nav-link collapsed" href="javascript:void(0);" data-bs-toggle="collapse"
                                    data-bs-target="#collapsePuchasingOrder" aria-expanded="false"
                                    aria-controls="collapsePuchasingOrder">
                                    <div class="nav-link-icon"><i data-feather="box"></i></div>
                                    Purchasing Order
                                    <div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                                </a>
                                <div class="collapse{{ Route::is('purchasing.order.index') || Route::is('purchasing.order.create') || Route::is('purchasing.order.edit') || Route::is('purchasing.order.index.batal') ? ' show' : '' }}"
                                    id="collapsePuchasingOrder" data-bs-parent="#accordionSidenav">
                                    <nav class="sidenav-menu-nested nav accordion" id="accordionSidenavPages">
                                        <a class="nav-link{{ Route::is('purchasing.order.index') || Route::is('purchasing.order.create') || Route::is('purchasing.order.edit') ? ' active' : '' }}"
                                            href="{{ route('purchasing.order.index') }}">
                                            Proses
                                        </a>
                                        <a class="nav-link{{ Route::is('purchasing.order.index.batal') ? ' active' : '' }}"
                                            href="{{ route('purchasing.order.index.batal') }}">
                                            Dibatalkan Sistem
                                        </a>
                                    </nav>
                                </div>
                                <a class="nav-link{{ Route::is('brgkeluar.index') || Route::is('brgkeluar.create') || Route::is('brgkeluar.edit') ? ' active' : '' }}"
                                    href="{{ route('brgkeluar.index') }}">
                                    <div class="nav-link-icon"><i data-feather="arrow-up-circle"></i></div>
                                    Issued
                                </a>
                                <a class="nav-link{{ Route::is('brgkeluarprb.index') || Route::is('brgkeluarprb.create') || Route::is('brgkeluarprb.edit') ? ' active' : '' }}"
                                    href="{{ route('brgkeluarprb.index') }}">
                                    <div class="nav-link-icon"><i data-feather="award"></i></div>
                                    Pembelian Pribadi
                                </a>  --}}
                            @endif


                            @if (auth()->user()->role == 1 || auth()->user()->role == 0 || auth()->user()->role == 2)
                                <!-- Sidenav Menu Heading (Core)-->
                                <div class="sidenav-menu-heading">Planner</div>
                                <!-- Sidenav Accordion (Dashboard)-->
                                @if (auth()->user()->role == 1 || auth()->user()->role == 0)
                                    {{--  <a class="nav-link{{ Route::is('service.index') || Route::is('service.create') || Route::is('service.edit') ? ' active' : '' }}"
                                        href="{{ route('service.index') }}">
                                        <div class="nav-link-icon"><i data-feather="tool"></i></div>
                                        Perbaikan
                                    </a>  --}}
                                    <a class="nav-link collapsed" href="javascript:void(0);" data-bs-toggle="collapse"
                                        data-bs-target="#collapseUnit" aria-expanded="false"
                                        aria-controls="collapseUnit">
                                        <div class="nav-link-icon"><i data-feather="truck"></i></div>
                                        Unit
                                        <div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                                    </a>
                                    <div class="collapse{{ Route::is('unit.index') || Route::is('daily.index') ? ' show' : '' }}"
                                        id="collapseUnit" data-bs-parent="#accordionSidenav">
                                        <nav class="sidenav-menu-nested nav accordion" id="accordionSidenavPages">
                                            <a class="nav-link{{ Route::is('unit.index') ? ' active' : '' }}"
                                                href="{{ route('unit.index') }}">
                                                Daftar Unit
                                            </a>
                                            {{--  <a class="nav-link {{ Route::is('daily.index') ? ' active' : '' }}"
                                                href="{{ route('daily.index') }}">
                                                Daily Unit
                                            </a>  --}}
                                        </nav>
                                    </div>
                                @endif
                                <a class="nav-link collapsed" href="javascript:void(0);" data-bs-toggle="collapse"
                                    data-bs-target="#collapseTicket" aria-expanded="false"
                                    aria-controls="collapseTicket">
                                    <div class="nav-link-icon"><i data-feather="credit-card"></i></div>
                                    Tiket Kerusakan
                                    <div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                                </a>
                                <div class="collapse{{ Route::is('ticket.index') || Route::is('ticket.create') || Route::is('ticket.edit') || route::is('all.ticket.allTiket') || route::is('req.ticket.operator') || route::is('history.ticket.historyTiket') ? ' show' : '' }}"
                                    id="collapseTicket" data-bs-parent="#accordionSidenav">
                                    <nav class="sidenav-menu-nested nav accordion" id="accordionSidenavPages">
                                        @if (auth()->user()->role == 1 || auth()->user()->role == 0)
                                            {{--  <a class="nav-link {{ route::is('req.ticket.operator') ? ' active' : '' }}"
                                                href="{{ route('req.ticket.operator') }}">
                                                Permintaan Perbaikan
                                            </a>  --}}
                                        @endif
                                        {{--  <a class="nav-link{{ Route::is('ticket.index') || Route::is('ticket.create') || Route::is('ticket.edit') ? ' active' : '' }}"
                                            href="{{ route('ticket.index') }}">
                                            Daftar Laporan Breakdown
                                        </a>  --}}
                                        <a class="nav-link {{ route::is('all.ticket.allTiket') ? ' active' : '' }}"
                                            href="{{ route('all.ticket.allTiket') }}">
                                            Tiket
                                        </a>
                                        {{--  @if (auth()->user()->role == 1 || auth()->user()->role == 0)
                                            <a class="nav-link {{ route::is('history.ticket.historyTiket') ? ' active' : '' }}"
                                                href="{{ route('history.ticket.historyTiket') }}">
                                                Riwayat Laporan Breakdown
                                            </a>
                                        @endif  --}}
                                    </nav>
                                </div>

                            @endif


                            @if (auth()->user()->role == 1 || auth()->user()->role == 0)
                                <!-- Sidenav Menu Heading (Core)-->
                                <div class="sidenav-menu-heading">Mekanik & Operator</div>
                                <!-- Sidenav Accordion (Dashboard)-->
                                <a class="nav-link collapsed" href="javascript:void(0);" data-bs-toggle="collapse"
                                    data-bs-target="#collapseMekanik" aria-expanded="false"
                                    aria-controls="collapseMekanik">
                                    <div class="nav-link-icon"><i data-feather="file-text"></i></div>
                                    Aktivitas
                                    <div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                                </a>
                                <div class="collapse {{ Route::is('operator.index') || Route::is('operator.edit') || Route::is('mekanik.index') || Route::is('mekanik.edit') ? 'show' : '' }} }}"
                                    id="collapseMekanik" data-bs-parent="#accordionSidenav">
                                    <nav class="sidenav-menu-nested nav accordion" id="accordionSidenavPages">
                                        <a class="nav-link {{ Route::is('mekanik.index') || Route::is('mekanik.edit') ? 'active' : '' }}"
                                            href="{{ route('mekanik.index') }}">
                                            Mekanik
                                        </a>
                                        <a class="nav-link {{ Route::is('operator.index') || Route::is('operator.edit') ? 'active' : '' }}"
                                            href="{{ route('operator.index') }}">
                                            Operator
                                        </a>
                                    </nav>
                                </div>
                            @endif

                            @if (auth()->user()->role == 5 || auth()->user()->role == 0)
                                <!-- Sidenav Menu Heading (Core)-->
                                <div class="sidenav-menu-heading">Penjadwalan</div>
                                @if (auth()->user()->role == 1 || auth()->user()->role == 0)
                                    <a class="nav-link{{ Route::is('jadwal') ? ' active' : '' }}"
                                        href="{{ route('jadwal') }}">
                                        <div class="nav-link-icon"><i data-feather="clipboard"></i></div>
                                        Penjadwalan Operator
                                    </a>
                                @endif

                                {{-- @if (auth()->user()->role == 1 || auth()->user()->role == 0)
                            <a class="nav-link{{ Route::is('jadwal-mekanik') ? ' active' : '' }}"
                                href="{{ route('jadwal-mekanik') }}">
                                <div class="nav-link-icon"><i data-feather="calendar"></i></div>
                                Penjadwalan Mekanik
                            </a>
                        @endif --}}

                                @if (auth()->user()->role == 1 || auth()->user()->role == 0)
                                    <a class="nav-link{{ Route::is('jadwal-mekanik') ? ' active' : '' }}"
                                        href="{{ route('jadwal-mekanik') }}">
                                        <div class="nav-link-icon"><i data-feather="calendar"></i></div>
                                        Penjadwalan Mekanik
                                    </a>
                                @endif
                                <!-- Sidenav Accordion (Dashboard)-->
                                {{--  <a class="nav-link collapsed" href="javascript:void(0);" data-bs-toggle="collapse"
                                    data-bs-target="#collapseFuel" aria-expanded="false" aria-controls="collapseFuel">
                                    <div class="nav-link-icon"><i data-feather="filter"></i></div>
                                    Fuel
                                    <div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                                </a>  --}}
                                <div class="collapse{{ Route::is('fuel-stock.index') ||
                                Route::is('fuel-stock.create') ||
                                Route::is('fuel-stock.edit') ||
                                Route::is('fuel-suply.index') ||
                                Route::is('fuel-suply.create') ||
                                Route::is('fuel-suply.edit') ||
                                Route::is('fuel-unit.index') ||
                                Route::is('fuel-unit.create') ||
                                Route::is('fuel-unit.edit') ||
                                Route::is('storage.index') ||
                                Route::is('storage.create') ||
                                Route::is('storage.edit')
                                    ? ' show'
                                    : '' }}"
                                    id="collapseFuel" data-bs-parent="#accordionSidenav">
                                    <nav class="sidenav-menu-nested nav accordion" id="accordionSidenavPages">
                                        <a class="nav-link{{ Route::is('storage.index') ? ' active' : '' }}"
                                            href="{{ route('storage.index') }}">
                                            Storage
                                        </a>
                                        <a class="nav-link{{ Route::is('fuel-stock.index') || Route::is('fuel-stock.edit') || Route::is('fuel-stock.create') ? ' active' : '' }}"
                                            href="{{ route('fuel-stock.index') }}">
                                            Stock
                                        </a>
                                        <a class="nav-link{{ Route::is('fuel-suply.index') || Route::is('fuel-suply.edit') || Route::is('fuel-suply.create') ? ' active' : '' }}"
                                            href="{{ route('fuel-suply.index') }}">
                                            Suply
                                        </a>
                                        <a class="nav-link{{ Route::is('fuel-unit.index') || Route::is('fuel-unit.edit') || Route::is('fuel-unit.create') ? ' active' : '' }}"
                                            href="{{ route('fuel-unit.index') }}">
                                            Unit
                                        </a>
                                    </nav>
                                </div>
                            @endif




                            {{-- <!-- Sidenav Menu Heading (Core)-->
                            <div class="sidenav-menu-heading">Superadmin</div>
                            <!-- Sidenav Accordion (Dashboard)-->
                            <a class="nav-link{{ Route::is('users') ? ' active' : '' }}"
                                href="{{ route('users') }}">
                                <div class="nav-link-icon"><i data-feather="users"></i></div>
                                Manajemen Pengguna
                            </a> --}}
                        </div>
                    </div>
                    <!-- Sidenav Footer-->
                    <div class="sidenav-footer">
                        {{-- <form method="POST" action="https://tambang-office.neuhost.co.id/login-from-tambangv2">
                            @csrf
                            <input type="hidden" value="admin" name="username">
                            <input type="hidden" value="admin" name="password">
                            <button type="submit" class="btn btn-danger">
                                 <div class="nav-link-icon"><i data-feather="calendar"></i></div>
                                Pindah ke Office
                            </button>
                        </form> --}}
                        <div class="sidenav-footer-content">
                            {{--  <a class="btn btn-danger"
                                href="https://tambang-office.neuhost.co.id/login-from-tambangv2?username=admin&password=admin">
                                <div class="nav-link-icon"><i data-feather="calendar"></i></div>
                                Pindah ke Office
                            </a>  --}}
                        </div>
                    </div>
                </nav>
            </div>
