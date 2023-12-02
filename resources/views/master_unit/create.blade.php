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
                    <div class="card-header">Tambah Data Unit</div>
                    <div class="card-body">
                        <form method="post" action="{{ route('unit.store') }}" enctype="multipart/form-data">
                            @csrf
                            <!-- INPUT -->
                            <div class="row">
                                <div class="col">
                                    <div class="mb-3">
                                        <label for="no_serial">Nomor Serial Unit</label>
                                        <input class="form-control" placeholder="Nomor Serial Unit" name="no_serial" required>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="mb-3">
                                        <label for="no_lambung">Nomor Lambung Unit</label>
                                        <input class="form-control" placeholder="Nomor Unit" name="no_lambung" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <div class="mb-3">
                                        <label for="jenis">Jenis Unit</label>
                                        <input class="form-control" placeholder="Jenis Unit" name="jenis" required>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="mb-3">
                                        <label for="total_hm">Total HM/KM</label>
                                        <input class="form-control" placeholder="Total HM/KM" name="total_hm" type="number" step="0.01" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                {{-- <div class="mb-3">
                                    <label for="master_lokasi_id">Lokasi Unit</label>
                                    <select class="form-control pencarian" name="master_lokasi_id" id="master_lokasi_id" required>
                                        <option value="" selected disabled>Lokasi Unit</option>
                                        @foreach ($lokasi as $l)
                                            <option value="{{ $l->id }}">{{ $l->nama_lokasi }}</option>
                                        @endforeach
                                    </select>
                                </div> --}}
                                <div class="col mb-3">
                                    <label for="status_unit">Status Unit</label>
                                    <select class="form-control form-control-solid" id="status_unit" name="status_unit" required>
                                        <option value="" selected disabled>Status Unit</option>
                                        <option value="0">Ready</option>
                                        <option value="1">Work</option>
                                        <option value="2">Break Down</option>
                                    </select>
                                </div>
                                <div class="col mb-3">
                                    <label for="status_kepemilikan">Aset</label>
                                    <input class="form-control" placeholder="Aset Unit" name="status_kepemilikan" required>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <div class="mb-3">
                                        <label for="keterangan">Keterangan</label>
                                        <input class="form-control" placeholder="Keterangan" name="keterangan" required>
                                    </div>
                                </div>
                            </div>

                            <!-- End INPUT -->
                            <br>
                            <div class="row">
                                <div class="col">
                                    <a href="{{ route('unit.index') }}" class="btn btn-red btn-lg" role="button"
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
                                                    Data anda akan tersimpan.
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
@endsection
