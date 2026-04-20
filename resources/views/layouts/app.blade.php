<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>POS Kafe</title>

    <!-- SB Admin CSS -->
    <link href="{{ asset('css/sb-admin-2.min.css') }}" rel="stylesheet">

    <!-- Font Awesome -->
    <link href="{{ asset('vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet">

</head>

<body id="page-top">

<div id="wrapper">

    <!-- SIDEBAR -->
    <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

        <!-- BRAND -->
        <a class="sidebar-brand d-flex align-items-center justify-content-center" href="#">
            <div class="sidebar-brand-icon">
                <i class="fas fa-coffee"></i>
            </div>
            <div class="sidebar-brand-text mx-3">POS Kafe</div>
        </a>

        <hr class="sidebar-divider">

        <!-- MENU -->
        <li class="nav-item">
            <a class="nav-link" href="{{ route('kategori.index') }}">
                <i class="fas fa-tags"></i>
                <span>Kategori</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link" href="{{ route('menu.index') }}">
                <i class="fas fa-utensils"></i>
                <span>Menu</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link" href="#">
                <i class="fas fa-cash-register"></i>
                <span>Transaksi</span>
            </a>
        </li>

        <hr class="sidebar-divider">

    </ul>
    <!-- END SIDEBAR -->


    <!-- CONTENT WRAPPER -->
    <div id="content-wrapper" class="d-flex flex-column">

        <div id="content">

            <!-- TOPBAR -->
            <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 shadow">

                <button id="sidebarToggleTop" class="btn btn-link d-md-none">
                    <i class="fa fa-bars"></i>
                </button>

                <span class="ml-3 font-weight-bold">Dashboard POS Kafe</span>

            </nav>
            <!-- END TOPBAR -->


            <!-- CONTENT -->
            <div class="container-fluid">

                <!-- ALERT -->
                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                <!-- ISI HALAMAN -->
                @yield('content')

            </div>

        </div>

        <!-- FOOTER -->
        <footer class="sticky-footer bg-white">
            <div class="container text-center">
                <span>© POS Kafe 2026</span>
            </div>
        </footer>

    </div>

</div>

<!-- SCRIPT -->
<script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('js/sb-admin-2.min.js') }}"></script>

</body>
</html>