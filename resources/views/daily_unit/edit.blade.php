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
                    <div class="card-header">Edit Data Daily Unit</div>
                    <div class="card-body">
                        <form action="{{ route('daily.update', $day->id) }}" method="post" enctype="multipart/form-data">
                            @csrf
                            @method('PATCH')
                            <div class="row">
                                <div class="col">
                                    <div class="mb-3">
                                        <label for="user_id">Nama Operator</label>
                                        <select name="user_id" id="user_id" class="form-control units">
                                            @foreach ($user as $user)
                                                <option
                                                    value="{{ $user->id }}"{{ $day->users_id === $user->id ? 'selected' : '' }}>
                                                    {{ $user->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="mb-3">
                                        <label for="master_unit_id">Nama Unit</label>
                                        <select name="master_unit_id" id="master_unit_id" class="form-control  units">
                                            @foreach ($unit as $unit)
                                                <option
                                                    value="{{ $unit->id }}"{{ $day->master_unit_id === $unit->id ? 'selected' : '' }}>
                                                    {{ $unit->nama_unit }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <div class="mb-3">
                                        <label for="tanggal">Tanggal Operasi</label>
                                        <input type="date" class="form-control" name="tanggal"
                                            value="{{ $day->tanggal }}">
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="mb">
                                        <label for="end_unit">Lama Kerja Unit (Jam)</label>
                                        <input type="number" name="end_unit" id="end_unit" min="0"
                                            class="form-control" value="{{ $day->end_unit }}">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <div class="mb-3">
                                        <label for="qty_fuel_awal">Quantity Fuel Awal</label>
                                        <input type="number" class="form-control" min="0" name="qty_fuel_awal"
                                            value="{{ $day->qty_fuel_awal }}">
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="mb-3">
                                        <label for="qty_fuel_end">Quantity Fuel Akhir</label>
                                        <input type="number" class="form-control" min="0" name="qty_fuel_end"
                                            value="{{ $day->qty_fuel_end }}">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <div class="mb-3">
                                        <label for="wh">WH</label>
                                        <input type="number" class="form-control" name="wh" min="0"
                                            name="wh" value="{{ $day->qty_fuel_end }}">
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="mb-3">
                                        <label for="bd">BD</label>
                                        <input type="number" class="form-control" name="bd" min="0"
                                            name="bd" value="{{ $day->qty_fuel_end }}">
                                    </div>
                                </div>
                            </div>

                            <!-- End INPUT -->
                            <br>
                            <div class="row">
                                <div class="col">
                                    <a href="{{ route('daily.index') }}" class="btn btn-red btn-lg" role="button"
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
