@extends('layouts.template')

@section('content')
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
                    <div class="card-header">Silahkan Edit Field Berikut!</div>
                    <div class="card-body">
                        @if (session()->has('danger'))
                            <div class="alert alert-danger" role="alert">
                                {{ session('danger') }}
                            </div>
                        @endif
                        <form action="{{ route('fuel-unit.update', $fuelUnitById->id) }}" method="post"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PATCH')
                            <!-- INPUT -->
                            <div class="row">
                                <div class="col">
                                    <div class="mb-3">
                                        <label for="fuel_to_stock_id">Date Stock</label>
                                        <select name="fuel_to_stock_id" id="fuel_to_stock_id"
                                            class="form-control form-control-solid pencarian">
                                            <option value="" selected disabled>-- Date Stock --</option>
                                            @foreach ($stocks as $stock)
                                                <option
                                                    value="{{ $stock->id }}"{{ $stock->id === $fuelUnitById->fuel_to_stock_id ? ' selected' : '' }}>
                                                    {{ now()->parse($stock->tanggal)->format('j F Y') }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="mb-3">
                                        <label for="daily_unit_id">Date Daily Unit</label>
                                        <select name="daily_unit_id" id="daily_unit_id"
                                            class="form-control form-control-solid pencarian">
                                            <option value="" selected disabled>-- Date Daily Unit --</option>
                                            @foreach ($dailys as $daily)
                                                <option
                                                    value="{{ $daily->tanggal }}"{{ $daily->tanggal === $dailyFuel->tanggal ? ' selected' : '' }}>
                                                    {{ now()->parse($daily->tanggal)->format('j F Y') }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <div class="mb-3">
                                        <label for="qty_to_unit">Quantity To Unit</label>
                                        <input class="form-control" placeholder="Quantity To Unit" name="qty_to_unit"
                                            type="number" value="{{ $fuelUnitById->qty_to_unit }}">
                                    </div>
                                </div>
                            </div>
                            <!-- End INPUT -->
                            <br>
                            <div class="row">
                                <div class="col">
                                    <a href="{{ route('fuel-unit.index') }}" class="btn btn-red btn-lg" role="button"
                                        aria-pressed="true">Back</a>
                                    <button class="btn btn-lg btn-teal" type="button" data-bs-toggle="modal"
                                        data-bs-target="#exampleModalCenter">Submit</button>

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
                                                    Data ini akan update.
                                                    Isi dengan benar untuk Filed yang tersedia!
                                                </div>
                                                <div class="modal-footer"><button class="btn btn-secondary" type="button"
                                                        data-bs-dismiss="modal">Close</button>
                                                    <button class="btn btn-primary" type="submit">Update</button>
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
