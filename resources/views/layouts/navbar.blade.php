    
    
    <body class="nav-fixed{{ Route::is('ticket.vue.show') ? ' sidenav-toggled' : '' }}">
        
        <nav class="topnav navbar navbar-expand shadow justify-content-between justify-content-sm-start navbar-light bg-white"
            id="sidenavAccordion">
            <!-- Sidenav Toggle Button-->
            <button class="btn btn-icon btn-transparent-dark order-1 order-lg-0 me-2 ms-lg-2 me-lg-0"
                id="sidebarToggle"><i data-feather="menu"></i></button>
            <!-- Navbar Brand-->
            {{--  <!-- * * Tip * * You can use text or an image for your navbar brand.-->
            <!-- * * * * * * When using an image, we recommend the SVG format.-->
            <!-- * * * * * * Dimensions: Maximum height: 32px, maximum width: 240px-->  --}}
            <a class="navbar-brand pe-3 ps-4 ps-lg-2" href="{{ route('home') }}">{{ env('APP_NAME') }}</a>
            <!-- Navbar Search Input-->
            <!-- * * Note: * * Visible only on and above the lg breakpoint-->

            <!-- Navbar Items-->
            <ul class="navbar-nav align-items-center ms-auto">
                <!-- Alerts Dropdown-->
                <li class="nav-item dropdown no-caret d-none d-sm-block me-3 dropdown-notifications">
                    <a class="btn btn-icon btn-transparent-dark dropdown-toggle" id="navbarDropdownAlerts" href="javascript:void(0);" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i data-feather="bell"></i></a>
                    <div class="dropdown-menu dropdown-menu-end border-0 shadow animated--fade-in-up" aria-labelledby="navbarDropdownAlerts">
                        <h6 class="dropdown-header dropdown-notifications-header">
                            <i class="me-2" data-feather="bell"></i>
                            Notifikasi
                        </h6>
                        @foreach(\App\Models\Notification::where('users_id', auth()->user()->id)->latest()->take(5)->get(); as $notif)
                            <!-- Alert-->
                            <a class="dropdown-item dropdown-notifications-item" href="#!">
                                <div class="dropdown-notifications-item-icon bg-warning"><i data-feather="activity"></i></div>
                                <div class="dropdown-notifications-item-content">
                                    <div class="dropdown-notifications-item-content-details mb-0">
                                        <div class="d-flex justify-content-between">
                                            <p style="color: black;">{{ $notif->judul }}</p> <p>{{ now()->parse($notif->created_at)->format('j F, Y') }}</p>
                                        </div>
                                    </div>
                                    <div class="dropdown-notifications-item-content-text">{{ $notif->isi }}</div>
                                </div>
                            </a>
                        @endforeach
                        <a class="dropdown-item dropdown-notifications-footer" href="{{ route('notif.index') }}">Lihat semua notifikasi</a>
                    </div>
                </li>
                <!-- User Dropdown-->
                <li class="nav-item dropdown no-caret dropdown-user me-3 me-lg-4">
                    <a class="btn btn-icon btn-transparent-dark dropdown-toggle" id="navbarDropdownUserImage"
                        href="javascript:void(0);" role="button" data-bs-toggle="dropdown" aria-haspopup="true"
                        aria-expanded="false">
                        @if (empty(auth()->user()->photo))
                            <img class="img-fluid"
                                src="{{ asset('admin/dist/assets/img/illustrations/profiles/profile-2.png') }}" />
                        @else
                            <img class="img-fluid" src="{{ asset('storage/Register/' . auth()->user()->photo) }}" />
                        @endif
                    </a>
                    <div class="dropdown-menu dropdown-menu-end border-0 shadow animated--fade-in-up"
                        aria-labelledby="navbarDropdownUserImage">
                        <h6 class="dropdown-header d-flex align-items-center">
                            @if (empty(auth()->user()->photo))
                                <img class="dropdown-user-img"
                                    src="{{ asset('admin/dist/assets/img/illustrations/profiles/profile-2.png') }}" />
                            @else
                                <img class="dropdown-user-img"
                                    src="{{ asset('storage/Register/' . auth()->user()->photo) }}" />
                            @endif
                            <div class="dropdown-user-details">
                                <div class="dropdown-user-details-name">{{ auth()->user()->name }}</div>
                                <div class="dropdown-user-details-email">{{ auth()->user()->jabatan }}</div>
                            </div>
                        </h6>
                        <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="{{ route('logout') }}"
                                onclick="event.preventDefault();
                                                    document.getElementById('logout-form').submit();">
                                <i data-feather="log-out"></i>{{ __('Logout') }}
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </a>
                    </div>
                </li>
            </ul>
        </nav>
