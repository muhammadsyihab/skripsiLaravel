@extends('layouts.template')

@section('content')
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
                                    <input type="month" name="date" id="date" class="form-control" required>
                                </div>
                            </div>
                            <div class="row mb-5">
                                <div class="col-md-8 mb-3">
                                    <label for="unit">Unit</label><br>
                                    <select class="form-control pencarian w-100" id="unit" name="unit" required>
                                        <option value="" selected disabled>-- Pilih Unit --</option>
                                        @foreach ($units as $unit)
                                            <option value="{{ $unit->id }}{{ old('unit') == $unit->id ? ' selected' : '' }}">
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
                {{-- <div class="card card-header-actions">
                    <div class="card-header">
                        <div>
                            Daily Unit - {{ $judul }}
                            <div class="small text-muted">
                                <span class="fw-500 text-primary">{{ now()->format('l') }}</span>
                                &middot; {{ now()->format('F j, Y') }} &middot; {{ now()->format('g:i a') }}
                            </div>
                        </div>
                        <div>
                            <!-- Print PDF -->
                            <a class="btn btn-outline-yellow float-right" href="#" role="button" target="_blank"><i
                                    data-feather="printer"></i> &nbsp PDF </a>
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
                                        <th rowspan="2" class="text-center" style="vertical-align: middle">Tanggal
                                            Operasi</th>
                                        <th rowspan="2" class="text-center" style="vertical-align: middle">Shift</th>
                                        <th rowspan="2" class="text-center" style="vertical-align: middle">Nama Operator
                                        </th>
                                        <th rowspan="2" class="text-center" style="vertical-align: middle">Nama Unit</th>
                                        <th colspan="3" class="text-center">HM</th>
                                        <th rowspan="2" class="text-center" style="vertical-align: middle">Pengisian Fuel
                                        </th>
                                        <th rowspan="2" class="text-center" style="vertical-align: middle">Penggunaan
                                            Fuel</th>
                                        <th rowspan="2" class="text-center" style="vertical-align: middle">WH</th>
                                        <th rowspan="2" class="text-center" style="vertical-align: middle">STB</th>
                                        <th rowspan="2" class="text-center" style="vertical-align: middle">BD</th>
                                        <th rowspan="2" class="text-center" style="vertical-align: middle">Tindakan</th>
                                    </tr>
                                    <tr>
                                        <th class="text-center">Start</th>
                                        <th class="text-center">End</th>
                                        <th class="text-center">Time Oprasional</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    @foreach ($dailys as $daily)
                                        <tr>

                                            <td rowspan="1">{{ now()->parse($daily->tanggal)->format('j F Y') }}</td>
                                            <td>{{ $daily->shift->waktu }}</td>
                                            <td>{{ $daily->user->name }}</td>
                                            <td>{{ $daily->unit->no_lambung }}</td>
                                            <td>{{ $daily->start_unit }}</td>
                                            <td>{{ $daily->end_unit }}</td>
                                            <td>{{ $daily->end_unit - $daily->start_unit }}</td>
                                            <td>{{ $daily->fuelUnits->sum('qty_to_unit') }}</td>
                                            <td>{{ $daily->fuelUnits->sum('qty_to_unit') }}</td>
                                            <td>{{ $daily->end_unit - $daily->start_unit }}</td>
                                            <td>{{ $daily->stb_true }}</td>
                                            <td>{{ $daily->bd_daily }}</td>
                                            <td>
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
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th colspan="4">Total</th>
                                        <th colspan="3">HM: {{ $totWh }}</th>
                                        <th colspan="2"></th>
                                        <th>WH: {{ $totWh }}</th>
                                        <th>STB: {{ $totStb }}</th>
                                        <th>BD: {{ $totBd }}</th>
                                    </tr>
                                    <tr>
                                        <th colspan="4">Akumulasi</th>
                                        <th colspan="3">PA: {{ number_format($pa, '2', '.', '')}} %</th>
                                        <th colspan="3">UA: {{ number_format($ua, '2', '.', '')}} %</th>
                                        <th colspan="2">MA: {{ number_format($ma, '2', '.', '')}} %</th>
                                        <th colspan="3">PA: {{ $pa }} %</th>                                        
                                        <th colspan="3">UA: {{ $ua }} %</th>
                                        <th colspan="2">MA: {{ $ma }} %</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>  --}}
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
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.pencarian').select2();
            // $('#datatablesSimple').DataTable();
        });
    </script>
@endsection
