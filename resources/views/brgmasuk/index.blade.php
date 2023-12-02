@extends('layouts.template')

@section('content')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css">


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
                        <form action="{{ route('brgmasuk.filter') }}" method="POST">
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
                            Daftar Barang Masuk
                            <div class="small text-muted">
                                <span class="fw-500 text-primary">Bulan</span>
                                &middot;
                                {{ now()->parse($date)->translatedFormat('F Y') ?? now()->translatedFormat('F Y') }}
                                &middot;
                                {{ now()->translatedFormat('g:i a') }}
                            </div>
                        </div>
                        <div class="small">
                            <a class="btn btn-outline-green float-right" href="{{ route('brgmasuk.create') }}"
                                role="button">
                                <i data-feather="plus-circle"></i> &nbsp Tambah </a>

                            {{-- <!-- Print PDF --> --}}
                            <button type="button" class="btn btn-outline-warning float-right" data-bs-toggle="modal"
                                data-bs-target="#exportPdf">
                                <i data-feather="printer"></i> &nbsp; PDF
                            </button>
                            <!-- Print pdf -->
                            <div class="modal fade" id="exportPdf" tabindex="-1" role="dialog"
                                aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <form method="post" action="{{ route('brgmasuk.pdf') }}" enctype="multipart/form-data"
                                        target="_blank">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Export PDF</h5>
                                            </div>
                                            <div class="modal-body">

                                                @csrf
                                                <div class="row mb-3">
                                                    <div class="">
                                                        <label for="date">Pilih data bulan</label>
                                                        <input type="month" class="form-control" name="date">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-bs-dismiss="modal">Close</button>
                                                <button type="submit" class="btn btn-warning">Buat PDF</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>

                            {{-- Export excel --}}
                            @ho
                                {{--  <button type="button" class="btn btn-outline-green float-right" data-bs-toggle="modal"
                                data-bs-target="#importExcel">
                                <i data-feather="external-link"></i>
                                &nbsp; Export Excel
                            </button>  --}}
                            @endho
                            <!-- Export Excel -->
                            <div class="modal fade" id="importExcel" tabindex="-1" role="dialog"
                                aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <form method="post" action="{{ route('brgmasuk.excel') }}" target="_blank"
                                        enctype="multipart/form-data">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Export Excel</h5>
                                            </div>
                                            <div class="modal-body">
                                                @csrf
                                                <div class="row mb-3">
                                                    <div class="">
                                                        <label for="date">Pilih data bulan</label>
                                                        <input type="month" class="form-control" name="date">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-bs-dismiss="modal">Close</button>
                                                <button type="submit" class="btn btn-primary">Export</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
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

                        <div class="table-responsive table-responsive-xxl text-nowrap mb-3">
                            <table class="table table-bordered table-striped" id="datatablesSimple">
                                <thead>
                                    <tr>
                                        <th class="text-center">Tanggal</th>
                                        <th class="text-center">Deskripsi</th>
                                        <th class="text-center">Nomor Part</th>
                                        <th class="text-center">QTY</th>
                                        <th class="text-center">Harga Satuan (RP)</th>
                                        <th class="text-center">Total (RP)</th>
                                        <th class="text-center">Suplier</th>
                                        <th class="text-center">Nomer PO</th>
                                        <th class="text-center">Penerima</th>
                                        <th class="text-center">Status</th>
                                        <th class="text-center">Tindakan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($brgmasuk as $brg)
                                        <tr>
                                            <td>{{ now()->parse($brg->tanggal_masuk)->translatedFormat('j F Y') }}</td>
                                            <td>{{ $brg->sparepart->nama_item }}</td>
                                            <td>{{ $brg->sparepart->part_number }}</td>
                                            <td>{{ $brg->qty_masuk }} {{ $brg->sparepart->uom }}</td>
                                            <td>@currency($brg->item_price)</td>
                                            <td>@currency($brg->amount)</td>
                                            <td>{{ $brg->vendor }}</td>
                                            <td>{{ $brg->nomor_po ?? '-' }}</td>
                                            <td>{{ $brg->penerima ?? '-' }}</td>
                                            @if ($brg->status === 0)
                                                <td><span class="badge bg-success">Diterima</span></td>
                                            @else
                                                <td><span class="badge bg-warning">Pre Order</span></td>
                                            @endif
                                            <td class="text-end">
                                                <form method="post" action="{{ route('brgmasuk.destroy', $brg->id) }}">
                                                    @csrf
                                                    <a class="btn btn-warning btn-sm" title="Edit"
                                                        href="{{ route('brgmasuk.edit', $brg->id) }}">
                                                        <i data-feather="edit"></i>&nbsp;
                                                        Edit
                                                    </a>
                                                    @csrf
                                                    @method('DELETE')
                                                    <button class="btn btn-danger btn-sm" title="Hapus" type="submit"
                                                        onclick="return confirm('Apakah anda yakin ingin menghapus data ini?')">
                                                        <i data-feather="trash-2"></i>&nbsp;
                                                        Hapus
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <th colspan="5">Grand Total</th>
                                    <th colspan="4">@currency($total)</th>
                                </tfoot>
                            </table>
                        </div>
                        {{--  <p class="mb-3">Pengeluaran pada bulan {{ Carbon::parse($brgmasuk[0]->tanggal_masuk)->translatedFormat('F Y') }}</p>
                        <div class="table-responsive-xl text-nowrap">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Nomor</th>
                                        <th>Nama Item</th>
                                        <th>Total Harga</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($total as $tot)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $tot->sparepart->nama_item }}</td>
                                            <td>Rp.{{ $tot->total }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>  --}}
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
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
    <script>
        // $('#datatablesSimple').DataTable();

        $(document).ready(function() {
            $('#datatablesSimple').DataTable();
        });
    </script>
@endsection
