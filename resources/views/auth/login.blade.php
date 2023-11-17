<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Login - {{ env('APP_NAME') }}</title>
    <link href="{{ asset('admin/dist/css/styles.css') }}" rel="stylesheet" />
    <link rel="icon" type="image/x-icon" href="{{ asset('admin/dist/assets/img/favicon.png') }}" />
    <script data-search-pseudo-elements defer src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js"
        crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/feather-icons/4.28.0/feather.min.js" crossorigin="anonymous">
    </script>
</head>

<body class="bg-primary">
    <div id="layoutAuthentication">
        <div id="layoutAuthentication_content">
            <main>
                <div class="container-xl px-4">
                    <div class="row justify-content-center">
                        <div class="col-lg-5">
                            <!-- Basic login form-->
                            <div class="card shadow-lg border-0 rounded-lg mt-5">
                                <div class="card-header justify-content-center">
                                    <h3 class="fw-light my-4">Login</h3>
                                </div>
                                <div class="card-body">
                                    @if ($errors->any())
                                        <div class="alert alert-danger">
                                            Email/Password salah!
                                        </div>
                                    @endif
                                    <!-- Login form-->
                                    <form method="POST" action="{{ route('login') }}">
                                        @csrf
                                        <!-- Form Group (email address)-->
                                        <div class="mb-3">
                                            <label class="small mb-1" for="email">Email</label>
                                            <input id="email" type="email"
                                                class="form-control" name="email"
                                                value="{{ old('email') }}" required autocomplete="email" autofocus>

                                            {{-- @error('email')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>Email salah!</strong>
                                                </span>
                                            @enderror --}}
                                        </div>
                                        <!-- Form Group (password)-->
                                        <div class="mb-3">
                                            <label class="small mb-1" for="inputPassword">Password</label>
                                            <input id="password" type="password"
                                                class="form-control"
                                                name="password" required autocomplete="current-password">

                                            {{-- @error('password')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>Password Salah!</strong>
                                                </span>
                                            @enderror --}}
                                        </div>
                                        <!-- Form Group (login box)-->
                                        <div class="d-flex align-items-center justify-content-between mt-4 mb-0">
                                            {{--  <a class="small" href="auth-password-basic.html">Forgot Password?</a>  --}}
                                            <button type="submit" class="btn btn-primary align-end">
                                                {{ __('Login') }}
                                            </button>
                                        </div>
                                    </form>
                                </div>
                                <div class="card-footer text-center">
                                    @if (env('APP_DEBUG') == true)
                                        <div class="small">Hubungi planner untuk melakukan pendaftaran</div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
        <div id="layoutAuthentication_footer">
            <footer class="footer-admin mt-auto footer-dark">
                <!-- <div class="container-xl px-4">
                    <div class="row">
                        <div class="col-md-6 small">Copyright &copy; {{ env('APP_NAME') }}
                            <script>
                                document.write(new Date().getFullYear());
                            </script>
                        </div>
                        <div class="col-md-6 text-md-end small">
                            <a href="#!"> </a> &middot;
                            <a href="#!"> </a>
                        </div>
                    </div>
                </div> -->
            </footer>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous">
    </script>
    <script src="{{ asset('admin/dist/js/scripts.js') }}"></script>
</body>

</html>
