@extends('layouts.template')

@section('content')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css">

    <div id="layoutSidenav_content">
        <main>
            <header class="page-header page-header-dark bg-gradient-primary-to-secondary pb-10">
                <div class="container-xl px-4">
                    <div class="page-header-content pt-4">
                    </div>
                </div>
            </header>
            <!-- Main page content-->
            <div class="container-xl px-4 mt-n10">
                <div class="card mb-3">
                    <div class="card-header">
                        Cari Data Fuel Stock
                    </div>
                    <div class="card-body">
                        <form method="post" action="{{ route('fstock.filter') }}">
                            @csrf
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label>Filter Stock Bulan</label>
                                    <input class="form-control filter" type="month" name="tanggal" id="filter-bulan"
                                        required>
                                </div>
                                @ho
                                    <div class="col-md-6">
                                        <label for="">Cari Berdasarkan Lokasi</label>
                                        <select data-column="1" class="form-control form-select filter-select" name="lokasi">
                                            <option value="">-- Pilih Lokasi --</option>
                                            @foreach ($locations as $location)
                                                <option value="{{ $location->id }}">{{ $location->nama_lokasi }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                @endho
                            </div>
                            <button type="submit" class="btn btn-primary">Cari</button>
                        </form>
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

    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
    <script>
        // $('#datatablesSimple').DataTable();

        $(document).ready(function() {
            $('#simpleDatatables').DataTable({
                "ordering": false
            } );
        });
    </script>
@endsection
