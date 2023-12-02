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
                        <form method="post" action="{{ route('fuel-suply.filter') }}">
                            @csrf
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label>Filter Suply Bulan</label>
                                    <input class="form-control filter" type="month" name="tanggal" id="filter-bulan">
                                </div>
                                    <div class="col-md-6 mb-3">
                                    <label for="">Cari Berdasarkan Storage</label>
                                    <select data-column="7" class="form-control form-select filter-select">
                                        <option value="">-- Pilih Storage --</option>
                                        @foreach ($storagesAll as $storage)
                                            <option value="{{ $storage->nama_storage }}">{{ $storage->nama_storage }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                @ho
                                    <div class="col-md-6 mb-3">
                                        <label for="">Cari Berdasarkan Lokasi</label>
                                        <select data-column="1" class="form-control form-select filter-select">
                                            <option value="">-- Pilih Lokasi --</option>
                                            @foreach ($locations as $location)
                                                <option value="{{ $location->nama_lokasi }}">{{ $location->nama_lokasi }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                @endho
                            </div>
                            <button type="submit" class="btn btn-primary">Filter</button>
                        </form>
                    </div>
                </div>
                <div class="card card-header-actions">
                    <div class="card-header">
                        <div>
                            Data Fuel Suply
                            <div class="small text-muted">
                                <span class="fw-500 text-primary">Bulan</span>
                                &middot; {{ now()->parse($date)->translatedFormat('F Y') ?? now()->translatedFormat('F Y') }} &middot;
                                {{ now()->translatedFormat('g:i a') }}
                            </div>
                        </div>
                        <div>
                            <a class="btn btn-outline-green float-right" href="{{ route('fuel-suply.create') }}"
                                role="button">
                                <i data-feather="plus-circle"></i> &nbsp; Tambah </a>
                            {{-- <!-- Print PDF --> --}}
                            <button type="button" class="btn btn-outline-warning float-right" data-bs-toggle="modal"
                                data-bs-target="#exportPdf">
                                <i data-feather="printer"></i> &nbsp; PDF
                            </button>
                            <!-- Print pdf -->
                            <div class="modal fade" id="exportPdf" tabindex="-1" role="dialog"
                                aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <form method="post" action="{{ route('fuel-suply.pdf') }}"
                                        enctype="multipart/form-data" target="_blank">
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
                            <button type="button" class="btn btn-outline-green float-right" data-bs-toggle="modal"
                                data-bs-target="#importExcel">
                                <i data-feather="external-link"></i>
                                &nbsp; Export Excel
                            </button>
                            <!-- Export Excel -->
                            <div class="modal fade" id="importExcel" tabindex="-1" role="dialog"
                                aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <form method="post" action="{{ route('fuel-suply.excel') }}" target="_blank"
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

                        <div class="mb-5">
                           
                        </div>

                        <div class="table-responsive table-responsive-xxl text-nowrap">
                            <table class="table table-bordered table-striped" id="simpleDatatables">
                                <thead>
                                    <tr>
                                        <th class="text-center">Tanggal</th>
                                        <th class="text-center">Lokasi</th>
                                        <th class="text-center">Pengiriman</th>
                                        <th class="text-center">Plat Nomor Kendaraan</th>
                                        <th class="text-center">No Surat Jalan</th>
                                        <th class="text-center">Driver</th>
                                        <th class="text-center">Penerima</th>
                                        <th class="text-center">Nama Storage</th>
                                        <th class="text-center">TC Storage Sebelum (CM)</th>
                                        <th class="text-center">TC Storage Sesudah (CM)</th>
                                        <th class="text-center">Kenaikan Storage Setelah Isi</th>
                                        <th class="text-center">Suhu Diterima (CELCIUS)</th>
                                        <th class="text-center">QTY By DO</th>
                                        <th class="text-center">DO Yang Datang</th>
                                        <th class="text-center">DO Minus / Lebih</th>
                                        <th class="text-center">Tindakan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($fuelSuplies as $suplier)
                                        <tr>
                                            <td>{{ now()->parse($suplier->tanggal)->translatedFormat('j F Y') }}
                                            </td>
                                            <td>{{ $suplier->nama_lokasi }}</td>
                                            <td>{{ $suplier->transporter }}</td>
                                            <td>{{ $suplier->no_plat_kendaraan }}</td>
                                            <td>{{ $suplier->no_surat_jalan }}</td>
                                            <td>{{ $suplier->driver }}</td>
                                            <td>{{ $suplier->penerima }}</td>
                                            <td>{{ $suplier->nama_storage }}</td>
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
                                                    <a class="btn btn-warning btn-sm" title="Edit"
                                                        href="{{ route('fuel-suply.edit', $suplier->id) }}">
                                                        <i data-feather="edit"></i>&nbsp;
                                                        Edit
                                                    </a>
                                                    @csrf
                                                    @method('DELETE')
                                                    <button class="btn btn-danger btn-sm" title="Hapus" type="submit"
                                                        onclick="return confirm('Yakin anda ingin menghapus data ini?')">
                                                        <i data-feather="trash-2"></i>&nbsp;
                                                        Hapus
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                    {{-- @foreach ($supliers as $suplier)
                                        
                                    @endforeach --}}
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th colspan="12">Total</th>
                                        <th>QTY By DO: {{ $totalByDo[0]->totalByDo }} Liter</th>
                                        <th>DO Datang: {{ $totalDoDatang[0]->totalDoDatang }} Liter</th>
                                        <th colspan="2">Do Minus: {{ $totalDoM[0]->totalDoM }} Liter</th>
                                    </tr>
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
        $(document).ready(function() {
            let table = $('#simpleDatatables').DataTable({
                "pageLength": 50,
                order: [
                    [0, 'asc']
                ],
                rowsGroup: [0]
            });

            $('.filter-input').keyup(function() {
                table.column($(this).data('column'))
                    .search($(this).val())
                    .draw();
            });

            $('.filter-select').change(function() {
                table.column($(this).data('column'))
                    .search($(this).val())
                    .draw();
            });

        })
    </script>
@endsection
