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
                        <form action="{{ route('brgkeluar.filter') }}" method="POST">
                            @csrf
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="bulan">Bulan</label>
                                    <input type="month" name="bulan" id="bulan" class="form-control"
                                        value="{{ old('bulan') }}" required>
                                    @error('bulan')
                                        <div class="text-danger">Tolong isi dengan benar</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="master_lokasi_id">PIT</label>
                                    <select class="form-control form-control-solid" id="master_lokasi_id"
                                        name="master_lokasi_id" required>
                                        <option value="" selected disabled>Lokasi</option>
                                        @foreach ($lokasi as $lk)
                                            <option
                                                value="{{ $lk->id }}"{{ old('master_lokasi_id') == $lk->id ? ' selected' : '' }}>
                                                {{ $lk->nama_lokasi }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('master_lokasi_id')
                                        <div class="text-danger">Tolong isi dengan benar</div>
                                    @enderror
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary">Cari</button>
                        </form>
                    </div>
                </div>
                <div class="card card-header-actions">
                    <div class="card-header">
                        <div>
                            Daftar Barang Keluar {{ $pit }}
                            <div class="small text-muted">
                                <span class="fw-500 text-primary">{{ now()->translatedFormat('l') }}</span>
                                &middot; {{ now()->translatedFormat('F j, Y') }} &middot; {{ now()->translatedFormat('g:i a') }}
                            </div>
                        </div>
                        <div>
                            {{-- <a class="btn btn-outline-green float-right" href="{{ route('brgkeluar.create') }}"
                                role="button">
                                <i data-feather="plus-circle"></i> &nbsp Tambah </a> --}}

                            {{-- <!-- Print PDF --> --}}
                            <button type="button" class="btn btn-outline-warning float-right" data-bs-toggle="modal"
                                data-bs-target="#exportPdf">
                                <i data-feather="printer"></i> &nbsp; PDF
                            </button>
                            <!-- Print pdf -->
                            <div class="modal fade" id="exportPdf" tabindex="-1" role="dialog"
                                aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <form method="post" action="{{ route('brgkeluar.pdf') }}" enctype="multipart/form-data"
                                        target="_blank">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Export PDF</h5>
                                            </div>
                                            <div class="modal-body">

                                                @csrf
                                                <div class="row mb-3">
                                                    <div class="col-md-6">
                                                        <label for="bulan">Bulan</label>
                                                        <input type="month" name="bulan" id="bulan"
                                                            class="form-control" value="{{ old('bulan') }}" required>
                                                        @error('bulan')
                                                            <div class="text-danger">Tolong isi dengan benar</div>
                                                        @enderror
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label for="master_lokasi_id">PIT</label>
                                                        <select class="form-control form-control-solid"
                                                            id="master_lokasi_id" name="master_lokasi_id" required>
                                                            <option value="" selected disabled>Lokasi</option>
                                                            @foreach ($lokasi as $lk)
                                                                <option
                                                                    value="{{ $lk->id }}"{{ old('master_lokasi_id') == $lk->id ? ' selected' : '' }}>
                                                                    {{ $lk->nama_lokasi }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                        @error('master_lokasi_id')
                                                            <div class="text-danger">Tolong isi dengan benar</div>
                                                        @enderror
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
                            <button type="button" class="btn btn-outline-green float-right" data-bs-toggle="modal"
                                data-bs-target="#importExcel">
                                <i data-feather="external-link"></i>
                                &nbsp; Export Excel
                            </button>
                            @endho
                            <!-- Export Excel -->
                            <div class="modal fade" id="importExcel" tabindex="-1" role="dialog"
                                aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <form method="post" action="{{ route('brgkeluar.excel') }}"
                                        enctype="multipart/form-data" target="_blank">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Export Excel</h5>
                                            </div>
                                            <div class="modal-body">

                                                @csrf
                                                <div class="row mb-3">
                                                    <div class="col-md-6">
                                                        <label for="bulan">Bulan</label>
                                                        <input type="month" name="bulan" id="bulan"
                                                            class="form-control" value="{{ old('bulan') }}" required>
                                                        @error('bulan')
                                                            <div class="text-danger">Tolong isi dengan benar</div>
                                                        @enderror
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label for="master_lokasi_id">PIT</label>
                                                        <select class="form-control form-control-solid"
                                                            id="master_lokasi_id" name="master_lokasi_id" required>
                                                            <option value="" selected disabled>Lokasi</option>
                                                            @foreach ($lokasi as $lk)
                                                                <option
                                                                    value="{{ $lk->id }}"{{ old('master_lokasi_id') == $lk->id ? ' selected' : '' }}>
                                                                    {{ $lk->nama_lokasi }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                        @error('master_lokasi_id')
                                                            <div class="text-danger">Tolong isi dengan benar</div>
                                                        @enderror
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
                                        <th class="text-center">Tanggal</th>
                                        <th class="text-center">Area</th>
                                        <th class="text-center">Kode Unit</th>
                                        <th class="text-center">Nomor Part</th>
                                        <th class="text-center">Deskripsi</th>
                                        <th class="text-center">Penerima</th>
                                        <th class="text-center">QTY</th>
                                        <th class="text-center">UOM</th>
                                        <th class="text-center">Harga Satuan (RP)</th>
                                        <th class="text-center">Total (RP)</th>
                                        <th class="text-center">Remarks / Request By</th>
                                        <th class="text-center">Status</th>
                                        {{-- <th class="text-center">Foto</th> --}}
                                        {{-- <th class="text-center">Tindakan</th> --}}
                                    </tr>
                                </thead>
                                <tbody>

                                    @foreach ($brgkeluar as $bk)
                                        <tr>
                                            <td>{{ now()->parse($bk->tanggal_keluar)->translatedFormat('j F Y') }}</td>
                                            <td>{{ $bk->lokasi->nama_lokasi }}</td>
                                            <td>{{ $bk->unit->no_lambung }}</td>
                                            <td>{{ $bk->sparepart->part_number }}</td>
                                            <td>{{ $bk->sparepart->nama_item }}</td>
                                            <td>{{ $bk->penerima }}</td>
                                            <td>{{ $bk->qty_keluar }}</td>
                                            <td> {{ $bk->sparepart->uom }}</td>
                                            <td>@currency($bk->sparepart->item_price)</td>
                                            <td>@currency($bk->amount)</td>
                                            <td>{{ $bk->users->name }}</td>
                                            @if ($bk->status == 0)
                                                <td><span class="badge bg-warning">Diminta</span></td>
                                            @elseif($bk->status == 1)
                                                <td><span class="badge bg-success">Acc</span></td>
                                            @elseif($bk->status == 2 || $bk->status == 4)
                                                <td><span class="badge bg-danger">Ditolak<span></td>
                                            @endif
                                            {{-- @if (empty($bk->sparepart->photo))
                                                <td class="text-center"><img
                                                        src="{{ asset('storage/camera_default.png') }}" height="60"
                                                        width="60" alt=""></td>
                                            @else
                                                <td><img src="{{ asset('storage/spKeluar/' . $bk->sparepart->photo) }}"
                                                        height="50"width="50" alt=""></td>
                                            @endif --}}
                                            {{-- <td class="align-middle">
                                                <form method="post" action="{{ route('brgkeluar.destroy', $bk->id) }}">
                                                    @csrf
                                                    <a class="btn btn-warning btn-sm" title="Edit"
                                                        href="{{ route('brgkeluar.edit', $bk->id) }}">
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
                                            </td> --}}
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <th colspan="9">Grand Total</th>
                                    <th colspan="3">@currency($total)</th>
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
