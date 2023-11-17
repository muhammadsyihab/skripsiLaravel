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
                    <div class="card-header">Silahkan Isi Tabel Berikut!</div>
                    <div class="card-body">
                        <form method="post" action="{{ route('mekanik.update', $mekanik->id) }}"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PATCH')
                            <!-- INPUT -->
                            <div class="row">
                                <div class="col">
                                    <div class="mb-3">
                                        <label for="users_id">Nama Pegawai</label>
                                        <input type="hidden" name="users_id" value="{{ $mekanik->users_id }}">
                                        <input type="text" class="form-control" readonly name="nama"
                                            value="{{ $mekanik->user->name }}">
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
                                                    value="{{ $unit->id }}"{{ $unit->id === $mekanik->master_unit_id ? ' selected' : '' }}>
                                                    {{ $unit->nama_unit }} - {{ $unit->no_lambung }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <div class="mb-3">
                                        <label for="kerusakan">Kerusakan</label>
                                        <input class="form-control" name="kerusakan" type="text"
                                            value="{{ $mekanik->kerusakan }}">
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="mb-3">
                                        <label for="perbaikan">Perbaikan</label>
                                        <input class="form-control" name="perbaikan" type="text"
                                            value="{{ $mekanik->perbaikan }}">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <div class="mb-3">
                                        <label for="estimasi_perbaikan_hm">Estimasi Perbaikan</label>
                                        <input class="form-control" name="estimasi_perbaikan_hm" type="text"
                                            value="{{ $mekanik->estimasi_perbaikan_hm }}">
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="mb-3">
                                        <label for="perbaikan_hm">HM/BD Unit Untuk Perbaikan</label>
                                        <input class="form-control" name="perbaikan_hm" type="text"
                                            value="{{ $mekanik->perbaikan_hm }}">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <div class="mb-3">
                                        <label for="status">Status</label>
                                        <select class="form-control" name="status" id="status">
                                            <option value="0" {{ $mekanik->status === '0' ? 'selected' : '' }}>Stand
                                                By
                                            </option>
                                            <option value="1" {{ $mekanik->status === '1' ? 'selected' : '' }}>Work
                                            </option>
                                            <option value="2" {{ $mekanik->status === '2' ? 'selected' : '' }}>Break
                                                Down
                                            </option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="mb-3">
                                        <label for="keterangan">Keterangan</label>
                                        <input class="form-control" name="keterangan" type="text"
                                            value="{{ $mekanik->keterangan }}">
                                    </div>
                                </div>
                            </div>

                            <!-- END INPUT -->
                            <br>
                            <div class="row">
                                <div class="col">
                                    <a href="{{ route('mekanik.index') }}" class="btn btn-red btn-lg" role="button"
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
                                                    <h5 class="modal-title" id="exampleModalCenterTitle">Apakah Anda
                                                        Yakin?
                                                    </h5>
                                                    <button class="btn-close" type="button" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    Data anda akan diperbaharui.
                                                    Pastikan form diatas telah terisi dengan benar!
                                                </div>
                                                <div class="modal-footer"><button class="btn btn-secondary"
                                                        type="button" data-bs-dismiss="modal">Tutup</button>
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
