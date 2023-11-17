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
                    </div>
                </div>
            </header>
            <!-- Main page content-->
            <div class="container-xl px-4 mt-n10">
                <div class="card mb-3">
                    <div class="card-header">
                        Filter
                    </div>
                    <div class="card-body">
                        <form method="post" action="{{ route('fuel-unit.filter') }}">
                            @csrf
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label>Filter Stock Bulan</label>
                                    <input class="form-control filter" type="month" name="tanggal" id="filter-bulan" value={{ $date }}>
                                </div>
                                
                                @ho
                                    <div class="col-md-6">
                                        <label for="">Cari Berdasarkan Lokasi</label>
                                        <select data-column="1" class="form-control form-select filter-select">
                                            <option value="">-- Pilih Lokasi --</option>
                                            @foreach ($locations as $location)
                                                <option value="{{ $location->nama_lokasi }}">{{ $location->nama_lokasi }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                @endho
                            </div>
                            <button type="submit" class="btn btn-primary">Filter</button>
                        </form>
                    </div>
                </div>
                <div class="card card-header-actions">
                    <div class="card-header">
                        <div>
                            Data Fuel Unit
                            <div class="small text-muted">
                                <span class="fw-500 text-primary">Bulan</span>
                                &middot; {{ now()->parse($date)->translatedFormat('F Y') ?? now()->translatedFormat('F Y') }} &middot;
                                {{ now()->translatedFormat('g:i a') }}
                            </div>
                        </div>
                        <div>
                            <a class="btn btn-outline-green float-right" href="{{ route('fuel-unit.create') }}"
                                role="button">
                                <i data-feather="plus-circle"></i> &nbsp Tambah </a>
                            {{-- <!-- Print PDF --> --}}
                            <button type="button" class="btn btn-outline-warning float-right" data-bs-toggle="modal"
                                data-bs-target="#exportPdf">
                                <i data-feather="printer"></i> &nbsp; PDF
                            </button>
                            <!-- Print pdf -->
                            <div class="modal fade" id="exportPdf" tabindex="-1" role="dialog"
                                aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <form method="post" action="{{ route('fuel-unit.pdf') }}" enctype="multipart/form-data"
                                        target="_blank">
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
                                    <form method="post" action="{{ route('fuel-unit.excel') }}" target="_blank"
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
                                        <th class="text-center" valign="middle" rowspan="2">Local Area</th>
                                        <th class="text-center" valign="middle" rowspan="2">Kode Unit / CN Unit</th>
                                        <th class="text-center" valign="middle" rowspan="2">Kuantitas Pengisian Unit
                                        </th>
                                        <th class="text-center" valign="middle" colspan="2">Fuel Rite</th>
                                        <th class="text-center" valign="middle" rowspan="2">HM Unit</th>
                                        <th class="text-center" valign="middle" rowspan="2">Shift</th>
                                        <th class="text-center" valign="middle" rowspan="2">Operator</th>
                                        <th class="text-center" valign="middle" rowspan="2">Tindakan</th>
                                    </tr>
                                    <tr>
                                        <th class="text-center" valign="middle">Awal</th>
                                        <th class="text-center" valign="middle">Akhir</th>
                                    </tr>
                                </thead>
                                {{-- <tfoot>
                                    <tr>
                                        <th colspan="3">Prepared By: -- </th>
                                        <th colspan="3">Checked By: -- </th>
                                        <th colspan="5">Aproved By: -- </th>
                                    </tr>
                                </tfoot> --}}
                                <tbody>
                                    @foreach ($storages as $fuelToUnit)
                                        <tr>
                                            <td>{{ now()->parse($fuelToUnit->tanggal)->translatedFormat('j F Y') }}</td>
                                            <td>{{ $fuelToUnit->nama_lokasi }}</td>
                                            <td>{{ $fuelToUnit->no_lambung }}</td>
                                            <td>{{ $fuelToUnit->qty_to_unit }}</td>
                                            <td>{{ $fuelToUnit->stock }}</td>
                                            <td>{{ $fuelToUnit->stock - $fuelToUnit->qty_to_unit }}</td>
                                            <td>{{ $fuelToUnit->total_hm }}</td>
                                            @if ($fuelToUnit->shift == 1)
                                                <td><span class="badge bg-warning">DAY</span></td>
                                            @elseif($fuelToUnit->shift == 2)
                                                <td><span class="badge bg-dark">NIGHT</span></td>
                                            @endif
                                            <td>{{ ucfirst($fuelToUnit->name) }}</td>
                                            <td>
                                                <form method="post"
                                                    action="{{ route('fuel-unit.destroy', $fuelToUnit->id) }}">
                                                    @csrf
                                                    <a class="btn btn-warning btn-sm" title="Edit"
                                                        href="{{ route('fuel-unit.edit', $fuelToUnit->id) }}">
                                                        <i data-feather="edit"></i>&nbsp;
                                                        Edit
                                                    </a>
                                                    @csrf
                                                    @method('DELETE')
                                                    <button class="btn btn-danger btn-sm" title="Hapus" type="submit"
                                                        onclick="return confirm('Apakah anda yakin ingin menghapus data ini?')">
                                                        <i data-feather="trash-2"></i>&nbsp;
                                                        Hapus
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                    {{-- @foreach ($fuelToUnits as $fuelToUnit)
                                    @endforeach --}}
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
    <script>
        $(document).ready(function() {
            let table = $('#simpleDatatables').DataTable({
                "pageLength": 50,
                order: [
                    [0, 'asc']
                ],
                rowsGroup: [0]
            });

            $('.filter-input').keyup(function() {
                table.column($(this).data('column'))
                    .search($(this).val())
                    .draw();
            });

            $('.filter-select').change(function() {
                table.column($(this).data('column'))
                    .search($(this).val())
                    .draw();
            });

        })
    </script>
@endsection
