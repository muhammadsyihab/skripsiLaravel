@extends('layouts.template')

@section('content')
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs5/dt-1.13.1/datatables.min.css" />

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
                <div class="card card-header-actions">
                    <div class="card-header">
                        Data Table
                        <div>                            
                            <a class="btn btn-outline-green float-right" href="{{ route('fuel-unit.create') }}" role="button">
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
                        <form method="post" action="{{ route('fuel-unit.filter') }}">
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
                        <div class="table-responsive-xxl text-nowrap">
                            <table class="table table-bordered" id="simpleDatatables">
                                <thead>
                                    <tr>
                                        <th rowspan="2">Date</th>
                                        <th rowspan="2">QTY Keluar</th>
                                        <th rowspan="2">Status</th>
                                        <th rowspan="2">Penerima</th>
                                        <th rowspan="2">Estimasi Pengiriman</th>
                                        <th colspan="2">Oli Rite</th>
                                        <th rowspan="2">Action</th>
                                    </tr>
                                    <tr>
                                        <th>Awal</th>
                                        <th>Akhir</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($stocks as $stock)
                                        @foreach ($stock->oliOuts as $outs)
                                        <tr>
                                            <td>{{ now()->parse($outs->oliStock->tanggal)->format('j F Y')  }}</td>
                                            <td>{{ $outs->qty_keluar }}</td>
                                            @if ($outs->status == 0)
                                                <td><span class="badge bg-warning">Diminta</span></td>
                                            @elseif($outs->status == 1)
                                                <td><span class="badge bg-success">Acc</span></td>
                                            @elseif($outs->status == 2)
                                                <td><span class="badge bg-danger">Ditolak<span></td>
                                            @endif
                                            <td>{{ $outs->penerima }}</td>
                                            <td>{{ $outs->estimasi_pengiriman }}</td>
                                            <td>{{ $outs->qty_keluar }}</td>
                                            <td>{{ $outs->qty_keluar }}</td>
                                            <td>
                                                <form method="post"
                                                    action="{{ route('fuel-unit.destroy', $outs->id) }}">
                                                    @csrf
                                                    <a class="btn btn-success btn-sm" title="Edit"
                                                        href="{{ route('fuel-unit.edit', $outs->id) }}">
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
                                        {{-- <tr>
                                            <td>{{ now()->parse($fuelToUnit->tanggal)->format('j F Y') }}</td>
                                            <td>{{ $fuelToUnit->fuelStock->storage->nama_storage }}</td>
                                            <td>{{ $fuelToUnit->dailyUnit->unit->lokasi->nama_lokasi }}</td>
                                            <td>{{ $fuelToUnit->dailyUnit->unit->no_lambung }}</td>
                                            <td>{{ $fuelToUnit->qty_to_unit }}</td>
                                            <td>{{ $fuelToUnit->fuelStock->stock }}</td>
                                            <td>{{ $fuelToUnit->fuelStock->stock - $fuelToUnit->qty_to_unit }}</td>
                                            <td>{{ $fuelToUnit->dailyUnit->unit->total_hm }}</td>
                                            @if ($fuelToUnit->dailyUnit->shift_id == 1)
                                                <td><span class="badge bg-warning">DAY</span></td>
                                            @elseif($fuelToUnit->dailyUnit->shift_id == 2)
                                                <td><span class="badge bg-dark">NIGHT</span></td>
                                            @endif
                                            <td>{{ ucfirst($fuelToUnit->dailyUnit->user->name ) }}</td>
                                            <td>
                                                <form method="post"
                                                    action="{{ route('fuel-unit.destroy', $fuelToUnit->id) }}">
                                                    @csrf
                                                    <a class="btn btn-success btn-sm" title="Edit"
                                                        href="{{ route('fuel-unit.edit', $fuelToUnit->id) }}">
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
                                        </tr> --}}
                                        @endforeach
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
    {{-- <link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest" type="text/javascript"></script> --}}
    <script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/v/bs5/dt-1.13.1/datatables.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#simpleDatatables').DataTable();
        });
    </script>
@endsection
