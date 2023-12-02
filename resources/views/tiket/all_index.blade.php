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
                        <form action="{{ route('allTiketFilter') }}" method="POST">
                            @csrf
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="bulan">Bulan</label>
                                    <input type="month" name="bulan" id="bulan" class="form-control">
                                </div>

                                @ho
                                    <div class="col-md-6 mb-3">
                                        <label for="">Cari Unit Berdasarkan Lokasi</label>
                                        <select data-column="2" class="form-control form-select filter-select">
                                            <option value="">-- Pilih Lokasi --</option>
                                            @foreach ($lokasi as $location)
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
                <div class="card card-header-actions">
                    <div class="card-header">
                        <div>
                            Daftar Semua Laporan Kerusakan
                            @planner
                                {{ $locationFilter->nama_lokasi ?? 'PIT P9S' }}
                            @endplanner
                            <div class="small text-muted">
                                <span class="fw-500 text-primary">Bulan</span>
                                &middot;
                                {{ now()->parse($date)->translatedFormat('F Y') ?? now()->translatedFormat('F Y') }}
                                &middot;
                                {{ now()->translatedFormat('g:i a') }}
                            </div>
                        </div>
                        <div class="small">
                            {{--  <a class="btn btn-outline-green float-right" href="{{ route('ticket.create') }}" role="button">
                                <i data-feather="plus-circle"></i> &nbsp Tambah </a>  --}}
                            {{-- <!-- Print PDF --> --}}
                            <button type="button" class="btn btn-outline-warning float-right" data-bs-toggle="modal"
                                data-bs-target="#exportPdf">
                                <i data-feather="printer"></i> &nbsp; PDF
                            </button>
                            <!-- Print pdf -->
                            <div class="modal fade" id="exportPdf" tabindex="-1" role="dialog"
                                aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <form method="post" action="{{ route('ticketall.pdf') }}" enctype="multipart/form-data"
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
                                                        <input type="month" class="form-control" name="date">
                                                    </div>
                                                    @ho
                                                        <div class="">
                                                            <label for="">Cari Berdasarkan Lokasi</label>
                                                            <select class="form-control" name="lokasi">
                                                                <option value="">-- Pilih Lokasi --</option>
                                                                @foreach ($lokasi as $location)
                                                                    <option value="{{ $location->id }}">
                                                                        {{ $location->nama_lokasi }}
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
                                    <form method="post" action="{{ route('ticketall.excel') }}" target="_blank"
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
                                                        <input type="month" class="form-control" name="date">
                                                    </div>
                                                    @ho
                                                        <div class="">
                                                            <label for="">Cari Berdasarkan Lokasi</label>
                                                            <select class="form-control" name="lokasi">
                                                                <option value="">-- Pilih Lokasi --</option>
                                                                @foreach ($lokasi as $location)
                                                                    <option value="{{ $location->id }}">
                                                                        {{ $location->nama_lokasi }}
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
                                        <th class="text-center">#</th>
                                        <th class="text-center">Nomor Lambung</th>
                                        @ho
                                            <th class="text-center">Local Area</th>
                                        @endho
                                        <th class="text-center">Nama Pembuat</th>
                                        <th class="text-center">Waktu Insiden</th>
                                        <th class="text-center">Kerusakan</th>
                                        <th class="text-center">Status</th>
                                        <th class="text-center">Prioritas</th>
                                        <th class="text-center">Foto Insiden</th>
                                        <th class="text-center">Tindakan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($tiket as $t)
                                        <tr>
                                            <td>00{{ $t->id }}</td>
                                            <td>{{ $t->no_lambung }}</td>
                                            @ho
                                                <td>{{ $t->nama_lokasi }}</td>
                                            @endho
                                            <td>{{ $t->name }}</td>
                                            <td>{{ \Carbon\Carbon::parse($t->waktu_insiden)->diffForHumans() }}</td>
                                            <td>{{ $t->judul }}</td>
                                            {{-- status tiket --}}
                                            @if ($t->status_ticket === '0')
                                                <td>Tiket Dibuat</td>
                                            @elseif ($t->status_ticket === '1')
                                                <td>Analisa Mekanik</td>
                                            @elseif ($t->status_ticket === '2')
                                                <td>Laporan Mekanik</td>
                                            @elseif ($t->status_ticket === '3')
                                                <td>Proses Planner</td>
                                            @elseif ($t->status_ticket === '4')
                                                <td>Tindakan Planner</td>
                                            @elseif ($t->status_ticket === '5')
                                                <td>Proses Logistik</td>
                                            @elseif ($t->status_ticket === '6')
                                                <td>Tindakan Logistik</td>
                                            @elseif ($t->status_ticket === '7')
                                                <td>Proses GL</td>
                                            @elseif ($t->status_ticket === '8')
                                                <td>Implementasi Mekanik</td>
                                            @else
                                                <td><span class="badge bg-success">Selesai</span></td>
                                            @endif
                                            {{-- status tiket --}}
                                            {{-- prioritas --}}
                                            @if ($t->prioritas === '0')
                                                <td> <span class="badge bg-secondary">Low</span> </td>
                                            @elseif ($t->status_ticket === '1')
                                                <td> <span class="badge bg-warning">Medium</span></td>
                                            @else
                                                <td><span class="badge bg-success">High</span></td>
                                            @endif
                                            {{-- prioritas --}}
                                            @if (empty($t->photo) || $t->photo === 'null')
                                                <td class="text-center"><img
                                                        src="{{ asset('storage/camera_default.png') }}" height="60"
                                                        width="60" alt=""></td>
                                            @else
                                                <td class="text-center"><img
                                                        src="{{ asset('storage/tiketPhoto/' . $t->photo) }}"
                                                        height="60" width="60" alt=""></td>
                                            @endif
                                            <td class="align-middle">
                                                <div class="row">
                                                    <div class="d-flex justify-content-between">
                                                        @if ($t->status_ticket < '6')
                                                            <a class="btn btn-danger btn-sm"
                                                                href="{{ route('pengaduan.show', $t->id) }}">
                                                                <i class="fas fa-eye"></i>&nbsp;Show
                                                            </a>&nbsp;
                                                            {{-- <a class="btn btn-info btn-sm"
                                                                href="{{ route('ticket.vue.show', $t->id) }}"><i
                                                                    class="fas fa-eye"></i>&nbsp;Show</a>&nbsp; --}}
                                                            @planner
                                                                <a class="btn btn-warning btn-sm"
                                                                    href="{{ route('ticket.edit', $t->id) }}"><i
                                                                        class="fas fa-pen"></i>&nbsp;Edit</a>&nbsp;
                                                            @endplanner
                                                        @else
                                                            <a class="btn btn-danger btn-sm"
                                                                href="{{ route('pengaduan.show', $t->id) }}">
                                                                <i class="fas fa-eye"></i>&nbsp;Show
                                                            </a>&nbsp;
                                                            @planner
                                                                <a class="btn btn-secondary btn-sm"
                                                                    href="{{ route('ticket.edit', $t->id) }}"><i
                                                                        class="fas fa-check-double"></i>&nbsp;Buka</a>
                                                            @endplanner
                                                        @endif
                                                    </div>
                                                </div>
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
                    <div class="col-md-6 small">Copyright &copy; {{ env('APP_NAME') }} 2022</div>
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
            let table = $('#datatablesSimple').DataTable({
                order: [
                    [0, 'desc']
                ],
            });

            $('.filter-select').change(function() {
                table.column($(this).data('column'))
                    .search($(this).val())
                    .draw();
            });

        });
    </script>
@endsection
