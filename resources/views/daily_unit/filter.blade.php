@extends('layouts.template')

@section('content')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />


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
                    <div class="card-header">Cari Data Daily Unit {{ $locationFilter->nama_lokasi ?? 'All PIT' }}</div>
                    <div class="card-body">
                        <form action="{{ route('daily.filter') }}" method="POST">
                            @csrf

                            <div class="row">
                                <div class="col-md-8 mb-3">
                                    <label for="date">Cari daily unit berdasarkan bulan</label>
                                    <input type="month" name="date" id="date" class="form-control"
                                        value="{{ $date }}" required>
                                </div>
                            </div>
                            <div class="row mb-5">
                                <div class="col-md-8 mb-3">
                                    <label for="unit">Unit</label><br>
                                    <select class="form-control pencarian w-100" id="unit" name="unit" required>
                                        <option value="" selected disabled>-- Pilih Unit --</option>
                                        @foreach ($units as $unit)
                                            <option
                                                value="{{ $unit->id }}"{{ $unit->id == $unitById->id ? ' selected' : '' }}>
                                                {{ $unit->no_lambung }} - {{ $unit->total_hm }} HM/KM</option>
                                        @endforeach
                                    </select>
                                    @error('unit')
                                        <div class="text-danger mt-5">Tolong isi dengan benar</div>
                                    @enderror
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary">Cari</button>
                        </form>
                    </div>
                </div>
                <div class="card card-header-actions">
                    <div class="card-header">
                        <div>
                            Daily Unit {{ $unitById->jenis }} - {{ $unitById->no_lambung }}
                            <div class="small text-muted">
                                {{ now()->parse($date)->translatedFormat('F Y') }} &middot; {{ now()->translatedFormat('g:i a') }}
                            </div>
                        </div>
                        <div>
                            {{-- <!-- Print PDF --> --}}
                            <button type="button" class="btn btn-outline-warning float-right" data-bs-toggle="modal"
                                data-bs-target="#exportPdf">
                                <i data-feather="printer"></i> &nbsp; PDF
                            </button>
                            <!-- Print pdf -->
                            <div class="modal fade" id="exportPdf" tabindex="-1" role="dialog"
                                aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <form method="post" action="{{ route('daily.pdf') }}" enctype="multipart/form-data"
                                        target="_blank">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Export PDF</h5>
                                            </div>
                                            <div class="modal-body">
                                                @csrf
                                                <div class="row mb-3">
                                                    <div class="mb-3">
                                                        <label for="date">Pilih data bulan</label>
                                                        <input type="month" class="form-control" name="date"
                                                            value="{{ $date }}">
                                                    </div>
                                                    <div class="">
                                                        <label for="">Cari Berdasarkan Unit</label>
                                                        <select class="form-control" name="unit" readonly>
                                                            <option value="">-- Pilih Unit --</option>
                                                            @foreach ($units as $unit)
                                                                <option
                                                                    value="{{ $unit->id }}"{{ $unit->id == $unitById->id ? ' selected' : '' }}>
                                                                    {{ $unit->no_lambung }}
                                                                </option>
                                                            @endforeach
                                                        </select>
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
                                    <form method="post" action="{{ route('daily.excel') }}" target="_blank"
                                        enctype="multipart/form-data">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Export Excel</h5>
                                            </div>
                                            <div class="modal-body">
                                                @csrf
                                                <div class="row mb-3">
                                                    <div class="mb-3">
                                                        <label for="date">Pilih data bulan</label>
                                                        <input type="month" class="form-control" name="date"
                                                            value="{{ $date }}">
                                                    </div>
                                                    @ho
                                                        <div class="">
                                                            <label for="">Cari Berdasarkan Unit</label>
                                                            <select class="form-control" name="unit" readonly>
                                                                <option value="">-- Pilih Unit --</option>
                                                                @foreach ($units as $unit)
                                                                    <option
                                                                        value="{{ $unit->id }}"{{ $unit->id == $unitById->id ? ' selected' : '' }}>
                                                                        {{ $unit->no_lambung }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    @endho
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
                            <table class="table table-bordered table-striped" id="datatablesSimple">
                                <thead>
                                    <tr>
                                        <th rowspan="2" class="text-center">Tanggal
                                            Operasi</th>
                                        <th rowspan="2" class="text-center">Shift</th>
                                        <th rowspan="2" class="text-center">Nama Unit</th>
                                        <th colspan="2" class="text-center">HM</th>
                                        <th colspan="1" class="text-center">Time Operasional</th>
                                        <th rowspan="2" class="text-center">Solar
                                        </th>
                                        <th colspan="3" class="text-center">Time Sheet</th>
                                        <th rowspan="2" class="text-center">Operator/Driver
                                        </th>

                                    </tr>
                                    <tr>
                                        <th class="text-center">Start</th>
                                        <th class="text-center">End</th>
                                        <th class="text-center">HM</th>
                                        <th class="text-center">WH</th>
                                        <th class="text-center">STB</th>
                                        <th class="text-center">BD</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    @foreach ($dailys as $daily)
                                        <tr>

                                            <td rowspan="1">{{ now()->parse($daily->tanggal)->translatedFormat('j F Y') }}</td>
                                            <td>{{ $daily->waktu }}</td>
                                            <td>{{ $daily->no_lambung }}</td>
                                            <td>{{ $daily->start_unit }}</td>
                                            <td>{{ $daily->end_unit }}</td>
                                            @if ($daily->end_unit == 0)
                                                <td>Unit Masih Berjalan</td>
                                            @else
                                                <td>{{ $daily->end_unit - $daily->start_unit }}</td>
                                            @endif
                                            {{-- <td>{{ $daily->fuelUnits->sum('qty_to_unit') }}</td> --}}
                                            {{-- <td>{{ $daily->fuelUnits->sum('qty_to_unit') }}</td> --}}
                                            <td>{{ $daily->fuel }}</td>
                                            @if ($daily->end_unit == 0)
                                                <td>Unit Masih Berjalan</td>
                                            @else
                                                <td>{{ $daily->end_unit - $daily->start_unit }}</td>
                                            @endif
                                            @if (12 -
                                                    ($daily->end_unit - $daily->start_unit) -
                                                    now()->parse($daily->hm_bd)->diffInHours($daily->hm_bd_end) <
                                                    0)
                                                <td>0</td>
                                                <td>
                                                    {{ 12 - ($daily->end_unit - $daily->start_unit) }}
                                                </td>
                                            @else
                                                <td>
                                                    {{ 12 -($daily->end_unit - $daily->start_unit) -now()->parse($daily->hm_bd)->diffInHours($daily->hm_bd_end) }}
                                                </td>

                                                <td>
                                                    {{ now()->parse($daily->hm_bd)->diffInHours($daily->hm_bd_end) }}
                                                </td>
                                            @endif
                                            <td>{{ $daily->operator }}</td>
                                            {{-- <td>
                                                <form method="post" action="{{ route('daily.destroy', $daily->id) }}">
                                                    @csrf
                                                    <a class="btn btn-warning btn-sm " title="Edit"
                                                        href="{{ route('daily.edit', $daily->id) }}">
                                                        <i data-feather="edit"></i>&nbsp;
                                                        Edit
                                                    </a>
                                                    @csrf
                                                    @method('DELETE')
                                                    <button class="btn btn-danger btn-sm " title="Hapus" type="submit"
                                                        onclick="return confirm('Apakah anda yakin ingin menghapus data ini?')">
                                                        <i data-feather="trash-2"></i>&nbsp;
                                                        Hapus
                                                    </button>
                                                </form>
                                            </td> --}}
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th colspan="3">Total</th>
                                        <th colspan="3">HM: {{ $totWh }}</th>
                                        <th></th>
                                        <th>WH: {{ $totWh }}</th>
                                        <th>STB: {{ $totStb }}</th>
                                        <th>BD: {{ $totBd }}</th>
                                        <th colspan=""></th>
                                    </tr>
                                    <tr>
                                        <th colspan="7">Akumulasi</th>
                                        <th colspan="">PA: {{ number_format((float) $pa, 2, '.', '') }} %</th>
                                        <th colspan="">UA: {{ number_format((float) $ua, 2, '.', '') }} %</th>
                                        <th colspan="">MA: {{ number_format((float) $ma, 2, '.', '') }} %</th>
                                        <th colspan="1"></th>
                                    </tr>
                                </tfoot>
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
    <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>

    <script>
        $(document).ready(function() {
            $('.pencarian').select2();
            let table = $('#datatablesSimple').DataTable();
        });
    </script>
@endsection
