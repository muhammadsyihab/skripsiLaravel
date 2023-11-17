@extends('layouts.template')

@section('content')
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
                <div class="card card-header-actions">
                    <div class="card-header">
                        Data Table
                        <div>
                            <a class="btn btn-outline-green float-right" href="{{ route('oli-masuk.create') }}" role="button">
                                <i data-feather="plus-circle"></i> &nbsp ADD </a>
                            <!-- Print PDF -->
                            <a class="btn btn-outline-yellow float-right" href="#" role="button" target="_blank">
                                <i data-feather="printer"></i> &nbsp PDF </a>
                        </div>
                    </div>
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


                        <form method="post" action="{{ route('fuel-suply.filter') }}">
                            @csrf
                            <div class="row mb-5">
                                <div class="col-md-6">
                                    <label>Filter Suply Bulan</label>
                                    <input class="form-control filter" type="month" name="tanggal" id="filter-bulan">
                                </div>
                                <div class="col-md-2">
                                    <button type="submit" class="btn btn-primary">Filter</button>
                                </div>
                            </div>
                        </form>
                        <div class="table-responsive-xxl text-nowrap">
                            <table class="table table-striped" id="datatablesSimple">
                                <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>QTY Masuk</th>
                                        <th>Status</th>
                                        <th>Purchasing Order</th>
                                        <th>Notes</th>
                                        <th>Vendor</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                {{-- <tfoot>
                                    <tr>
                                        <th>Date</th>
                                        <th>Storage</th>
                                        <th>Transporter</th>
                                        <th>Plat Nomor Kendaraan</th>
                                        <th>NO Surat Jalan</th>
                                        <th>Driver</th>
                                        <th>Penerima</th>
                                        <th>Nama Storage</th>
                                        <th>TC Storage Sebelum (CM)</th>
                                        <th>TC Storage Sesudah (CM)</th>
                                        <th>Kenaikan Storage Setelah Isi (CM)</th>
                                        <th>Suhu Diterima (CELCIUS)</th>
                                        <th>QTY By DO</th>
                                        <th>DO Yang Datang</th>
                                        <th>DO Minus</th>
                                        <th class="text-end">Action</th>
                                    </tr>
                                </tfoot> --}}
                                <tbody>
                                    @foreach ($stocks as $stock)
                                        @foreach ($stock->oliSuplies as $suplier)
                                            <tr>
                                                <td>{{ now()->parse($suplier->oliStock->tanggal)->format('j F Y') }}</td>
                                                <td>{{ $suplier->qty_masuk }}</td>
                                                <td>{{ $suplier->status }}</td>
                                                <td>{{ $suplier->purchasing_order }}</td>
                                                <td>{{ $suplier->notes }}</td>
                                                <td>{{ $suplier->vendor }}</td>
                                                <td class="text-end">
                                                    <form method="post"
                                                        action="{{ route('oli-masuk.destroy', $suplier->id) }}">
                                                        @csrf
                                                        <a class="btn btn-success btn-sm" title="Edit"
                                                            href="{{ route('oli-masuk.edit', $suplier->id) }}">
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
                                            {{-- <tr>
                                            <td>{{ now()->parse($suplier->fuelStock->tanggal)->format('j F Y') }}</td>
                                            <td>{{ $suplier->fuelStock->storage->nama_storage }} ({{  $suplier->fuelStock->storage->lokasi->nama_lokasi }})</td>
                                            <td>{{ $suplier->transporter }}</td>
                                            <td>{{ $suplier->no_plat_kendaraan }}</td>
                                            <td>{{ $suplier->no_surat_jalan }}</td>
                                            <td>{{ $suplier->driver }}</td>
                                            <td>{{ $suplier->penerima }}</td>
                                            <td>{{ $suplier->fuelStock->storage->nama_storage }}</td>
                                            <td>{{ $suplier->tc_storage_sebelum }} CM</td>
                                            <td>{{ $suplier->tc_storage_sesudah }} CM</td>
                                            <td>{{ $suplier->tc_kenaikan_storage }} CM</td>
                                            <td>{{ $suplier->suhu_diterima }} CELCIUS</td>
                                            <td>{{ $suplier->qty_by_do }} Liter</td>
                                            <td>{{ $suplier->do_datang }} Liter</td>
                                            <td>{{ $suplier->do_minus }} Liter</td>
                                            <td class="text-end">
                                                <form method="post"
                                                    action="{{ route('fuel-suply.destroy', $suplier->id) }}">
                                                    @csrf
                                                    <a class="btn btn-success btn-sm" title="Edit"
                                                        href="{{ route('fuel-suply.edit', $suplier->id) }}">
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
                                        </tr> --}}
                                        @endforeach
                                    @endforeach
                                    {{-- @foreach ($supliers as $suplier)
                                        
                                    @endforeach --}}
                                </tbody>
                            </table>
                        </div>
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
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest" type="text/javascript"></script>
@endsection
