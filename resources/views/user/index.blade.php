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

                @ho
                    <div class="card mb-3">
                        <div class="card-header">
                            Filter
                        </div>
                        <div class="card-body">
                            <div class="mb-5">
                                <div class="col-md-5 mb-3">
                                    <label for="">Cari Pengguna Berdasarkan Lokasi</label>
                                    <select data-column="1" class="form-control form-select filter-select">
                                        <option value="">-- Pilih Lokasi --</option>
                                        @foreach ($locations as $location)
                                            <option value="{{ $location->nama_lokasi }}">{{ $location->nama_lokasi }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                @endho
                <div class="card card-header-actions">
                    <div class="card-header">
                        <div>
                            Daftar Pengguna {{ $locationFilter->nama_lokasi ?? 'Semua PIT' }}
                            <div class="small text-muted">
                                <span class="fw-500 text-primary">{{ now()->translatedFormat('l') }}</span>
                                &middot; {{ now()->translatedFormat('F j, Y') }} &middot;
                                {{ now()->translatedFormat('g:i a') }}
                            </div>
                        </div>
                        <div>
                            <a class="btn btn-outline-primary float-right" href="{{ route('user.create') }}" role="button">
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
                                    <form method="post" action="{{ route('user.pdf') }}" enctype="multipart/form-data"
                                        target="_blank">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Export PDF</h5>
                                            </div>
                                            <div class="modal-body">

                                                @csrf
                                                <div class="row mb-3">
                                                    <div class="col-md-6">
                                                        <label for="master_lokasi_id">PIT</label>
                                                        <select class="form-control form-control-solid"
                                                            id="master_lokasi_id" name="master_lokasi_id" required>
                                                            <option value="" selected disabled>Lokasi</option>
                                                            @foreach ($locations as $lk)
                                                                <option
                                                                    value="{{ $lk->id }}"{{ old('master_lokasi_id') == $lk->id ? ' selected' : '' }}>
                                                                    {{ $lk->nama_lokasi }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                        @error('master_lokasi_id')
                                                            <div class="text-danger">Tolong isi dengan benar</div>
                                                        @enderror
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
                            {{--  <button type="button" class="btn btn-outline-green float-right" data-bs-toggle="modal"
                                data-bs-target="#exportExcel">
                                <i data-feather="external-link"></i>
                                &nbsp; Export Excel
                            </button>  --}}
                            <!-- Export Excel -->
                            <div class="modal fade" id="exportExcel" tabindex="-1" role="dialog"
                                aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <form method="post" action="{{ route('user.excel') }}" enctype="multipart/form-data"
                                        target="_blank">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Export Excel</h5>
                                            </div>
                                            <div class="modal-body">

                                                @csrf
                                                <div class="row mb-3">

                                                    <div class="col-md-6">
                                                        <label for="master_lokasi_id">PIT</label>
                                                        <select class="form-control form-control-solid"
                                                            id="master_lokasi_id" name="master_lokasi_id" required>
                                                            <option value="" selected disabled>Lokasi</option>
                                                            @foreach ($locations as $lk)
                                                                <option
                                                                    value="{{ $lk->id }}"{{ old('master_lokasi_id') == $lk->id ? ' selected' : '' }}>
                                                                    {{ $lk->nama_lokasi }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                        @error('master_lokasi_id')
                                                            <div class="text-danger">Tolong isi dengan benar</div>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-bs-dismiss="modal">Close</button>
                                                <button type="submit" class="btn btn-warning">Buat Excel</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>

                            {{-- import excel --}}
                            {{--  <button type="button" class="btn btn-outline-green float-right" data-bs-toggle="modal"
                                data-bs-target="#importExcel">
                                <i data-feather="external-link"></i>
                                &nbsp; Import Excel
                            </button>  --}}
                            <!-- Import Excel -->
                            <div class="modal fade" id="importExcel" tabindex="-1" role="dialog"
                                aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <form method="post" action="{{ route('user.import') }}"
                                        enctype="multipart/form-data">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Import Excel</h5>
                                            </div>
                                            <div class="modal-body">

                                                @csrf
                                                <a href="https://dev-aneka2.neuhost.co.id/formatExcel/Pengguna.xlsx"
                                                    target=”_blank”>Link Format Import</a>
                                                <br />
                                                <br />
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
                                        {{--  <th>Photo Profile</th>  --}}
                                        <th class="text-center">Nama Pegawai</th>
                                        <th class="text-center">Lokasi</th>
                                        <th class="text-center">Jabatan</th>
                                        <th class="text-center">Email</th>
                                        <th class="text-center">No Telp</th>
                                        <th class="text-center">Jenis Kelamin</th>
                                        <th class="text-center">Tindakan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($users as $u)
                                        <tr>
                                            {{--  <td><img src="{{ asset('storage/Register/' . $u->photo) }}" height="60" width="60" alt=""></td>  --}}
                                            <td>{{ $u->name }}</td>
                                            @if (empty($u->master_lokasi_id))
                                                <td>-</td>
                                            @else
                                                <td>{{ $u->nama_lokasi }}</td>
                                            @endif
                                            <td>{{ $u->jabatan }}</td>
                                            <td>{{ $u->email }}</td>
                                            <td>{{ $u->no_telp }}</td>
                                            <td>
                                                @if ($u->jenis_kelamin === '0')
                                                    <p>Laki-Laki</p>
                                                @else
                                                    <p>Perempuan</p>
                                                @endif
                                            </td>
                                            <td>
                                                <form method="post" action="{{ route('user.destroy', $u->id) }}">
                                                    @csrf
                                                    <a class="btn btn-warning btn-sm " title="Edit"
                                                        href="{{ route('user.edit', $u->id) }}"><i
                                                            data-feather="edit"></i>&nbsp;
                                                        Edit</a>
                                                    @csrf
                                                    @method('DELETE')
                                                    <button class="btn btn-danger btn-sm" type="submit" title="Hapus"
                                                        onclick="return confirm('Apakah anda yakin ingin menghapus data ini?')">
                                                        <i data-feather="trash-2"></i>&nbsp; Hapus</button>
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
    <script>
        $(document).ready(function() {
            let table = $('#datatablesSimple').DataTable({
                "pageLength": 50,
                order: [
                    [0, 'asc']
                ],
                rowsGroup: [0]
            });

            $('.filter-select').change(function() {
                table.column($(this).data('column'))
                    .search($(this).val())
                    .draw();
            });

        })
    </script>
@endsection
