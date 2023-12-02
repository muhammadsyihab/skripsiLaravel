@extends('layouts.template')

@section('content')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />

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
                    <div class="card-header">Tambah Data Perbaikan</div>
                    <div class="card-body">
                        <form method="post" action="{{ route('service.store') }}" enctype="multipart/form-data">
                            @csrf
                            <!-- INPUT -->
                            <div class="row">
                                <div class="col">
                                    <div class="mb-3">
                                        <label for="hm">HM Triger</label>
                                        <input class="form-control" placeholder="HM Triger" name="hm" type="number"
                                        min="0" value="{{ old('hm') }}" required>
                                        @error('hm')
                                            <div class="text-danger mt-5">Tolong isi dengan benar</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <div class="mb-3">
                                        <label for="spareparts">Sparepart</label><br>
                                    <select class="form-control form-control-solid pencarian" id="spareparts[]"
                                        name="spareparts[]" multiple="multiple" required>
                                            <option value="" selected disabled>-- Pilih Sparepart --</option>
                                            @foreach ($spareparts as $sparepart)
                                                <option value="{{ $sparepart->id }}"{{ old('sparepart_id') == $sparepart->id ? ' selected' : '' }}>{{ $sparepart->nama_item }} - {{ $sparepart->part_number }}</option>
                                            @endforeach
                                        </select>
                                        @error('sparepart_id')
                                            <div class="text-danger mt-5">Tolong isi dengan benar</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-5">
                                <div class="col">
                                    <div class="mb-3">
                                        <label for="master_unit_id">Unit</label><br>
                                        <select class="form-control units pencarian" id="master_unit_id" name="master_unit_id" required>
                                            <option value="" selected disabled>-- Pilih Unit --</option>
                                            @foreach ($units as $unit)
                                                <option value="{{ $unit->id }}{{ old('master_unit_id') == $unit->id ? ' selected' : '' }}">
                                                    {{ $unit->no_lambung }} - {{ $unit->total_hm }} HM/KM</option>
                                            @endforeach
                                        </select>
                                        @error('master_unit_id')
                                            <div class="text-danger mt-5">Tolong isi dengan benar</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <!-- End INPUT -->
                            <br>
                            <div class="row">
                                <div class="col">
                                    <a href="{{ route('service.index') }}" class="btn btn-red btn-lg" role="button"
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
