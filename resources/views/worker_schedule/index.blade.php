@extends('layouts.template')
@section('content')
    <link rel="stylesheet" type="text/css"
        href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.0.0-alpha1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <div id="layoutSidenav_content">
        <main>
            <!-- Main page content-->
            <div class="container-xl px-4 mt-4">
                <div class="row">
                    <div class="col-lg-8">
                        <!-- Daftar pekerja yang tidak punya jadwal-->
                        <div class="card mb-4">
                            <div class="card-header">Daftar Pekerja Yang Tidak Punya Jadwal</div>
                            <div class="card-body">

                                <table id="datatablesSimple1">
                                    <thead>
                                        <tr>
                                            <th width="300px">Nama</th>
                                            <th width="300px">Jadwal Kerja</th>
                                            <th width="300px">Unit</th>
                                            <th width="300px">Shift</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($users1 as $u1)
                                            <tr onclick="window.location='{{ route('detailjadwalpekerja', $u1->id) }}'">
                                                <td>{{ $u1->name }}</td>
                                                <td> - </td>
                                                <td> - </td>
                                                <td> - </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th width="300px">Nama</th>
                                            <th width="300px">Jadwal Kerja</th>
                                            <th width="300px">Unit</th>
                                            <th width="300px">Shift</th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                        <!-- Daftar Pekerja yang sudah punya jadwal-->
                        <div class="card mb-4">
                            <div class="card-header">Daftar Pekerja Yang Sudah Punya Jadwal</div>
                            <div class="card-body">

                                <table id="datatablesSimple2">
                                    <thead>
                                        <tr>
                                            <th width="300px">Nama</th>
                                            <th width="300px">Jadwal Kerja</th>
                                            <th width="300px">Unit</th>
                                            <th width="300px">Shift</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($users2 as $u2)
                                            <tr
                                                onclick="window.location='{{ route('detailjadwalpekerja', $u2->users_id) }}'">
                                                <td>{{ $u2->name }}</td>
                                                <td>{{ $u2->jam_kerja_masuk }} - {{ $u2->jam_kerja_keluar }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th width="300px">Nama</th>
                                            <th width="300px">Jadwal Kerja</th>
                                            <th width="300px">Unit</th>
                                            <th width="300px">Shift</th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <!-- Detail card-->
                        <div class="card mb-4">
                            <div class="card-header">Detail</div>
                            <div class="card-body">
                                <div class="card-body text-center">
                                    @if ($name === '-')
                                        <img class="img-account-profile rounded-circle mb-2"
                                            src="{{ asset('admin/dist/assets/img/illustrations/profiles/profile-1.png') }}"
                                            alt="" />
                                    @else
                                        <img class="img-account-profile rounded-circle mb-2"
                                            src="{{ asset('storage/Register/' . $photo) }}" alt="" />
                                    @endif
                                    <br><br>
                                    <div class="small font-italic text-muted mb-4">Nama : <input class="form-control"
                                            value="{{ $name }}" name="detailname" readonly /> </div>
                                    <div class="small font-italic text-muted mb-4">Jadwal Masuk : <input
                                            class="form-control" value="{{ $jadwalmasuk }}" name="detailjadwal"
                                            type="datetime-local" readonly /> </div>
                                    <div class="small font-italic text-muted mb-4">Jadwal Keluar : <input
                                            class="form-control" value="{{ $jadwalkeluar }}" name="detailstatus"
                                            type="datetime-local" readonly /> </div>
                                    <div class="small font-italic text-muted mb-4">Grup : <input class="form-control"
                                            value="{{ $grup }}" name="detailgrup" readonly /> </div>


                                    @if ($name === '-')
                                        <button class="btn btn-primary" disabled>Tambahkan Jadwal</button>
                                    @elseif ($jadwalmasuk === '-')
                                        <button class="btn btn-primary"
                                            onclick="window.location='{{ route('createjadwalpekerja', $detail->id) }}'">Tambahkan
                                            Jadwal</button>
                                    @elseif ($jadwalmasuk != '-')
                                        <button class="btn btn-primary"
                                            onclick="window.location='{{ route('editjadwalpekerja', $detail->id) }}'">Edit
                                            Jadwal</button>
                                        <form action="{{ route('hapusjadwalpekerja', $detail->id) }}" method="post"
                                            class="d-inline">
                                            @method('delete')
                                            @csrf
                                            <button class="btn btn-danger"
                                                onclick="return confirm('Yakin menghapus jadwal?')">Hapus Jadwal</button>
                                        </form>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="card mb-4">
                            <div class="card-header">Daftar Grup</div>
                            <div class="card-body">
                                <table id="datatablesSimple3">
                                    <thead>
                                        <tr>
                                            <th width="300px">Nama Grup</th>
                                            <th width="300px">Penempatan</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($listgrup as $lg)
                                            <tr onclick="window.location='{{ route('detailgruppekerja', $lg->id) }}'">
                                                <td>{{ $lg->nama_grup }}</td>
                                                <td>{{ $lg->lokasi->nama_lokasi }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th width="300px">Nama Grup</th>
                                            <th width="300px">Penempatan</th>
                                        </tr>
                                    </tfoot>
                                </table><br>
                                <div class="text-center">
                                    <button class="btn btn-primary"
                                        onclick="window.location='{{ route('creategruppekerja') }}'">Tambahkan
                                        Grup</button>
                                </div><br>
                                <div class="text-center">
                                    @if ($namegrup != '-')
                                        <button class="btn btn-warning"
                                            onclick="window.location='{{ route('editgruppekerja', $grupeditid) }}'">Edit
                                            Grup</button>
                                        <form action="{{ route('hapusgruppekerja', $grupidhapus) }}" method="post"
                                            class="d-inline">
                                            @method('delete')
                                            @csrf
                                            <button class="btn btn-danger"
                                                onclick="return confirm('Yakin menghapus Grup?')">Hapus Grup</button>
                                        </form>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="card mb-4">
                            <div class="card-header">Clear Jadwal</div>
                            <div class="card-body">
                                <h3 style="color:red; text-align:center">Warning!!!</h3>
                                <p>Tombol ini akan menghapus semua jadwal pekerja</p>
                                <div class="text-center">
                                    <form action="{{ route('hapusjadwalpekerjaall') }}" method="post" class="d-inline">
                                        @method('delete')
                                        @csrf
                                        <button class="btn btn-danger"
                                            onclick="return confirm('Yakin menghapus semua jadwal?')">Hapus Semua
                                            Jadwal</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
        <footer class="footer-admin mt-auto footer-light">

        </footer>
    </div>
    </div>
    <script src="{{ asset('admin/dist/js/datatables/workersscheduledatatable.js') }}"></script>
    <script src="{{ asset('admin/dist/js/datatables/workerscheduletable.js') }}"></script>
@endsection
