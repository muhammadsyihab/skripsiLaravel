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
                                        required value="{{ $date }}">
                                </div>
                                @ho
                                    <div class="col-md-6">
                                        <label for="">Cari Berdasarkan Lokasi</label>
                                        <select data-column="1" class="form-control form-select filter-select" name="lokasi">
                                            <option value="">-- Pilih Lokasi --</option>
                                            @foreach ($locations as $location)
                                                <option value="{{ $location->id }}"{{ $location->id == $locate ? ' selected' : '' }}>{{ $location->nama_lokasi }}
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
                {{-- Card Table --}}
                <div class="card card-header-actions">
                    <div class="card-header">
                        <div>
                            Data Fuel Stock
                            <div class="small text-muted">
                                <span class="fw-500 text-primary">Bulan</span>
                                &middot; {{ now()->parse($date)->translatedFormat('F Y') ?? now()->translatedFormat('F Y') }} &middot;
                                {{ now()->translatedFormat('g:i a') }}
                            </div>
                        </div>
                        <div>
                            <a class="btn btn-outline-green" href="{{ route('fuel-stock.create') }}" role="button">
                                <i data-feather="plus-circle"></i> &nbsp; Tambah </a>
                            {{-- <!-- Print PDF --> --}}
                            <button type="button" class="btn btn-outline-warning float-right" data-bs-toggle="modal"
                                data-bs-target="#exportPdf">
                                <i data-feather="printer"></i> &nbsp; PDF
                            </button>
                            <!-- Print pdf -->
                            <div class="modal fade" id="exportPdf" tabindex="-1" role="dialog"
                                aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <form method="post" action="{{ route('fuel-stock.pdf') }}"
                                        enctype="multipart/form-data" target="_blank">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Export PDF</h5>
                                            </div>
                                            <div class="modal-body">

                                                @csrf
                                                <div class="row mb-3">
                                                    <div class="">
                                                        <label for="date">Pilih data bulan</label>
                                                        <input type="month" class="form-control" name="date">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-bs-dismiss="modal">Close</button>
                                                <button type="submit" class="btn btn-warning">Buat PDF</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            {{-- Export excel --}}
                            <button type="button" class="btn btn-outline-green float-right" data-bs-toggle="modal"
                                data-bs-target="#importExcel">
                                <i data-feather="external-link"></i>
                                &nbsp; Export Excel
                            </button>
                            <!-- Export Excel -->
                            <div class="modal fade" id="importExcel" tabindex="-1" role="dialog"
                                aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <form method="post" action="{{ route('fuel-stock.excel') }}" target="_blank"
                                        enctype="multipart/form-data">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Export Excel</h5>
                                            </div>
                                            <div class="modal-body">
                                                @csrf
                                                <div class="row mb-3">
                                                    <div class="">
                                                        <label for="date">Pilih data bulan</label>
                                                        <input type="month" class="form-control" name="date">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-bs-dismiss="modal">Close</button>
                                                <button type="submit" class="btn btn-primary">Export</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        @if (session()->has('success'))
                            <div class="alert alert-primary" role="alert">
                                {{ session('success') }}
                            </div>
                        @endif
                        @if (session()->has('danger'))
                            <div class="alert alert-danger" role="alert">
                                {{ session('danger') }}
                            </div>
                        @endif
                        <div class="table-responsive table-responsive-xxl text-nowrap">
                            <table class="table table-bordered table-striped" id="simpleDatatables">
                                <thead>
                                    <tr>
                                        <th class="text-center" valign="middle" rowspan="2">Tanggal</th>
                                        {{-- <th class="text-center" valign="middle" rowspan="2">Lokasi Storage</th> --}}
                                        {{-- <th class="text-center" valign="middle" rowspan="2">Nama Storage</th> --}}
                                        <th class="text-center" valign="middle" rowspan="2">Stock Open</th>
                                        <th class="text-center" valign="middle" rowspan="2">Fuel Stock In</th>
                                        <th class="text-center" valign="middle" colspan="2">Fuel Out</th>
                                        <th class="text-center" valign="middle" rowspan="2">Fuel Out Total</th>
                                        <th class="text-center" valign="middle" rowspan="2">Stock</th>
                                        <th class="text-center" valign="middle" rowspan="2">Tindakan</th>
                                    </tr>
                                    <tr>
                                        <th class="text-center" valign="middle">Day</th>
                                        <th class="text-center" valign="middle">Night</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        @if (Route::is('fstock.filter'))
                                            <th colspan="2">Penangung Jawab: {{ $penanggungJawab }}</th>
                                            {{-- <th colspan="4">Penangung Jawab: Planner</th> --}}
                                        @elseif (Route::is('fuel-stock.index'))
                                            <th colspan="2">-- {{ $total }}</th>
                                        @endif
                                        <th>Total Masuk: {{ $stockSuply }}</th>
                                        <th colspan="2">Rata-rata:
                                            {{ number_format((float) $rataStockUnit, 2, '.', '') }}</th>
                                        <th colspan="1">Total Keluar: {{ $stockUnit }}</th>
                                        <th colspan="2">Sisa Stock: {{ $sisaStock }}</th>
                                    </tr>
                                </tfoot>
                                <tbody>
                                    @foreach ($stocks as $stock)
                                        <tr>
                                            <td>{{ now()->parse($stock->tanggal)->translatedFormat('j F Y') }}</td>
                                            {{-- <td>{{ $stock->storage->lokasi->nama_lokasi }}</td> --}}
                                            {{-- <td>{{ $stock->storage->nama_storage }}</td> --}}
                                            <td>{{ $stock->stock_open_total }}</td>
                                            <td>{{ $stock->fuelSuplies->sum('do_datang') }}</td>
                                            <td>{{ $stock->qty_to_unit_day }}</td>
                                            <td>{{ $stock->qty_to_unit_night }}</td>
                                            <td>{{ $stock->fuelOuts->sum('qty_to_unit') }}</td>
                                            <td>{{ $stock->stock }}</td>
                                            <td>
                                                <form method="post"
                                                    action="{{ route('fuel-stock.destroy', $stock->id) }}">
                                                    @csrf
                                                    <a class="btn btn-warning btn-sm" title="Edit"
                                                        href="{{ route('fuel-stock.edit', $stock->id) }}">
                                                        <i data-feather="edit"></i>&nbsp;
                                                        Edit
                                                    </a>
                                                    @csrf
                                                    @method('DELETE')
                                                    <button class="btn btn-danger btn-sm" title="Hapus" type="submit"
                                                        onclick="return confirm('Yakin anda ingin menghapus data ini?')">
                                                        <i data-feather="trash-2"></i>&nbsp;
                                                        Hapus
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
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
