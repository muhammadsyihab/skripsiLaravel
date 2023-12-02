@extends('layouts.template')

@section('content')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css">
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>


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
                    @foreach($storages as $storage)
                    <div class="card mb-3">
                        <div class="card-header">Data Stock {{ $storage->nama_storage }}</div>
                        <div class="card-body">
                            @if (session()->has('success'))
                                <div class="alert alert-primary" role="alert">
                                    {{ session('success') }}
                                </div>
                            @endif
                            @if (session()->has('danger'))
                                <div class="alert alert-danger" role="alert">
                                    {{ session('danger') }}
                                </div>
                            @endif
                            <a class="btn btn-outline-green float-right" href="{{ route('fuel-stock.create') }}" role="button">
                                <i data-feather="plus-circle"></i> &nbsp ADD </a>
                            <a href="{{ route('fuel-stock.index') }}" class="btn btn-outline-danger">Kembali</a>
                            <!-- Print PDF -->
                            <!-- <a class="btn btn-outline-yellow float-right" href="#" role="button" target="_blank">
                                            <i data-feather="printer"></i> &nbsp PDF </a> -->
                            <div class="table-responsive-xxl text-nowrap mt-2">
                                <table class="table table-striped display" id="">
                                    <thead>
                                        <tr>
                                            <th rowspan="2">Date</th>
                                            <th rowspan="2">Lokasi Storage</th>
                                            <th rowspan="2">Nama Storage</th>
                                            <th rowspan="2">Stock Open</th>
                                            <th rowspan="2">Fuel Stock In</th>
                                            <th colspan="2">Fuel Out</th>
                                            <th rowspan="2">Fuel Out Total</th>
                                            <th rowspan="2">Stock</th>
                                            <th rowspan="2">Action</th>
                                        </tr>
                                        <tr>
                                            <th>Day</th>
                                            <th>Night</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($storage->stocks as $stock)
                                            <tr>
                                                <td>{{ now()->parse($stock->tanggal)->format('j F Y') }}</td>
                                                <td>{{ $stock->storage->lokasi->nama_lokasi }}</td>
                                                <td>{{ $stock->storage->nama_storage }}</td>
                                                <td>{{ $stock->stock_open_total }}</td>
                                                <td>{{ $stock->fuelSuplies->sum('do_datang') }}</td>
                                                <td>{{ $stock->qty_to_unit_day }}</td>
                                                <td>{{ $stock->qty_to_unit_night }}</td>
                                                <td>{{ $stock->fuelOuts->sum('qty_to_unit') }}</td>
                                                <td>{{ $stock->stock }}</td>
                                                <td>
                                                    <form method="post"
                                                        action="{{ route('fuel-stock.destroy', $stock->id) }}">
                                                        @csrf
                                                        <a class="btn btn-success btn-sm" title="Edit"
                                                            href="{{ route('fuel-stock.edit', $stock->id) }}">
                                                            <i data-feather="edit"></i>&nbsp;
                                                            Edit
                                                        </a>
                                                        @csrf
                                                        @method('DELETE')
                                                        <button class="btn btn-danger btn-sm" title="Delete" type="submit"
                                                            title="Delete">
                                                            <i data-feather="trash"></i>&nbsp;
                                                            Delete
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    @endforeach
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
            $('table.display').DataTable({
                "responsive": true,
            });
        });
    </script>
@endsection
