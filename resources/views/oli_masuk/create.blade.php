@extends('layouts.template')

@section('content')
    <div id="layoutSidenav_content">
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    {{ $errors }}
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
                    <div class="card-header">Silahkan Isi Tabel Berikut!</div>
                    <div class="card-body">
                        <form method="post" action="{{ route('oli-masuk.store') }}" enctype="multipart/form-data">
                            @csrf
                            <!-- INPUT -->
                            <div class="row">
                                <div class="col">
                                    <div class="mb-3">
                                        <label for="oli_stock_id">Date Stock</label>
                                        <select name="oli_stock_id" id="oli_stock_id"
                                            class="form-control form-control-solid pencarian">
                                            <option value="" selected disabled>-- Date Stock --</option>
                                            @foreach ($stocks as $stock)
                                                <option value="{{ $stock->id }}">
                                                    {{ now()->parse($stock->tanggal)->format('j F Y') }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <div class="mb-3">
                                        <label for="qty_masuk">QTY Masuk</label>
                                        <input class="form-control" placeholder="QTY Masuk" name="qty_masuk"
                                            type="number">
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="mb-3">
                                        <label for="status">Status</label>
                                        <input class="form-control" placeholder="Status"
                                            name="status" type="text">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <div class="mb-3">
                                        <label for="purchasing_order">Purchasing Order</label>
                                        <input class="form-control" placeholder="Purchasing Order" name="purchasing_order"
                                            type="text">
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="mb-3">
                                        <label for="vendor">Vendor</label>
                                        <input class="form-control" placeholder="Vendor" name="vendor" type="text">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="mb-3">
                                    <label for="notes" class="form-label">Notes</label>
                                    <textarea class="form-control" id="notes" rows="3" name="notes"></textarea>
                                  </div>
                            </div>
                            <!-- End INPUT -->
                            <br>
                            <div class="row">
                                <div class="col">
                                    <a href="{{ route('oli-masuk.index') }}" class="btn btn-red btn-lg" role="button"
                                        aria-pressed="true">Back</a>

                                    <!-- Button trigger modal -->
                                    <button class="btn btn-lg btn-teal" type="button" data-bs-toggle="modal"
                                        data-bs-target="#exampleModalCenter">Submit</button>

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
                                                    Anda bisa melihat data anda di tables.
                                                    Data bisa diedit di menu edit yang tertampil di tables.
                                                    Adapun untuk menghapus terdapat di Tables.
                                                </div>
                                                <div class="modal-footer"><button class="btn btn-secondary"
                                                        type="button" data-bs-dismiss="modal">Close</button>
                                                    <button class="btn btn-primary" type="submit">Save changes</button>
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
@endsection
