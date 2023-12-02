@extends('layouts.template')

@section('content')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>

    <div id="layoutSidenav_content">
        @if ($errors->any())
            <div class="alert alert-yellow">
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
                    <div class="card-header">Edit Data Fuel To Suply</div>
                    <div class="card-body">
                        <form action="{{ route('fuel-suply.update', $suplierById->id) }}" method="post"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PATCH')
                            <!-- INPUT -->
                            <div class="row mb-5">
                                <div class="col">
                                    <div class="mb-3">
                                        <label for="fuel_to_stock_id">Tanggal Stock</label>
                                        <select name="fuel_to_stock_id" id="fuel_to_stock_id"
                                            class="form-control form-control-solid pencarian" required>
                                            <option value="" selected disabled>-- Date Stock --</option>
                                            @foreach ($stocks as $stock)
                                                <option
                                                    value="{{ $stock->id }}"{{ $stock->id === $suplierById->fuel_to_stock_id ? ' selected' : '' }}>
                                                    {{ now()->parse($stock->tanggal)->translatedFormat('j F Y') }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <div class="mb-3">
                                        <label for="transporter">Pengiriman</label>
                                        <input class="form-control" placeholder="Transporter" name="transporter"
                                            type="text" value="{{ $suplierById->transporter }}" required>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="mb-3">
                                        <label for="no_plat_kendaraan">Nomor Plat Kendaraan</label>
                                        <input class="form-control" placeholder="Nomor Plat Kendaraan"
                                            name="no_plat_kendaraan" type="text"
                                            value="{{ $suplierById->no_plat_kendaraan }}" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <div class="mb-3">
                                        <label for="no_surat_jalan">Nomor Surat Jalan</label>
                                        <input class="form-control" placeholder="Nomor Surat Jalan" name="no_surat_jalan"
                                            type="text" value="{{ $suplierById->no_surat_jalan }}" required>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="mb-3">
                                        <label for="driver">Nama Driver</label>
                                        <input class="form-control" placeholder="Nama Driver" name="driver" type="text"
                                            value="{{ $suplierById->driver }}" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <div class="mb-3">
                                        <label for="penerima">Nama Penerima</label>
                                        <input class="form-control" placeholder="Nama Penerima" name="penerima"
                                            type="text" value="{{ $suplierById->penerima }}" required>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="mb-3">
                                        <label for="storage_id">Nama Storage</label>
                                        <select class="form-control form-control-solid units" id="storage_id"
                                            name="storage_id" required>
                                            @foreach ($storages as $storage)
                                                <option
                                                    value="{{ $storage->id }}"{{ $suplierById->storage_id == $storage->id ? ' selected' : '' }}>
                                                    {{ strtoupper($storage->nama_storage) }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <div class="mb-3">
                                        <label for="tc_storage_sebelum">TC Storage Sebelum (CM)</label>
                                        <input class="form-control" placeholder="TC Storage Sebelum (CM)"
                                            name="tc_storage_sebelum" type="number" step="0.01"
                                            value="{{ $suplierById->tc_storage_sebelum }}" required>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="mb-3">
                                        <label for="tc_storage_sesudah">TC Storage Sesudah (CM)</label>
                                        <input class="form-control" placeholder="TC Storage Sesudah (CM)"
                                            name="tc_storage_sesudah" type="number" step="0.01"
                                            value="{{ $suplierById->tc_storage_sesudah }}" required>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="mb-3">
                                        <label for="suhu_diterima">Suhu Diterima (CELCIUS)</label>
                                        <input class="form-control" placeholder="Suhu Diterima (CELCIUS)"
                                            name="suhu_diterima" type="number" value="{{ $suplierById->suhu_diterima }}"
                                            min="0" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <div class="mb-3">
                                        <label for="qty_by_do">QTY BY DO</label>
                                        <input class="form-control" placeholder="TC Kenaikan Storage (CM)"
                                            name="qty_by_do" type="number" value="{{ $suplierById->qty_by_do }}"
                                            min="0" required>
                                    </div>
                                </div>
                            </div>
                            <!-- End INPUT -->
                            <br>
                            <div class="row">
                                <div class="col">
                                    <a href="{{ route('fuel-suply.index') }}" class="btn btn-red btn-lg" role="button"
                                        aria-pressed="true">Kembali</a>
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
            $('.pencarian').select2();
        });
    </script>
@endsection
