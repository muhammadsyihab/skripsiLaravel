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
                    <div class="card-header">Tambah Data Sparepart</div>
                    <div class="card-body">
                        <form method="post" action="{{ route('sparepart.store') }}" enctype="multipart/form-data">
                            @csrf
                            <!-- INPUT -->
                            <div class="row">
                                <div class="col">
                                    <div class="mb-3">
                                        <label for="nama_item">Nama Item</label>
                                        <input class="form-control" placeholder="Nama Item" name="nama_item" type="text" value="{{old('nama_item')}}" required>
                                        @error('nama_item')
                                            <div class="text-danger">Tolong isi dengan benar</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="mb-3">
                                        <label for="part_number">Nomor Part</label>
                                        <input class="form-control" placeholder="Part Number" name="part_number"
                                            type="text" value="{{old('part_number')}}" required>
                                        @error('part_number')
                                            <div class="text-danger">Tolong isi dengan benar</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <div class="mb-3">
                                        <label for="qty">Quantity</label>
                                        <input class="form-control" placeholder="QTY Sparepart -- bisa tidak diisi"
                                            name="qty" type="number" min="0" value="{{old('qty')}}">
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="mb-3">
                                        <label for="uom">UOM</label>
                                        <input class="form-control" placeholder="Satuan" name="uom" type="text" value="{{old('uom')}}" required>
                                        @error('uom')
                                            <div class="text-danger">Tolong isi dengan benar</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            {{-- <div class="row">
                                <div class="col">
                                    <div class="mb-3">
                                        <label for="jenis">Jenis</label>
                                        <select name="jenis" id="jenis" class="form-control units">
                                            <option value="" selected disabled>--- Pilih Jenis ---</option>
                                            <option value="sparepart"{{ old('jenis') == 'sparepart' ? ' selected' : '' }}>Sparepart</option>
                                            <option value="oli"{{ old('jenis') == 'oli' ? ' selected' : '' }}>Oli</option>
                                        </select>
                                        @error('jenis')
                                            <div class="text-danger">Tolong isi dengan benar</div>
                                        @enderror
                                    </div>
                                </div>
                            </div> --}}
                            <!-- End INPUT -->
                            <br>
                            <div class="row">
                                <div class="col">
                                    <a href="{{ route('sparepart.index') }}" class="btn btn-red btn-lg" role="button"
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
