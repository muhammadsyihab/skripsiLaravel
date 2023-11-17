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
                <div class="card card-header-actions">
                    <div class="card-header">
                        <div>
                            @if (\Route::current()->getName() == 'oli.index')
                                Daftar Oli
                            @else
                                Daftar Sparepart
                            @endif
                            <div class="small text-muted">
                                <span class="fw-500 text-primary">{{ now()->translatedFormat('l') }}</span>
                                &middot; {{ now()->translatedFormat('F j, Y') }} &middot; {{ now()->translatedFormat('g:i a') }}
                            </div>
                        </div>
                        <div>
                            

                            @if (\Route::current()->getName() == 'oli.index')
                                <a class="btn btn-outline-success float-right" href="{{ route('oli.create') }}"
                                    role="button">
                                    <i data-feather="plus-circle"></i> &nbsp Tambah </a>
                                <a href="{{ route('sparepart.oli.pdf') }}" class="btn btn-outline-warning float-right"
                                    target="_blank">
                                    <i data-feather="printer"></i> &nbsp; PDF
                                </a>
                                @ho
                                <a href="{{ route('sparepart.oli.excel') }}" class="btn btn-outline-green float-right">
                                    <i data-feather="external-link"></i>
                                    &nbsp; Export Excel
                                </a>
                                @endho
                            @else
                                <a class="btn btn-outline-success float-right" href="{{ route('sparepart.create') }}"
                                role="button">
                                <i data-feather="plus-circle"></i> &nbsp Tambah </a>

                                <a href="{{ route('sparepart.pdf') }}" class="btn btn-outline-warning float-right"
                                    target="_blank">
                                    <i data-feather="printer"></i> &nbsp; PDF
                                </a>
                                @ho
                                <a href="{{ route('sparepart.excel') }}" class="btn btn-outline-green float-right">
                                    <i data-feather="external-link"></i>
                                    &nbsp; Export Excel
                                </a>
                                @endho
                               
                            @endif

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
                            <table class="table table-bordered table-bordered" id="datatablesSimple">
                                <thead>
                                    <tr>
                                        <th class="text-center">Part Number</th>
                                        <th class="text-center">Description</th>
                                        <th class="text-center">QTY</th>
                                        <th class="text-center">UOM</th>
                                        <th class="text-center">Item Price</th>
                                        <th class="text-center">Amount</th>
                                        <th class="text-center">Tindakan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($spareparts as $sp)
                                        <tr>
                                            <td>{{ $sp->part_number }}</td>
                                            <td>{{ $sp->nama_item }}</td>
                                            <td>{{ $sp->qty }}</td>
                                            <td>{{ $sp->uom }}</td>
                                            @if ($sp->item_price == null)
                                                <td>Price Belum di Update</td>
                                                <td>Price Belum di Update</td>
                                            @else
                                                <td>@currency($sp->item_price)</td>
                                                <td>@currency($sp->item_price * $sp->qty)</td>
                                            @endif
                                            <td class="text-center">
                                                <form method="post" action="{{ route('sparepart.destroy', $sp->id) }}">
                                                    @csrf
                                                    @if (\Route::current()->getName() == 'oli.index')
                                                        <a class="btn btn-warning btn-sm" title="Edit"
                                                        href="{{ route('oli.edit', $sp->id) }}">
                                                            <i data-feather="edit"></i>&nbsp; Edit
                                                        </a>
                                                    @else
                                                        <a class="btn btn-warning btn-sm" title="Edit"
                                                        href="{{ route('sparepart.edit', $sp->id) }}">
                                                            <i data-feather="edit"></i>&nbsp; Edit
                                                        </a>
                                                    @endif
                                                    @csrf
                                                    {{-- @method('DELETE')
                                                    <button class="btn btn-danger btn-sm" title="Delete" type="submit"
                                                        title="Hapus"
                                                        onclick="return confirm('Apakah anda yakin ingin menghapus data ini?')">
                                                        <i data-feather="trash-2"></i>&nbsp; Hapus
                                                    </button> --}}
                                                </form>

                                            </td>
                                        </tr>
                                    @endforeach
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
    <script>
        $('#datatablesSimple').DataTable();
    </script>
@endsection
