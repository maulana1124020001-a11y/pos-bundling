<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>POS Kafe</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

</head>
<body>

<!-- NAVBAR -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand" href="#">POS Kafe</a>

        <div>
            <ul class="navbar-nav me-auto mb-2 mb-lg-0 d-flex flex-row gap-3">

                <li class="nav-item">
                    <a class="nav-link text-white" href="{{ route('kategori.index') }}">Kategori</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link text-white" href="{{ route('menu.index') }}">Menu</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link text-white" href="#">Transaksi</a>
                </li>

            </ul>
        </div>
    </div>
</nav>

<!-- CONTENT -->
<div class="container mt-4">

    {{-- ALERT SUCCESS --}}
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    {{-- ISI HALAMAN --}}
    @yield('content')

</div>

</body>
</html>