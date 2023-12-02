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
                <div class="card card-header-actions">
                    <div class="card-header">
                        <div>
                            Daftar Perbaikan {{ $locationFilter->nama_lokasi ?? 'All PIT' }}
                            <div class="small text-muted">
                                <span class="fw-500 text-primary">{{ now()->format('l') }}</span>
                                &middot; {{ now()->format('F j, Y') }} &middot; {{ now()->format('g:i a') }}
                            </div>
                        </div>
                        <div>
                            <a class="btn btn-outline-green float-right" href="{{ route('service.create') }}" role="button">
                                <i data-feather="plus-circle"></i> &nbsp Tambah </a>
                            <!-- Print PDF -->
                            {{-- <a class="btn btn-outline-yellow float-right" href="#" role="button" target="_blank">
                                <i data-feather="printer"></i> &nbsp PDF </a> --}}
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

                        @ho
                        <div class="mb-5">
                            <div class="col-md-5 mb-3">
                                <label for="">Cari Unit Berdasarkan Type</label>
                                <input type="text" class="form-control filter-input" placeholder="Cari Type..." data-column="1">
                            </div>
                            <div class="col-md-5 mb-3">
                                <label for="">Cari Unit Berdasarkan Lokasi</label>
                                <select data-column="3" class="form-control form-select filter-select">
                                    <option value="">-- Pilih Lokasi --</option>
                                    @foreach ($locations as $location)
                                        <option value="{{ $location->nama_lokasi }}">{{ $location->nama_lokasi }}</option>
                                    @endforeach
                                </select> 
                            </div>
                        </div>
                        @endho

                        <div class="table-responsive table-responsive-xxl text-nowrap">
                            <table class="table table-bordered table-striped" id="datatablesSimple">
                                <thead>
                                    <tr>
                                        <th class="text-center">Spareparts</th>
                                        <th class="text-center">Type</th>
                                        <th class="text-center">Nomor Lambung</th>
                                        <th class="text-center">Local Area</th>
                                        <th class="text-center">HM Triger</th>
                                        <th class="text-center">Status</th>
                                        @planner
                                        <th class="text-center">Tindakan</th>
                                        @endplanner
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($services as $service)
                                        <tr>
                                            <td>
                                                {{-- <ul class="list-group">
                                                    @foreach ($service->spareparts as $sparepart )
                                                    <li class="list-group-item">{{ $sparepart->nama_item }} - {{ $sparepart->part_number }}</li>
                                                    @endforeach
                                                </ul> --}}
                                                {{ $service->nama_sparepart }}
                                            </td>
                                            <td>{{ $service->jenis }}</td>
                                            <td>{{ $service->no_lambung }} - {{ $service->total_hm }} HM/KM</td>
                                            <td>{{ $service->nama_lokasi}}</td>
                                            <td>{{ $service->hm }}</td>
                                            @if ($service->status == 0)
                                                <td><span class="badge bg-danger">Belum Service</span></td>
                                            @elseif ($service->status == 1)
                                                <td><span class="badge bg-success">Sudah Service</span></td>
                                            @endif
                                            @planner
                                            <td>
                                                <form method="post" action="{{ route('service.destroy', $service->id) }}">
                                                    @csrf
                                                    <a class="btn btn-warning btn-sm" title="Edit"
                                                        href="{{ route('service.edit', $service->id) }}">
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
                                            @endplanner
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
        // $('#datatablesSimple').DataTable();

        $(document).ready(function () {
            let table = $('#datatablesSimple').DataTable( {
                "pageLength": 50,
                order: [[4, 'desc']],
                rowsGroup: [1]
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
