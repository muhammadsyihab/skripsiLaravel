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
                <div class="card mb-3">
                    <div class="card-header">
                        Filter
                    </div>
                    <div class="card-body">
                        <form action="{{ route('purchasing.order.filter') }}" method="POST">
                            @csrf
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="bulan">Bulan</label>
                                    <input type="month" name="bulan" id="bulan" class="form-control">
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary">Cari</button>
                        </form>
                    </div>
                </div>
                <div class="card card-header-actions">
                    <div class="card-header">
                        <div>
                            Daftar Barang Purchasing Order Yang Dibatalkan
                            <div class="small text-muted">
                                <span class="fw-500 text-primary">{{ now()->translatedFormat('l') }}</span>
                                &middot; {{ now()->translatedFormat('F j, Y') }} &middot; {{ now()->translatedFormat('g:i a') }}
                            </div>
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
                        <div class="table-responsive table-responsive-xxl text-nowrap">
                            <table class="table table-bordered table-striped" id="datatablesSimple">
                                <thead>
                                    <tr>
                                        <th class="text-center">Nomer PO</th>
                                        <th class="text-center">Nama Penerima</th>
                                        <th class="text-center">Tanggal</th>
                                        <th class="text-center">Deskripsi</th>
                                        <th class="text-center">Nomor Part</th>
                                        <th class="text-center">QTY</th>
                                        <th class="text-center">Harga Satuan (RP)</th>
                                        <th class="text-center">Total (RP)</th>
                                        <th class="text-center">Suplier</th>
                                        <th class="text-center">Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($brgmasuk as $brg)
                                        <tr>
                                            <td>{{ $brg->nomor_po ?? "-" }}</td>
                                            <td>{{ $brg->penerima ?? "-" }}</td>
                                            <td>{{ now()->parse($brg->tanggal_masuk)->translatedFormat('j F Y') }}</td>
                                            <td>{{ $brg->sparepart->nama_item }}</td>
                                            <td>{{ $brg->sparepart->part_number }}</td>
                                            <td>{{ $brg->qty_masuk }} {{ $brg->sparepart->uom }}</td>

                                            <td>@currency($brg->item_price)</td>
                                            <td>@currency($brg->amount)</td>
                                            <td>{{ $brg->vendor }}</td>
                                            <td><span class="badge bg-danger">Dibatalkan Sistem</span></td>
                                        </tr>
                                    @endforeach

                                </tbody>
                                <tfoot>
                                    <th colspan="6">Grand Total</th>
                                    <th colspan="4">@currency($total)</th>
                                </tfoot>
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
    <script>
        $('#datatablesSimple').DataTable();
    </script>
@endsection
