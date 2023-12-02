@extends('layouts.template')

@section('content')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>

    <div id="layoutSidenav_content">
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    {{ $errors }}
                    @foreach ($errors->all() as $error)
                        <li>{{ $error->messages }}</li>
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
                    <div class="card-header">Tambah Data Fuel To Unit</div>
                    <div class="card-body">
                        @if (session()->has('danger'))
                            <div class="alert alert-danger" role="alert">
                                {{ session('danger') }}
                            </div>
                        @endif
                        <form method="post" action="{{ route('fuel-unit.store') }}" enctype="multipart/form-data">
                            @csrf
                            <!-- INPUT -->
                            <div class="row mb-4">
                                <div class="col">
                                    <div class="mb-3">
                                        <label for="fuel_to_stock_id">Tanggal Stock</label><br>
                                        <select name="fuel_to_stock_id" id="fuel_to_stock_id"
                                            class="form-control form-control-solid pencarian" required>
                                            <option value="" selected disabled>-- Tanggal Stock --</option>
                                            @foreach ($stocks as $stock)
                                                <option value="{{ $stock->id }}">
                                                    {{ now()->parse($stock->tanggal)->format('j F Y') }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="mb-3">
                                        <label for="daily_unit_id">Tanggal Daily Unit</label>
                                        <select name="daily_unit_id" id="daily_unit_id"
                                            class="form-control form-control-solid pencarian" required>
                                            <option value="" selected disabled>-- Tanggal Daily Unit --</option>
                                            @foreach ($dailys as $daily)
                                                <option value="{{ $daily->tanggal }}">
                                                    {{ now()->parse($daily->tanggal)->format('j F Y') }}
                                                    ({{ $daily->unit->no_lambung }})
                                                    {{ $daily->unit->lokasi->nama_lokasi }}
                                                    <i>{{ $daily->user->name }}</i>
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <div class="mb-3">
                                        <label for="qty_to_unit">Quantity To Unit (LITER)</label>
                                        <input class="form-control" placeholder="Quantity To Unit" name="qty_to_unit"
                                            type="number" min="0" required>
                                    </div>
                                </div>
                            </div>
                            <!-- End INPUT -->
                            <br>
                            <div class="row">
                                <div class="col">
                                    <a href="{{ route('fuel-unit.index') }}" class="btn btn-red btn-lg" role="button"
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

    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.bundle.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.pencarian').select2();
        });
    </script>
@endsection
