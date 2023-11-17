@extends('layouts.template')

@section('content')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
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
                    <div class="card-header">Edit Data Barang Masuk</div>
                    <div class="card-body">
                        <form method="post" action="{{ route('brgmasuk.update', $brgmasukById->id) }}"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PATCH')
                            <!-- INPUT -->
                            <div class="row">
                                <div class="col">
                                    <div class="mb-3">
                                        <label for="item_price">Harga Satuan</label>
                                        <input class="form-control" placeholder="Item Price" name="item_price"
                                            type="number" min="0"
                                            value="{{ old('item_price', $brgmasukById->item_price) }}">
                                        @error('item_price')
                                            <div class="text-danger">Tolong isi dengan benar</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="mb-3">
                                        <label for="qty_masuk">Quantity Masuk</label>
                                        <input class="form-control" placeholder="Quantity Masuk" name="qty_masuk"
                                            type="number" min="0"
                                            value="{{ old('qty_masuk', $brgmasukById->qty_masuk) }}">
                                        @error('qty_masuk')
                                            <div class="text-danger">Tolong isi dengan benar</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <div class="mb-3">
                                        <label for="vendor">Suplier</label>
                                        <textarea class="form-control" name="vendor" id="vendor" cols="30" rows="3" placeholder="Suplier">{{ old('vendor', $brgmasukById->vendor) }}</textarea>
                                        @error('vendor')
                                            <div class="text-danger">Tolong isi dengan benar</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-5">
                                <div class="col">
                                    <div class="mb-3">
                                        <label for="master_sparepart_id">Sparepart</label>
                                        <select class="form-control form-control-solid pencarian" id="master_sparepart_id"
                                            name="master_sparepart_id">
                                            <option selected disabled>-- Sparepart / Oli --</option>
                                            @foreach ($spareparts as $sparepart)
                                                <option
                                                    value="{{ $sparepart->id }}"{{ old('master_sparepart_id', $sparepart->id) === $brgmasukById->master_sparepart_id ? ' selected' : '' }}>
                                                    {{ $sparepart->nama_item }} - {{ $sparepart->part_number }} -
                                                    @currency($sparepart->item_price) / {{ $sparepart->uom }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('master_sparepart_id')
                                            <div class="text-danger mt-5">Tolong isi dengan benar</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <!-- END INPUT -->
                            <br>
                            <div class="row">
                                <div class="col">
                                    <a href="{{ route('brgmasuk.index') }}" class="btn btn-red btn-lg" role="button"
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
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.pencarian').select2();
        });
    </script>
@endsection
