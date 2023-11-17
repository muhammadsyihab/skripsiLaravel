@extends('layouts.template')

@section('content')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
    <div id="layoutSidenav_content">
        <main>
            <header class="page-header page-header-dark bg-gradient-primary-to-secondary pb-10">
                <div class="container-xl px-4">
                    <div class="page-header-content pt-4">
                        <div class="row align-items-center justify-content-between">
                            <div class="col-auto mt-4">
                                <h1 class="page-header-title">
                                    <div class="page-header-icon"><i data-feather="home"></i></div>
                                    Halaman Notifikasi
                                </h1>
                                <div class="page-header-subtitle">
                                    {{ ENV('APP_NAME') }}
                                    <br>
                                    <span>{{ now()->format('l') }}</span>
                                    &middot; {{ now()->format('F j, Y') }} &middot; {{ now()->format('g:i a') }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </header>
            <!-- Main page content-->
            <div class="container-xl px-6 mt-n10">
                <div class="card mb-4">
                    <div class="card-header">
                        Semua Notifikasi
                    </div>
                    <div class="card-body px-0 pb-2 overflow-auto">
                        @foreach ($notifications as $notification)
                            <div class="d-flex align-items-center justify-content-between px-4">
                                <div class="small">{{ $notification->isi }}</div>
                                <div class="text-xs text-muted">{{ now()->parse($notification->created_at)->format('j F Y, g:i a') }}</div>
                            </div>
                            <hr class="" />
                        @endforeach
                    </div>
                </div>
                
            </div>
        </main>
        <footer class="footer-admin mt-auto footer-light">
            <div class="container-xl px-4">
                <div class="row">
                    <div class="col-md-6 small">Copyright &copy; {{ env('APP_NAME') }}
                        <script type="text/javascript">
                            document.write(new Date().getFullYear());
                        </script>
                    </div>
                    <div class="col-md-6 text-md-end small">
                        <a href="#!"> </a>
                        &middot;
                        <a href="#!"> </a>
                    </div>
                </div>
            </div>
        </footer>
    </div>
    </div>
    {{-- <script src="https://code.jquery.com/jquery-3.6.3.js" integrity="sha256-nQLuAZGRRcILA+6dMBOvcRh5Pe310sBpanc6+QBmyVM=" crossorigin="anonymous"></script> --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    {{-- <script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script> --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
@endsection
