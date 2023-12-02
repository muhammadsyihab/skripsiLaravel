@extends('layouts.template')

@section('content')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>

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
                <div class="card">
                    <div class="card-header">Tambah Jadwal Pegawai</div>
                    <div class="card-body">
                        @if (session()->has('danger'))
                            <div class="alert alert-danger" role="alert">
                                {{ session('danger') }}
                            </div>
                        @endif
                        <form method="post" action="{{ route('jadwal') }}" enctype="multipart/form-data">
                            @csrf
                            <!-- INPUT -->
                            <div class="row mb-3">
                                <div class="mb-3">
                                    <label for="users_id">Nama Pegawai</label>
                                    <select name="users_id" id="users_id" class="form-control units" required>
                                        <option value="" selected disabled>Pilih Pegawai</option>
                                        @foreach ($usersall as $u)
                                            <option value="{{ $u->id }}">{{ $u->name }} - {{ $u->jabatan }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col">
                                    <div class="mb-3">
                                        <label for="master_unit_id">Unit</label>
                                        <select name="master_unit_id" id="master_unit_id" class="form-control units"
                                            required>
                                            <option value="" selected disabled>Pilih Unit</option>
                                            @foreach ($unit as $u)
                                                <option value="{{ $u->id }}">{{ $u->nama_unit }} -
                                                    {{ $u->no_lambung }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="mb-3">
                                    <label for="shift_id">Shift</label>
                                    <select name="shift_id" id="shift_id" class="form-control" required>
                                        <option value="" selected disabled>Pilih Shift</option>
                                        @foreach ($shift as $s)
                                            <option value="{{ $s->id }}">{{ $s->waktu }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="row mb-3 inputFormTaglineRow">
                                <div class="col-md-6">
                                    <label for="jam_kerja_masuk">Jam Kerja Masuk</label>
                                    <input type="datetime-local" name="jam_kerja_masuk[]" id="jam_kerja_masuk[]"
                                        class="form-control">
                                </div>
                                <div class="col-md-6">
                                    <label for="jam_kerja_keluar">Jam Kerja Keluar</label>
                                    <input type="datetime-local" name="jam_kerja_keluar[]" id="jam_kerja_keluar[]"
                                        class="form-control">
                                </div>

                                <div class="col-md-6">
                                    <button type="button"
                                        class="btn btn-danger btn-sm mb-4 mt-2 remove-table-row">Hapus</button>
                                </div>
                            </div>

                            <div id="newTaglineRow">
                            </div>

                            <div class="col-md-6">
                                <button type="button" class="btn btn-secondary btn-sm mb-4 mt-2"
                                    id="addTaglineRow">Tambahkan Jadwal +</button>
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
                                                    Data anda akan disimpan.
                                                    Pastikan form diatas terisi dengan benar!
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

@push('script-tambahan')
    <script src="{{ url('https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js') }}"></script>

    <script type="text/javascript">
        // add row
        $("#addTaglineRow").click(function() {
            var html = '';
            html +=
                '<div class="row mb-3 inputFormTaglineRow"><div class="col-md-6"><label for="jam_kerja_masuk">Jam Kerja Masuk</label><input type="datetime-local" name="jam_kerja_masuk[]" id="jam_kerja_masuk[]"class="form-control"></div><div class="col-md-6"><label for="jam_kerja_keluar">Jam Kerja Keluar</label><input type="datetime-local" name="jam_kerja_keluar[]" id="jam_kerja_keluar[]" class="form-control"></div><div class="col-md-6" ><button type="button"class = "btn btn-danger btn-sm mb-4 mt-2 remove-table-row"> Hapus </button></div> </div>';
            $('#newTaglineRow').append(html);
        });

        // remove row
        $(document).on('click', '.remove-table-row', function() {
            $(this).closest('.inputFormTaglineRow').remove();
        });
    </script>
@endpush
