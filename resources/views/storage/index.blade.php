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
                            Daftar Storage
                            <div class="small text-muted">
                                <span class="fw-500 text-primary">{{ now()->translatedFormat('l') }}</span>
                                &middot; {{ now()->translatedFormat('F j, Y') }} &middot; {{ now()->translatedFormat('g:i a') }}
                            </div>
                        </div>
                        <a class="btn btn-outline-green float-right" href="{{ route('storage.create') }}" role="button">
                            <i data-feather="plus-circle"></i> &nbsp Tambah </a>
                        <!-- Print PDF -->
                        <!-- <a class="btn btn-outline-yellow float-right" href="#" role="button" target="_blank"><i data-feather="printer"></i> &nbsp PDF </a> -->
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
                                        <th class="text-center">Area</th>
                                        <th class="text-center">Nama Storage</th>
                                        <th class="text-center">Kapasitas</th>
                                        <th class="text-center">Tindakan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($storages as $storage)
                                        <tr>
                                            <td>{{ $storage->lokasi->nama_lokasi }}</td>
                                            <td>{{ $storage->nama_storage }}</td>
                                            <td>{{ $storage->kapasitas }} CM</td>
                                            <td>
                                                <form method="post" action="{{ route('storage.destroy', $storage->id) }}">
                                                    @csrf
                                                    <a class="btn btn-warning btn-sm " title="Edit"
                                                        href="{{ route('storage.edit', $storage->id) }}"><i
                                                            data-feather="edit"></i> &nbsp; Edit</a>
                                                    @csrf
                                                    {{-- @method('DELETE')
                                                    <button class="btn btn-danger btn-sm " title="Hapus" type="submit"
                                                        onclick="return confirm('Apakah anda yakin ingin menghapus data ini?')"><i
                                                            data-feather="trash-2"></i> &nbsp; Hapus</button> --}}
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
