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
                    <div class="card-header">Tambah Data Barang Keluar</div>
                    <div class="card-body">
                        <form method="post" action="{{ route('brgkeluar.store') }}" enctype="multipart/form-data">
                            @csrf
                            <!-- INPUT -->
                            <div class="row">
                                <div class="col">
                                    <div class="mb-3">
                                        <label for="tanggal_keluar">Tanggal Keluar</label>
                                        <input class="form-control" id="tanggal_keluar" name="tanggal_keluar"
                                            type="date">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <div class="mb-3">
                                        <label for="master_sparepart_id">Sparepart</label>
                                        <select class="form-control form-control-solid" id="master_sparepart_id"
                                            name="master_sparepart_id">
                                            <option value="" selected disabled>Sparepart</option>
                                            @foreach ($spareparts as $sparepart)
                                                <option value="{{ $sparepart->id }}">{{ $sparepart->nama_item }} -
                                                    {{ $sparepart->unit->no_lambung }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="mb-3">
                                        <label for="tb_tiketing_id">Kode Pengajuan Perbaikan</label>
                                        <select class="form-control form-control-solid" id="tb_tiketing_id"
                                            name="tb_tiketing_id">
                                            <option value="" selected disabled>Kode Pengajuan Perbaikan</option>
                                            @foreach ($tickets as $ticket)
                                                <option value="{{ $ticket->id }}">#00{{ $ticket->id }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="mb-3">
                                        <label for="penerima">Penerima</label>
                                        <select class="form-control form-control-solid" id="penerima" name="penerima">
                                            <option value="" selected disabled>Nama</option>
                                            @foreach ($users as $user)
                                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <div class="mb-3">
                                        <label for="qty_keluar">Quantity</label>
                                        <input class="form-control" placeholder="Jumlah" name="qty_keluar" type="number"
                                            min="0">
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="mb-3">
                                        <label for="hm_odo">HM / ODO</label>
                                        <input class="form-control" placeholder="HM" name="hm_odo" type="number"
                                            min="0">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <div class="mb-3">
                                        <label for="status">Status</label>
                                        <select class="form-control form-control-solid" id="status" name="status">
                                            <option selected disabled>Status</option>
                                            <option value="0">Sudah Diterima</option>
                                            <option value="1">Dikirim</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="mb-3">
                                        <label for="estimasi_pengiriman">Estimasi Pengiriman</label>
                                        <input class="form-control" placeholder="Estimasi Pengiriman"
                                            name="estimasi_pengiriman" type="number" min="0">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <div class="mb-3">
                                        <label for="photo">Foto</label>
                                        <img class="img-preview img-fluid mb-3 col-sm-5">
                                        <input class="form-control" placeholder="Photo" name="photo" id="photo"
                                            type="file" onchange="previewImage()">
                                    </div>
                                </div>
                            </div>
                            <!-- END INPUT -->
                            <br>
                            <div class="row">
                                <div class="col">
                                    <a href="{{ route('brgkeluar.index') }}" class="btn btn-red btn-lg" role="button"
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
