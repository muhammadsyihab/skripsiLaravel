@extends('layouts.template')

@section('content')
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
                    <div class="card-header">Tambah Data Storage</div>
                    <div class="card-body">
                        <form method="post" action="{{ route('storage.store') }}" enctype="multipart/form-data">
                            @csrf
                            <!-- INPUT -->
                            <div class="row">
                                <div class="col">
                                    <div class="mb-3">
                                        <label for="master_lokasi_id">Lokasi Storage</label>
                                        <select class="form-control pencarian" name="master_lokasi_id"
                                            id="master_lokasi_id" required>
                                            <option value="" selected disabled>Lokasi</option>
                                            @foreach ($locations as $location)
                                                <option value="{{ $location->id }}">{{ $location->nama_lokasi }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="mb-3">
                                        <label for="nama_storage">Nama Storage</label>
                                        <input class="form-control" placeholder="Nama Storage" name="nama_storage" required> 
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <div class="mb-3">
                                        <label for="kapasitas">Kapasitas Storage (CM)</label>
                                        <input class="form-control" placeholder="Kapasitas Storage" name="kapasitas"
                                            type="number" step="0.01" required>
                                    </div>
                                </div>
                            </div>

                            <!-- End INPUT -->
                            <br>
                            <div class="row">
                                <div class="col">
                                    <a href="{{ route('lokasi.index') }}" class="btn btn-red btn-lg" role="button"
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
                                                    Data anda akan disimpan.
                                                    Pastikan Form diatas telah terisi dengan benar!
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
@endsection
