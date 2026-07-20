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

        .card {
            border-radius: 15px;
        }

        /* Gambar Login */
        .bg-login-image {
            background-image: url('{{ asset("img/2.png") }}');
            background-repeat: no-repeat;
            background-position: center;
            background-size: contain;
            background-color: #0a0a0a;
            min-height: 250px;
        }
    </style>

</head>

<body class="bg-secondary">

    <div class="container center-login">

        <div class="col-xl-11 col-lg-11 col-md-10">

            <div class="card o-hidden border-0 shadow-lg">

                <div class="card-body p-0">

                    <div class="row">

                        <!-- GAMBAR -->
                        <div class="col-lg-6 d-none d-lg-block bg-login-image"></div>

                        <!-- FORM LOGIN -->
                        <div class="col-lg-6">

                            <div class="p-5">

                                <div class="text-center mb-4">
                                    <h1 class="h3 text-gray-900 font-weight-bold">
                                        Selamat Datang
                                    </h1>

                                    <p class="text-muted">
                                        Silakan login ke Sistem POS
                                    </p>
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
                                        <input
                                            type="email"
                                            name="email"
                                            value="{{ old('email') }}"
                                            class="form-control form-control-user"
                                            placeholder="Masukkan Email"
                                            required>
                                    </div>

                                    <div class="form-group">
                                        <input
                                            type="password"
                                            name="password"
                                            class="form-control form-control-user"
                                            placeholder="Masukkan Password"
                                            required>
                                    </div>

                                    <button
                                        type="submit"
                                        class="btn btn-primary btn-user btn-block">
                                        Login
                                    </button>

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