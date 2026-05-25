<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login</title>

    <!-- SB Admin 2 -->
    <link href="{{ asset('vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,300,400,600,700,800,900" rel="stylesheet">
    <link href="{{ asset('css/sb-admin-2.min.css') }}" rel="stylesheet">

    <style>
        body {
            height: 100vh;
        }

        .center-login {
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .bg-login-image {
            background: url('{{ asset('img/4.jpg') }}');
            background-position: center;
            background-size: cover;
        }
    </style>

</head>

<body class="bg-secondary">

    <div class="container center-login">

        <div class="col-xl-10 col-lg-12 col-md-9">

            <div class="card o-hidden border-0 shadow-lg">
                <div class="card-body p-0">

                    <div class="row">

                        <!-- GAMBAR KIRI -->
                        <div class="col-lg-6 d-none d-lg-block bg-login-image"></div>

                        <!-- FORM LOGIN -->
                        <div class="col-lg-6">
                            <div class="p-5">

                                <div class="text-center">
                                    <h1 class="h4 text-gray-900 mb-4">
                                        Selamat Datang di POS
                                    </h1>
                                </div>

                                {{-- ERROR --}}
                                @if ($errors->any())
                                    <div class="alert alert-danger">
                                        {{ $errors->first() }}
                                    </div>
                                @endif

                                <form class="user" method="POST" action="{{ url('/login') }}">
                                    @csrf

                                    <div class="form-group">
                                        <input type="email" name="email" value="{{ old('email') }}" class="form-control form-control-user"
                                            placeholder="Masukkan Email..." required>
                                    </div>

                                    <div class="form-group">
                                        <input type="password" name="password" class="form-control form-control-user"
                                            placeholder="Password" required>
                                    </div>

                                    <div class="form-group">
                                        <div class="custom-control custom-checkbox small">
                                            <input type="checkbox" name="remember" class="custom-control-input"
                                                id="customCheck">
                                            <label class="custom-control-label" for="customCheck">
                                                Remember Me
                                            </label>
                                        </div>
                                    </div>

                                    <button type="submit" class="btn btn-primary btn-user btn-block">
                                        Login
                                    </button>

                                    <hr>

                                </form>

                            </div>
                        </div>

                    </div>

                </div>
            </div>

        </div>

    </div>

    <!-- JS -->
    <script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('vendor/jquery-easing/jquery.easing.min.js') }}"></script>
    <script src="{{ asset('js/sb-admin-2.min.js') }}"></script>

</body>

</html>
