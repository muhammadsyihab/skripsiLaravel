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
                    <div class="card-header">Edit Daily Operator</div>
                    <div class="card-body">
                        <form method="post" action="{{ route('operator.update', $operator->id) }}"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PATCH')
                            <!-- INPUT -->
                            <div class="row">
                                <div class="col">
                                    <div class="mb-3">
                                        <label for="users_id">Nama Pegawai</label>
                                        <input type="text" class="form-control" readonly
                                            name="users_id"value="{{ $operator->user->name }}">
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="mb-3">
                                        <label for="master_unit_id">Unit</label>
                                        <select class="form-control form-control-solid units" id="master_unit_id"
                                            name="master_unit_id">
                                            <option value="" selected disabled>Pilih Unit</option>
                                            @foreach ($unit as $unit)
                                                <option
                                                    value="{{ $unit->id }}"{{ $unit->id === $operator->master_unit_id ? ' selected' : '' }}>
                                                    {{ $unit->nama_unit }} - {{ $unit->no_lambung }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <div class="mb-3">
                                        <label for="jam_kerja_masuk">Jam Masuk</label>
                                        <input type="datetime-local" class="form-control" readonly name="jam_kerja_masuk"
                                            type="number" value="{{ $operator->jadwal->jam_kerja_masuk }}">
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="mb-3">
                                        <label for="jam_kerja_keluar">Jam keluar</label>
                                        <input type="datetime-local" class="form-control" readonly name="jam_kerja_keluar"
                                            type="number" value="{{ $operator->jadwal->jam_kerja_keluar }}">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <div class="mb-3">
                                        <label for="hm">HM</label>
                                        <input class="form-control" readonly name="hm" type="text"
                                            value="{{ $operator->hm }}">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <div class="mb-3">
                                        <label for="status">Status</label>
                                        <select class="form-control" name="status" id="status">
                                            <option value="0" {{ $operator->status === '0' ? 'selected' : '' }}>Mulai
                                            </option>
                                            <option value="1" {{ $operator->status === '1' ? 'selected' : '' }}>
                                                Selesai
                                            </option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <!-- END INPUT -->
                            <br>
                            <div class="row">
                                <div class="col">
                                    <a href="{{ route('operator.index') }}" class="btn btn-red btn-lg" role="button"
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
