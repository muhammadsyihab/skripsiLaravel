@extends('layouts.template')

@section('content')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css">

    <div id="layoutSidenav_content">
        @if ($errors->any())
            <div class="alert alert-danger">
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
                        {{-- <div class="row align-items-center justify-content-between">
                                    <div class="col-auto mt-4">
                                        <h1 class="page-header-title">
                                            <div class="page-header-icon"><i data-feather="database"></i></div>
                                            Blackbox Create
                                        </h1>
                                        <div class="page-header-subtitle">Add your Data!</div>
                                    </div>

                                </div> --}}
                    </div>
                </div>
            </header>
            <!-- Main page content-->
            <div class="container-xl px-4 mt-n10">
                <div class="card">
                    <div class="card-header">Tambah Data Pengguna</div>
                    <div class="card-body">
                        <form method="post" action="{{ route('user.store') }}" enctype="multipart/form-data">
                            @csrf
                            <div class="row mb-3">
                                <label for="name"
                                    class="col-md-4 col-form-label text-md-end">{{ __('Nama') }}</label>

                                <div class="col-md-6">
                                    <input id="name" type="text"
                                        class="form-control @error('name') is-invalid @enderror" name="name"
                                        value="{{ old('name') }}" required autocomplete="name" autofocus
                                        placeholder="nama anda">

                                    @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="jabatan"
                                    class="col-md-4 col-form-label text-md-end">{{ __('Jabatan') }}</label>

                                <div class="col-md-6">
                                    <input id="jabatan" type="text"
                                        class="form-control @error('jabatan') is-invalid @enderror" name="jabatan" required
                                        autocomplete="new-jabatan" placeholder="Jabatan sekarang">

                                    @error('jabatan')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="role"
                                    class="col-md-4 col-form-label text-md-end">{{ __('Role User') }}</label>

                                <div class="col-md-6">
                                    <select id="role" type="text"
                                        class="form-control @error('role') is-invalid @enderror" name="role" required
                                        autocomplete="role">
                                        <option selected disabled>-- Role --</option>
                                        @ho
                                        <option value="0">Head Office</option>
                                        @endho
                                        <option value="1">Planner</option>
                                        <option value="2">Logistik</option>
                                        <option value="3">Mekanik</option>
                                        <option value="4">Operator</option>
                                        <option value="5">Production</option>
                                    </select>
                                    @error('role')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="no_telp"
                                    class="col-md-4 col-form-label text-md-end">{{ __('No Telepon') }}</label>

                                <div class="col-md-6">
                                    <input id="no_telp" type="number" min="0"
                                        class="form-control @error('no_telp') is-invalid @enderror" name="no_telp" required
                                        autocomplete="new-no_telp" placeholder="62813****">

                                    @error('no_telp')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="jenis_kelamin"
                                    class="col-md-4 col-form-label text-md-end">{{ __('Jenis Kelamin') }}</label>

                                <div class="col-md-6">
                                    <select id="jenis_kelamin" type="text"
                                        class="form-control @error('jenis_kelamin') is-invalid @enderror"
                                        name="jenis_kelamin" required autocomplete="new-jenis_kelamin">
                                        <option selected disabled>-- Jenis Kelamin --</option>
                                        <option value="0">Pria</option>
                                        <option value="1">Wanita</option>
                                    </select>
                                    @error('jenis_kelamin')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="email"
                                    class="col-md-4 col-form-label text-md-end">{{ __('Alamat Email') }}</label>

                                <div class="col-md-6">
                                    <input id="email" type="email"
                                        class="form-control @error('email') is-invalid @enderror" name="email"
                                        value="{{ old('email') }}" required autocomplete="email"
                                        placeholder="text@gmail.com">

                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="master_lokasi_id"
                                    class="col-md-4 col-form-label text-md-end">{{ __('Lokasi Kerja') }}</label>
                                <div class="col-md-6">
                                    <select class="form-control @error('master_lokasi_id') is-invalid @enderror"
                                        name="master_lokasi_id" id="master_lokasi_id">
                                        <option selected disabled>-- Pilih Lokasi --</option>
                                        @foreach ($lokasi as $lok)
                                            <option value="{{ $lok->id }}">{{ $lok->nama_lokasi }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                @error('master_lokasi_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="row mb-3">
                                <label for="password"
                                    class="col-md-4 col-form-label text-md-end">{{ __('Kata Sandi') }}</label>

                                <div class="col-md-6">
                                    <div class="input-group input-group-joined" id="show_hide_password">
                                        <input class="form-control @error('password') is-invalid @enderror"
                                            type="password" placeholder="Password" aria-label="Password" required
                                            autocomplete="new-password" id="password" name="password">
                                        <span class="input-group-text">
                                            <a href=""><i class="bi bi-eye-slash a" aria-hidden="true"></i></a>
                                        </span>
                                    </div>

                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="password-confirm"
                                    class="col-md-4 col-form-label text-md-end">{{ __('Konfirmasi Kata Sandi') }}</label>

                                <div class="col-md-6">
                                    <div class="input-group input-group-joined" id="show_hide_passworda">
                                        <input class="form-control @error('password') is-invalid @enderror"
                                            type="password" placeholder="Password" aria-label="Password" required
                                            autocomplete="new-password" id="password-confirm"
                                            name="password_confirmation">
                                        <span class="input-group-text">
                                            <a href=""><i class="bi bi-eye-slash a" aria-hidden="true"></i></a>
                                        </span>
                                    </div>
                                    {{--  <input id="password-confirm" type="password" class="form-control"
                                        name="password_confirmation" required autocomplete="new-password">  --}}
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="col">
                                    <a href="{{ route('user.index') }}" class="btn btn-danger btn-md" role="button"
                                        aria-pressed="true">Kembali</a>
                                    <!-- Button trigger modal -->
                                    <button class="btn btn-primary btn-md" type="button" data-bs-toggle="modal"
                                        data-bs-target="#exampleModalCenter">Simpan</button>

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
                                                    Data ini akan disimpan.
                                                    Pastikan form diatas telah terisi dengan benar!
                                                </div>
                                                <div class="modal-footer"><button class="btn btn-secondary"
                                                        type="button" data-bs-dismiss="modal">Tutup</button>
                                                    <button class="btn btn-primary" type="submit">Simpan</button>
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

        <script>
            $(document).ready(function() {
                $("#show_hide_password a").on('click', function(event) {
                    event.preventDefault();
                    if ($('#show_hide_password input').attr("type") == "text") {
                        $('#show_hide_password input').attr('type', 'password');
                        $('#show_hide_password i').addClass("bi bi-eye-slash a");
                        $('#show_hide_password i').removeClass("bi bi-eye a");
                    } else if ($('#show_hide_password input').attr("type") == "password") {
                        $('#show_hide_password input').attr('type', 'text');
                        $('#show_hide_password i').removeClass("bi bi-eye-slash a");
                        $('#show_hide_password i').addClass("bi bi-eye a");
                    }
                });

                $("#show_hide_passworda a").on('click', function(event) {
                    event.preventDefault();
                    if ($('#show_hide_passworda input').attr("type") == "text") {
                        $('#show_hide_passworda input').attr('type', 'password');
                        $('#show_hide_passworda i').addClass("bi bi-eye-slash b");
                        $('#show_hide_passworda i').removeClass("bi bi-eye b");
                    } else if ($('#show_hide_passworda input').attr("type") == "password") {
                        $('#show_hide_passworda input').attr('type', 'text');
                        $('#show_hide_passworda i').removeClass("bi bi-eye-slash b");
                        $('#show_hide_passworda i').addClass("bi bi-eye b");
                    }
                });
            });
        </script>
    @endsection
