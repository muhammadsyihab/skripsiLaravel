@extends('layouts.template')

@section('content')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>

    <div id="layoutSidenav_content">
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div><br />
        @endif
        <main>
            <header class="page-header page-header-dark bg-gradient-primary-to-secondary pb-10">
                <div class="container-xl px-4">
                    <div class="page-header-content pt-4">
                    </div>
                </div>
            </header>
            <!-- Main page content-->
            <div class="container-xl px-4 mt-n10">
                <div class="card">
                    <div class="card-header">Edit Jadwal Pegawai</div>
                    <div class="card-body">
                        <form method="post" action="{{ route('update-jadwal', $jadwal->id) }}"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PATCH')
                            <!-- INPUT -->
                            <div class="row">
                                <div class="mb-3">
                                    <label for="users_id">Nama Pegawai</label>
                                    <input type="text" hidden class="form-control" name="users_id"
                                        value="{{ $jadwal->users_id }}">
                                    <input type="text" disabled class="form-control" name="nama"
                                        value="{{ $jadwal->user->name }} - {{ $jadwal->user->jabatan }}">
                                </div>
                            </div>
                            <div class="row mb-4">
                                <div class="col">
                                    <div class="mb-3">
                                        <label for="master_unit_id">Unit</label>
                                        <select name="master_unit_id" id="master_unit_id" class="form-control units">
                                            <option value="" selected>Pilih Unit</option>
                                            @foreach ($unit as $u)
                                                <option
                                                    value="{{ $u->id }}"{{ $jadwal->master_unit_id === $u->id ? 'selected' : '' }}>
                                                    {{ $u->jenis }} -
                                                    {{ $u->no_lambung }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            {{-- <div class="row">
                                <div class="mb-3">
                                    <label for="grup_id">Grup</label>
                                    <select name="grup_id" id="grup_id" class="form-control">
                                        <option value="">Pilih Grup</option>
                                        @foreach ($grup as $g)
                                            <option
                                                value="{{ $g->id }}"{{ $jadwal->grup_id === $g->id ? 'selected' : '' }}>
                                                {{ $g->nama_grup }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div> --}}
                            <div class="row">
                                <div class="mb-3">
                                    <label for="shift_id">Shift</label>
                                    <select name="shift_id" id="shift_id" class="form-control">
                                        <option value="">Pilih Shift</option>
                                        @foreach ($shift as $s)
                                            <option
                                                value="{{ $s->id }}"{{ $jadwal->shift_id === $s->id ? 'selected' : '' }}>
                                                {{ $s->waktu }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="row mb-3">

                                @forelse($tagline as $item)
                                    <div class="col-md-6">
                                        <label for="jam_kerja_masuk">Jam Kerja Masuk</label>
                                        <input type="datetime-local" name="{{ 'jam_kerja_masuk[' . $item->id . ']' }}"
                                            id="jam_kerja_masuk" class="form-control"
                                            value="{{ $item->jam_kerja_masuk ?? '' }}">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="jam_kerja_keluar">Jam Kerja Keluar</label>
                                        <input type="datetime-local" name="{{ 'jam_kerja_keluar[' . $item->id . ']' }}"
                                            id="jam_kerja_keluar" class="form-control"
                                            value="{{ $item->jam_kerja_keluar ?? '' }}">
                                    </div>
                                @empty
                                @endforelse

                                {{-- <div id="newTaglineRow">
                                </div>

                                <div class="col-md-6">
                                    <button type="button" class="btn btn-secondary btn-sm mb-4 mt-2"
                                        id="addTaglineRow">Tambahkan Jadwal +</button>
                                </div> --}}
                            </div>

                            <br>
                            <div class="row">
                                <div class="col">
                                    <a href="{{ route('jadwal') }}" class="btn btn-red btn-lg" role="button"
                                        aria-pressed="true">Kembali</a>

                                    <!-- Button trigger modal -->
                                    <button class="btn btn-lg btn-teal" type="button" data-bs-toggle="modal"
                                        data-bs-target="#exampleModalCenter">Simpan</button>

                                    <!-- Modal -->
                                    <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog"
                                        aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalCenterTitle">Apakah Anda Yakin?
                                                    </h5>
                                                    <button class="btn-close" type="button" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    Data anda akan diperbaharui.
                                                    Pastikan form diatas telah terisi dengan benar!
                                                </div>
                                                <div class="modal-footer"><button class="btn btn-secondary" type="button"
                                                        data-bs-dismiss="modal">Tutup</button>
                                                    <button class="btn btn-primary" type="submit">Simpan</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
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
            $('.units').select2();
        });
    </script>
@endsection
