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
                <div class="row mb-3">
                    <div class="col-lg-6">
                        <div class="card">
                            <div class="card-header">List Pegawai Belum Terjadwal</div>
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
                                {{--  <a class="btn btn-outline-green float-right mb-3" href="{{ route('brgmasuk.create') }}"
                                    role="button">
                                    <i data-feather="copy"></i> &nbsp ADD </a>  --}}
                                <!-- Print PDF -->
                                <!-- <a class="btn btn-outline-yellow float-right" href="#" role="button" target="_blank"><i data-feather="printer"></i> &nbsp PDF </a> -->
                                <table id="table1">
                                    <thead>
                                        <tr>
                                            <th>Nama Pegawai</th>
                                            <th>Jadwal Bekerja</th>
                                            <th class="text-center">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($users as $user)
                                            <tr>
                                                <td>{{ $user->name }}</td>
                                                <td>-</td>
                                                <td>
                                                    <a href="{{ route('buat-jadwal', $user->id) }}"
                                                        class="btn btn-success"><i data-feather="plus-circle"></i> &nbsp
                                                        Buat Jadwal
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="card">
                            <div class="card-header">List Group</div>
                            <div class="card-body">
                                @if (session()->has('pesan'))
                                    <div class="alert alert-primary" role="alert">
                                        {{ session('pesan') }}
                                    </div>
                                @endif
                                @if (session()->has('danger'))
                                    <div class="alert alert-danger" role="alert">
                                        {{ session('danger') }}
                                    </div>
                                @endif
                                <a class="btn btn-outline-green float-right mb-3" href="{{ route('tambah-group') }}"
                                    role="button"><i data-feather="plus-circle"></i> &nbsp ADD </a>
                                <table id="table2">
                                    <thead>
                                        <tr>
                                            <th>Nama Group</th>
                                            <th>Lokasi</th>
                                            <th class="text-center">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($grup as $g)
                                            <tr>
                                                <td>{{ $g->nama_grup }}</td>
                                                <td>{{ $g->lokasi->nama_lokasi }}</td>
                                                <td class="flex-inline d-flex">
                                                    <a href="{{ route('edit-group', $g->id) }}"
                                                        class="btn btn-warning btn-sm" title="Edit"><i
                                                            data-feather="edit"></i>&nbsp;
                                                        Edit</a> &nbsp;
                                                    <form action="{{ route('hapus-group', $g->id) }}" method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button class="btn btn-danger btn-sm" type="submit" title="Delete">
                                                            <i data-feather="trash"></i>&nbsp;
                                                            Delete
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
                <div class="row mb-3">
                    <div class="card">
                        <div class="card-header">Buat jadwal selanjutnya</div>
                        <div class="card-body">
                            <form action="{{ route('jadwal-replicate') }}" method="POST">
                                @csrf
                                @method('POST')
                                <p class="text-center mb-3">Buat jadwal selanjutnya</p>
                                <div class="row mb-3">
                                    <div class="col-md-4">
                                        <label for="jam_kerja_masuk">Jam Kerja Masuk</label>
                                        <input type="datetime-local" name="jam_kerja_masuk" id="jam_kerja_masuk"
                                            class="form-control" required>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="jam_kerja_keluar">Jam Kerja Keluar</label>
                                        <input type="datetime-local" name="jam_kerja_keluar" id="jam_kerja_keluar"
                                            class="form-control" required>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="shift">Shift</label>
                                        <select name="shift" id="shift" class="form-control" required>
                                            <option value="">-- Pilih Shift --</option>
                                            <option value="1">Shift DAY</option>
                                            <option value="2">Shift NIGHT</option>
                                        </select>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary">Simpan</button>
                            </form>
                        </div>
                        <div class="card-footer">
                            <span class="text-warning">* Replikasi ini hanya berlaku untuk tanggal terakhir dari pekerja
                                yang telah terjadwal</span>
                        </div>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="card">
                        <div class="card-header">Jadwal Operator</div>
                        <div class="card-body">
                            <div class="row mb-3">
                                <div class="col">
                                    <table id="table3">
                                        <thead>
                                            <tr>
                                                <th>Nama Operator</th>
                                                <th>Unit</th>
                                                <th>Jadwal Kerja Masuk</th>
                                                <th>Jadwal Kerja Keluar</th>
                                                <th>Group</th>
                                                <th>Shift</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($operator as $op)
                                                <tr>
                                                    <td>{{ $op->name }}</td>
                                                    <td>{{ $op->nama_unit }} - {{ $op->no_lambung }} -
                                                        @if ($op->status_unit === '0')
                                                            <span class="badge bg-secondary">Stand By</span>
                                                        @elseif ($op->status_unit === '1')
                                                            <span class="badge bg-primary">Work</span>
                                                        @elseif ($op->status_unit === '2')
                                                            <span class="badge bg-danger">Breakdown</span>
                                                        @endif
                                                    </td>
                                                    <td>{{ $op->jam_kerja_masuk }}</td>
                                                    <td>{{ $op->jam_kerja_keluar }}</td>
                                                    <td>{{ $op->nama_grup }} - {{ $op->nama_lokasi }}</td>
                                                    <td>{{ $op->waktu }}</td>
                                                    <td class="flex-inline d-flex">
                                                        <a href="{{ route('edit-jadwal', $op->id) }}"
                                                            class="btn btn-warning btn-sm" title="Edit"><i
                                                                data-feather="edit"></i>&nbsp;
                                                            Edit</a> &nbsp;
                                                        <form action="{{ route('hapus-jadwal', $op->id) }}" method="POST">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button class="btn btn-danger btn-sm" type="submit"
                                                                title="Delete">
                                                                <i data-feather="trash"></i>&nbsp;
                                                                Delete
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
                </div>
                <div class="row mb-3">
                    <div class="card">
                        <div class="card-header">Jadwal Mekanik</div>
                        <div class="card-body">
                            <div class="row mb-3">
                                <div class="col">
                                    <table id="table4">
                                        <thead>
                                            <tr>
                                                <th>Nama Mekanik</th>
                                                <th>Unit</th>
                                                <th>Jadwal Kerja Masuk</th>
                                                <th>Jadwal Kerja Keluar</th>
                                                <th>Group</th>
                                                <th>Shift</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($mekanik as $mk)
                                                <tr>
                                                    <td>{{ $mk->name }}</td>
                                                    <td>{{ $mk->nama_unit }} - {{ $mk->no_lambung }} -
                                                        @if ($mk->status_unit === '0')
                                                            <span class="badge bg-secondary">Stand By</span>
                                                        @elseif ($mk->status_unit === '1')
                                                            <span class="badge bg-primary">Work</span>
                                                        @elseif ($mk->status_unit === '2')
                                                            <span class="badge bg-danger">Breakdown</span>
                                                        @endif
                                                    </td>
                                                    <td>{{ $mk->jam_kerja_masuk }}</td>
                                                    <td>{{ $mk->jam_kerja_keluar }}</td>
                                                    <td>{{ $mk->nama_grup }} - {{ $mk->nama_lokasi }}</td>
                                                    <td>{{ $mk->waktu }}</td>
                                                    <td class="flex-inline d-flex">
                                                        <a href="{{ route('edit-jadwal', $mk->id) }}"
                                                            class="btn btn-warning btn-sm" title="Edit"><i
                                                                data-feather="edit"></i>&nbsp;
                                                            Edit</a> &nbsp;
                                                        <form action="{{ route('hapus-jadwal', $mk->id) }}"
                                                            method="POST">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button class="btn btn-danger btn-sm" type="submit"
                                                                title="Delete">
                                                                <i data-feather="trash"></i>&nbsp;
                                                                Delete
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
        });
    </script>
@endsection
