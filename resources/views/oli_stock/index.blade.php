@extends('layouts.template')

@section('content')
    <style>
        /* .dataTables_filter {
            text-align: right !important;
        } */
    </style>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs5/dt-1.13.1/datatables.min.css" />

    <div id="layoutSidenav_content">
        <main>
            <!-- Main page content-->
            <div class="container-xl px-4 mt-5">
                <!-- Custom page header alternative example-->
                <div class="d-flex justify-content-between align-items-sm-center flex-column flex-sm-row mb-4">
                    <div class="me-4 mb-3 mb-sm-0">
                        <h1 class="mb-0">Dashboard</h1>
                        <div class="small">
                            <span class="fw-500 text-primary">{{ now()->format('l') }}</span>
                            &middot; {{ now()->format('F j, Y') }} &middot; {{ now()->format('g:i a') }}
                        </div>
                    </div>
                    <!-- Date range picker example-->
                    <div class="input-group input-group-joined border-0 shadow" style="width: 16.5rem">
                        <span class="input-group-text"><i data-feather="calendar"></i></span>
                        <input class="form-control ps-0 pointer" id="litepickerRangePlugin" name="tanggal"
                            placeholder="Select date range..." />
                    </div>
                </div>
                {{-- Card Table --}}
                <div class="card card-header-actions">
                    <div class="card-header">
                        Data Stock
                        <div>
                            <a class="btn btn-outline-green" href="{{ route('oli.create') }}" role="button">
                                <i data-feather="plus-circle"></i> &nbsp ADD </a>
                            <!-- Print PDF -->
                            <a class="btn btn-outline-yellow float-right" href="#" role="button" target="_blank">
                                <i data-feather="printer"></i> &nbsp PDF </a>
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
                        <form method="post" action="{{ route('fstock.filter') }}">
                            @csrf
                            <div class="row mb-5">
                                <div class="col-md-6">
                                    <label>Filter Stock Bulan</label>
                                    <input class="form-control filter" type="month" name="tanggal" id="filter-bulan">
                                </div>
                                <div class="col-md-2">
                                    <button type="submit" class="btn btn-primary">Filter</button>
                                </div>
                            </div>
                        </form>
                        <div class="table-responsive table-responsive-xxl text-nowrap mt-2">
                            <table class="table table-bordered" id="simpleDatatables">
                                <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>Stock Open</th>
                                        <th>Oli Stock In</th>
                                        <th>Oli Out Total</th>
                                        <th>Stock</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                {{-- <tfoot>
                                    <tr>
                                        @if (Route::is('fstock.filter'))
                                            <th colspan="4">Penangung Jawab: {{ $penanggungJawab }}</th>
                                        @elseif (Route::is('fuel-stock.index'))
                                            <th colspan="4">-- {{ $total }}</th>
                                        @endif
                                        <th>Total Masuk: {{ $stockSuply }}</th>
                                        <th colspan="2">Rata-rata: {{ $rataStockUnit }}</th>
                                        <th colspan="1">Total Keluar: {{ $stockUnit }}</th>
                                        <th colspan="2">Sisa Stock: {{ $sisaStock }}</th>
                                    </tr>
                                </tfoot> --}}
                                <tbody>
                                    @foreach ($stocks as $stock)
                                        <tr>
                                            <td>{{ now()->parse($stock->tanggal)->format('j F Y') }}</td>
                                            <td>{{ $stock->stock_open_total }}</td>
                                            <td>{{ $stock->oliSuplies->sum('qty_masuk') }}</td>
                                            <td>{{ $stock->oliOuts->sum('qty_keluar') }}</td>
                                            <td>{{ $stock->stock }}</td>
                                            <td>
                                                <form method="post"
                                                    action="{{ route('oli.destroy', $stock->id) }}">
                                                    @csrf
                                                    <a class="btn btn-success btn-sm" title="Edit"
                                                        href="{{ route('oli.edit', $stock->id) }}">
                                                        <i data-feather="edit"></i>&nbsp;
                                                        Edit
                                                    </a>
                                                    @csrf
                                                    @method('DELETE')
                                                    <button class="btn btn-danger btn-sm" title="Delete" type="submit"
                                                        title="Delete">
                                                        <i data-feather="trash"></i>&nbsp;
                                                        Delete
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

    <script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/v/bs5/dt-1.13.1/datatables.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#simpleDatatables').DataTable();
        });
    </script>
@endsection
