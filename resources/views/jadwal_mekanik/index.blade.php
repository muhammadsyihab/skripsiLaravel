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
                <div class="row mb-3">
                    <div class="col-lg-12">
                        <div class="card card-header-actions mb-3">
                            <div class="card-header border-bottom">
                                <ul class="nav nav-tabs card-header-tabs" id="cardTab" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" id="semua-tab" href="#semua" data-bs-toggle="tab"
                                            role="tab" aria-controls="semua" aria-selected="true">Semua</a>
                                    </li>
                                    {{-- @foreach ($lokasi as $l)
                                        <li class="nav-item">
                                            <a class="nav-link" id="{{ str_replace(' ', '', $l->nama_lokasi) }}-tab"
                                                href="#{{ str_replace(' ', '', $l->nama_lokasi) }}" data-bs-toggle="tab"
                                                role="tab" aria-controls="{{ str_replace(' ', '', $l->nama_lokasi) }}"
                                                aria-selected="false">{{ $l->nama_lokasi }}</a>
                                        </li>
                                    @endforeach --}}
                                </ul>
                                <a class="btn btn-outline-green float-right" href="{{ route('buat-jadwal-mekanik') }}"
                                    role="button"><i data-feather="plus-circle"></i> &nbsp Tambah </a>
                            </div>
                            <div class="card-body">
                                <div class="tab-content" id="cardTabContent">
                                    <div class="tab-pane fade show active" id="semua" role="tabpanel"
                                        aria-labelledby="semua-tab">
                                        <h5 class="card-title mb-3">Jadwal Mekanik Keseluruhan</h5>
                                        <div class="table-responsive table-responsive-xxl text-nowrap">
                                            <table class="operator table table-bordered table-striped" id="table3">
                                                <thead>
                                                    <tr>
                                                        <th class="text-center">Nama Mekanik</th>
                                                        <th class="text-center">Lokasi</th>
                                                        <th class="text-center">Shift</th>
                                                        {{-- <th class="text-center">Jadwal Kerja Masuk</th>
                                                        <th class="text-center">Jadwal Kerja Keluar</th> --}}
                                                        <th class="text-center">Tindakan</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($mekanik as $op)
                                                        <tr>
                                                            <td>{{ $op->name }}</td>
                                                            <td>PIT P9S</td>
                                                            <td>{{ $op->waktu }}</td>
                                                            <td class="flex-inline d-flex">

                                                                <a href="#exampleModal"
                                                                    data-remote="{{ route('show-jadwal-mekanik', $op->id) }}"
                                                                    class="btn btn-secondary btn-sm" data-bs-toggle="modal"
                                                                    data-bs-target="#exampleModal"><i
                                                                        class="fa fa-eye"></i>&nbsp;
                                                                    Jadwal</a> &nbsp;

                                                                <div class="modal fade" id="exampleModal" tabindex="-1"
                                                                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                                    <div class="modal-dialog modal-lg" role="document">
                                                                        <div class="modal-content">
                                                                            <div class="modal-header">
                                                                                <h5 class="modal-title"
                                                                                    id="exampleModalLabel">Jadwal Masuk dan Keluar
                                                                                </h5>
                                                                                
                                                                            </div>
                                                                            <div class="modal-body">
                                                                                ...
                                                                            </div>
                                                                            <div class="modal-footer">
                                                                                <button type="button"
                                                                                    class="btn btn-warning"
                                                                                    data-bs-dismiss="modal">Close</button>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <a href="{{ route('edit-jadwal-mekanik', $op->id) }}"
                                                                    class="btn btn-warning btn-sm" title="Edit"><i
                                                                        data-feather="edit"></i>&nbsp;
                                                                    Edit</a> &nbsp;

                                                                <form action="{{ route('hapus-jadwal-mekanik', $op->id) }}"
                                                                    method="POST">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button class="btn btn-danger btn-sm" type="submit"
                                                                        title="Hapus"
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
                                    {{-- @foreach ($lokasi as $l)
                                        <div class="tab-pane fade" id="{{ str_replace(' ', '', $l->nama_lokasi) }}"
                                            role="tabpanel"
                                            aria-labelledby="{{ str_replace(' ', '', $l->nama_lokasi) }}-tab">
                                            <h5 class="card-title">Jadwal Operator {{ $l->nama_lokasi }}</h5>
                                            <div class="table-responsive table-responsive-xxl text-nowrap">
                                                <table class="table table-bordered table-striped operator" id="table3">
                                                    <thead>
                                                        <tr>
                                                            <th class="text-center">Nama Operator</th>
                                                            <th class="text-center">Unit</th>
                                                            <th class="text-center">Jadwal Kerja Masuk</th>
                                                            <th class="text-center">Jadwal Kerja Keluar</th>
                                                            <th class="text-center">Lokasi</th>
                                                            <th class="text-center">Shift</th>
                                                            <th class="text-center">Tindakan</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($operator as $op)
                                                            @if ($op->grup->master_lokasi_id === $l->id)
                                                                <tr>
                                                                    <td>{{ $op->name }}</td>
                                                                    <td>{{ $op->nama_unit }} - {{ $op->no_lambung }} -
                                                                        @if ($op->status_unit === '0')
                                                                            <span class="badge bg-secondary">Stand
                                                                                By</span>
                                                                        @elseif ($op->status_unit === '1')
                                                                            <span class="badge bg-primary">Work</span>
                                                                        @elseif ($op->status_unit === '2')
                                                                            <span class="badge bg-danger">Breakdown</span>
                                                                        @endif
                                                                    </td>
                                                                    <td>{{ $op->jam_kerja_masuk }}</td>
                                                                    <td>{{ $op->jam_kerja_keluar }}</td>
                                                                    <td>OTW</td>
                                                                    <td>{{ $op->waktu }}</td>
                                                                    <td class="flex-inline d-flex">
                                                                        <form
                                                                            action="{{ route('hapus-jadwal', $op->id) }}"
                                                                            method="POST">
                                                                            @csrf
                                                                            <a href="{{ route('edit-jadwal', $op->id) }}"
                                                                                class="btn btn-warning btn-sm"
                                                                                title="Edit"><i
                                                                                    data-feather="edit"></i>&nbsp;
                                                                                Edit</a>
                                                                            @csrf
                                                                            @method('DELETE')
                                                                            <button class="btn btn-danger btn-sm"
                                                                                type="submit" title="Hapus"
                                                                                onclick="return confirm('Apakah anda yakin ingin menghapus data ini?')">
                                                                                <i data-feather="trash-2"></i>&nbsp;
                                                                                Hapus
                                                                            </button>
                                                                        </form>
                                                                    </td>
                                                                </tr>
                                                            @endif
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    @endforeach --}}
                                </div>
                            </div>
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
            $('#table1').DataTable({
                lengthMenu: [
                    [5, 10, 15, -1],
                    [5, 10, 15, 'All'],
                ],
            });
            $('#table2').DataTable({
                lengthMenu: [
                    [5, 10, 15, -1],
                    [5, 10, 15, 'All'],
                ],
            });
            $('#table3').DataTable();
            $('#table4').DataTable();
            $('#table5').DataTable();
            $('table.operator').DataTable();
            $('table.mekanik').DataTable();
        });
    </script>

    <script>
        jQuery(document).ready(function($) {
            $('#exampleModal').on('show.bs.modal', function(e) {
                var button = $(e.relatedTarget);
                var modal = $(this);

                modal.find('.modal-body').load(button.data("remote"));
                modal.find('.modal-title').html(button.data("title"));
            });
        });
    </script>
@endsection
