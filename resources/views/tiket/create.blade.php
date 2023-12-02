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
                    <div class="card-header">Tambah Laporan Kerusakan</div>
                    <div class="card-body">
                        <form method="post" action="{{ route('ticket.store') }}" enctype="multipart/form-data">
                            @csrf
                            <!-- INPUT -->
                            <div class="row mb-4">
                                <div class="mb-3">
                                    <label for="nama_pembuat">Nama Pembuat</label>
                                    <select class="form-control form-control-solid units" id="nama_pembuat"
                                        name="nama_pembuat" required>
                                        <option value="" selected disabled>Nama </option>
                                        @foreach ($users as $user)
                                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="row mb-4">
                                <div class="mb-3">
                                    <label for="master_unit_id">Nama Unit</label>
                                    <select class="form-control form-control-solid units" id="master_unit_id"
                                        name="master_unit_id" required>
                                        <option value="" selected disabled>Nama Unit</option>
                                        @foreach ($units as $unit)
                                            <option value="{{ $unit->id }}">{{ $unit->nama_unit }} -
                                                {{ $unit->no_lambung }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <div class="mb-3">
                                        <label for="judul">Judul Insiden</label>
                                        <input class="form-control" placeholder="judul" name="judul" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <div class="mb-3">
                                        <label for="waktu_insiden">Waktu Insiden</label>
                                        <input class="form-control" placeholder="waktu_insiden" name="waktu_insiden"
                                            type="datetime-local" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="mb-3">
                                    <label for="prioritas">Prioritas</label>
                                    <select class="form-control form-control-solid" id="prioritas" name="prioritas" required>
                                        <option value="" selected disabled>--- Prioritas ---</option>
                                        <option value="0">Low</option>
                                        <option value="1">Medium</option>
                                        <option value="2">High</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <div class="mb-3">
                                        <label for="photo">Foto</label>
                                        <img class="img-preview img-fluid mb-3 col-sm-5">
                                        <input class="form-control" placeholder="photo" name="photo" id="photo"
                                            type="file" onchange="previewImage()" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="mb-3">
                                    <label for="status_ticket">Status Ticket</label>
                                    <select class="form-control form-control-solid" id="status_ticket" name="status_ticket" required>
                                        <option value="" selected disabled>--- Status ---</option>
                                        <option value="0">Pengaduan Dibuat</option>
                                        <option value="1">Acc dan Priority planner</option>
                                        <option value="2">Request Sparepart</option>
                                        <option value="3">Pengiriman Sparepart</option>
                                        <option value="4">Pemasangan</option>
                                        {{-- <option value="5">Ground Test</option> --}}
                                        <option value="6">Pengaduan Selesai</option>
                                    </select>
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="col">
                                    <a href="{{ route('ticket.index') }}" class="btn btn-red btn-lg" role="button"
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
                                                        Yakin?</h5>
                                                    <button class="btn-close" type="button" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    Data anda akan disimpan.
                                                    Pastikan form diatas terisi dengan benar!
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
                    <div class="col-md-6 small">Copyright &copy; {{ env('APP_NAME') }} 2022</div>
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

        // bikin preview foto
        function previewImage() {
            const image = document.querySelector('#photo');
            const imgPreview = document.querySelector('.img-preview');

            imgPreview.style.display = 'block';

            const oFReader = new FileReader();
            oFReader.readAsDataURL(image.files[0]);

            oFReader.onload = function(oFREvent) {
                imgPreview.src = oFREvent.target.result;
            }
        }
    </script>
@endsection
