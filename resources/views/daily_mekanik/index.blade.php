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
                        <form action="{{ route('mekanik.filter') }}" method="POST">
                            @csrf
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="bulan">Bulan</label>
                                    <input type="month" name="bulan" id="bulan" class="form-control">
                                </div>
                                @ho
                                    <div class="col-md-6">
                                        <label for="">Cari Unit Berdasarkan Lokasi</label>
                                        <select data-column="4" class="form-control form-select filter-select">
                                            <option value="">-- Pilih Lokasi --</option>
                                            @foreach ($locations as $location)
                                                <option value="{{ $location->nama_lokasi }}">{{ $location->nama_lokasi }}
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
                <div class="card">
                    <div class="card-header">
                        Data Aktivitas Mekanik
                        <div class="small text-muted">
                            <span class="fw-500 text-primary">Bulan</span>
                            &middot; {{ now()->parse($date)->translatedFormat('F Y') ?? now()->translatedFormat('F Y') }}
                            &middot;
                            {{ now()->translatedFormat('g:i a') }}
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
                        {{--  <a class="btn btn-outline-green float-right" href="{{ route('mekanik.create') }}" role="button"><i data-feather="plus-circle"></i> &nbsp ADD </a>  --}}
                        <!-- Print PDF -->
                        <!-- <a class="btn btn-outline-yellow float-right" href="#" role="button" target="_blank"><i data-feather="printer"></i> &nbsp PDF </a> -->
                        <div class="table-responsive table-responsive-xxl text-nowrap">
                            <table class="table table-bordered table-striped" id="datatablesSimple">
                                <thead>
                                    <tr>
                                        <th class="text-center">Nama Mekanik</th>
                                        <th class="text-center">Unit</th>
                                        <th class="text-center">Tanggal</th>
                                        <th class="text-center">Shift</th>
                                        <th class="text-center">Area</th>
                                        <th class="text-center">Kerusakan</th>
                                        <th class="text-center">Perbaikan</th>
                                        {{-- <th class="text-center">Status</th> --}}
                                        <th class="text-center">Estimasi HM/BD</th>
                                        <th class="text-center">HM/BD</th>
                                        <th class="text-center">Keterangan</th>
                                        <th class="text-center">Tindakan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($mekanik as $mk)
                                        <tr>
                                            <td>{{ $mk->name }}</td>
                                            <td>{{ $mk->no_lambung }}</td>
                                            <td>{{ $mk->jam_kerja_masuk }} - {{ $mk->jam_kerja_keluar }}</td>
                                            <td>{{ $mk->waktu }}</td>
                                            {{-- <td>{{ $mk->nama_lokasi }}</td> --}}
                                            <td>{{ $mk->nama_lokasi }}</td>
                                            <td>{{ $mk->kerusakan }}</td>
                                            <td>{{ $mk->perbaikan }}</td>
                                            {{-- @if ($mk->status === '0')
                                                <td><span class="badge bg-secondary">Stand By</span></td>
                                            @elseif ($mk->status === '1')
                                                <td><span class="badge bg-primary">Work</span></td>
                                            @elseif ($mk->status === '2')
                                                <td><span class="badge bg-danger">Breakdown</span></td>
                                            @endif --}}
                                            <td>{{ $mk->estimasi_perbaikan_hm }} HM</td>
                                            <td>{{ $mk->perbaikan_hm }} HM</td>
                                            <td>{{ $mk->keterangan }}</td>
                                            <td class="text-center">
                                                <a class="btn btn-warning btn-sm" title="Edit"
                                                    href="{{ route('mekanik.edit', $mk->id) }}">
                                                    <i data-feather="edit"></i>&nbsp;
                                                    Edit
                                                </a>
                                                {{--  <form method="post" action="{{ route('mekanik.destroy', $mk->id) }}">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button class="btn btn-danger btn-sm" title="Hapus" type="submit"
                                                        onclick="return confirm('Apakah anda yakin ingin menghapus data ini?')">
                                                        <i data-feather="trash-2"></i>&nbsp;
                                                        Hapus
                                                    </button>
                                                </form>  --}}
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
    <script>
        $(document).ready(function() {
            let table = $('#datatablesSimple').DataTable();
            $('.filter-select').change(function() {
                table.column($(this).data('column'))
                    .search($(this).val())
                    .draw();
            });
        })
    </script>
@endsection
