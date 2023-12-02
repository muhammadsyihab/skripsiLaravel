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
                        Filter
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                    <label for="">Cari Unit Berdasarkan Type</label>
                                    <input type="text" class="form-control filter-input" placeholder="Cari Type..."
                                        data-column="0">
                                </div>
                                @ho
                                    <div class="col-md-6 mb-3">
                                        <label for="">Cari Unit Berdasarkan Lokasi</label>
                                        <select data-column="6" class="form-control form-select filter-select">
                                            <option value="">-- Pilih Lokasi --</option>
                                            @foreach ($locations as $location)
                                                <option value="{{ $location->nama_lokasi }}">{{ $location->nama_lokasi }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                @endho
                        </div>
                    </div>
                </div>
                <div class="card card-header-actions">
                    <div class="card-header">
                        <div>
                            Daftar Unit {{ $locationFilter->nama_lokasi ?? 'Semua PIT' }}
                            <div class="small text-muted">
                                <span class="fw-500 text-primary">{{ now()->translatedFormat('l') }}</span>
                                &middot; {{ now()->translatedFormat('F j, Y') }} &middot; {{ now()->translatedFormat('g:i a') }}
                            </div>
                        </div>
                        <div>
                            @planner
                                <a class="btn btn-outline-primary float-right" href="{{ route('unit.create') }}" role="button">
                                    <i data-feather="plus-circle"></i> &nbsp; Tambah </a>
                            @endplanner
                            {{-- <!-- Print PDF --> --}}
                            <button type="button" class="btn btn-outline-warning float-right" data-bs-toggle="modal"
                                data-bs-target="#exportPdf">
                                <i data-feather="printer"></i> &nbsp; PDF
                            </button>
                            <!-- Print pdf -->
                            <div class="modal fade" id="exportPdf" tabindex="-1" role="dialog"
                                aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <form method="post" action="{{ route('unit.pdf') }}" enctype="multipart/form-data"
                                        target="_blank">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Export PDF</h5>
                                            </div>
                                            <div class="modal-body">

                                                @csrf
                                                @ho
                                                    <div class="row mb-3">
                                                        <div class="">
                                                            <label for="location">Pilih Lokasi</label>
                                                            <select name="location" id="location" class="form-control">
                                                                <option value="" selected disabled>-- Pilih Lokasi --
                                                                </option>

                                                                @foreach ($locations as $location)
                                                                    <option value="{{ $location->id }}">
                                                                        {{ $location->nama_lokasi }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                @endho
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
                                    <form method="post" action="{{ route('unit.excel') }}" target="_blank"
                                        enctype="multipart/form-data">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Export Excel</h5>
                                            </div>
                                            <div class="modal-body">
                                                @csrf
                                                @ho
                                                    <div class="row mb-3">
                                                        <div class="">
                                                            <label for="location">Pilih Lokasi</label>
                                                            <select name="location" id="location" class="form-control">
                                                                <option value="" selected disabled>-- Pilih Lokasi --
                                                                </option>

                                                                @foreach ($locations as $location)
                                                                    <option value="{{ $location->id }}">
                                                                        {{ $location->nama_lokasi }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                @endho
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
                            {{-- import excel --}}
                            <button type="button" class="btn btn-outline-green float-right" data-bs-toggle="modal"
                                data-bs-target="#importExcel">
                                <i data-feather="external-link"></i>
                                &nbsp; Import Excel
                            </button>
                            <!-- Import Excel -->
                            <div class="modal fade" id="importExcel" tabindex="-1" role="dialog"
                                aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <form method="post" action="{{ route('unit.import') }}"
                                        enctype="multipart/form-data">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Import Excel</h5>
                                            </div>
                                            <div class="modal-body">

                                                @csrf

                                                <div class="form-group">
                                                    <input type="file" class="form-control" name="file"
                                                        required="required">
                                                </div>

                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-bs-dismiss="modal">Close</button>
                                                <button type="submit" class="btn btn-primary">Import</button>
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
                                        <th class="text-center">Type</th>
                                        <th class="text-center">Aset</th>
                                        <th class="text-center">Nomor Serial</th>
                                        <th class="text-center">Nomor Lambung</th>
                                        <th class="text-center">Status</th>
                                        <th class="text-center">Keterangan</th>
                                        <th class="text-center">Local Area</th>
                                        <th class="text-center">HM/KM</th>
                                        <th class="text-center">HM/KM Service</th>
                                        {{-- <th class="text-center">HM/KM Breakdown</th> --}}
                                        <th class="text-center">Tindakan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($units as $unit)
                                        <tr>
                                            <td>{{ $unit->jenis }}</td>
                                            <td>Sewa</td>
                                            {{-- <td>{{ $unit->status_kepemilikan }}</td> --}}
                                            <td>{{ $unit->no_serial }}</td>
                                            <td>{{ $unit->no_lambung }}</td>
                                            @if ($unit->status_unit === '0')
                                                <td><span class="badge bg-secondary">Ready</span></td>
                                            @elseif ($unit->status_unit === '1')
                                                <td><span class="badge bg-primary">Working</span></td>
                                            @elseif ($unit->status_unit === '2')
                                                <td><span class="badge bg-danger">Breakdown</span></td>
                                            @elseif ($unit->status_unit === '3')
                                                <td><span class="badge bg-warning">Terjadwal</span></td>
                                            @endif
                                            <td>{{ $unit->keterangan }}</td>
                                            {{-- <td>{{ $unit->nama_lokasi }}</td> --}}
                                            <td>PIT A</td>
                                            <td>{{ $unit->total_hm }}</td>
                                            @if (is_null($unit->hm_triger))
                                                <td><span class="badge bg-warning">Belum plant service</span></td>
                                            @else
                                                <td>{{ $unit->hm_triger }}</td>
                                            @endif
                                            {{-- <td>{{ now()->parse($unit->hm_bd)->diffInHours($unit->hm_bd_end) }}</td> --}}

                                            <td>

                                                <form method="post" action="{{ route('unit.destroy', $unit->id) }}">

                                                    <a class="btn btn-info btn-sm " title="Riwayat"
                                                        href="{{ route('unit.show', $unit->id) }}">
                                                        <i data-feather="layers"></i>&nbsp;
                                                        Riwayat
                                                    </a>

                                                    @csrf
                                                    <a class="btn btn-warning btn-sm " title="Edit"
                                                        href="{{ route('unit.edit', $unit->id) }}">
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
    <script src="jquery.rowspanizer.js"></script>
    <script>
        $(document).ready(function() {
            let table = $('#datatablesSimple').DataTable({
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
