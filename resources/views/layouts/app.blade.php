<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Titik Temu - POS System</title>

    <link href="https://fonts.googleapis.com/css?family=Nunito:200,300,400,600,700,800,900" rel="stylesheet">

    <link href="{{ asset('vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet">

    <link href="{{ asset('css/sb-admin-2.min.css') }}" rel="stylesheet">


    <link href="{{ asset('vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">

    <style>
        /* Custom style untuk alert agar tidak menutupi konten */
        .alert-fixed {
            position: fixed;
            top: 20px;
            left: 50%;
            transform: translateX(-50%);
            z-index: 9999;
            min-width: 300px;
        }
    </style>
</head>

<body id="page-top">
    @php
        $user = auth()->user();
        $Admin = $user->role_id == 1;
    @endphp

    <div id="wrapper">

        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="#">
                <div class="sidebar-brand-icon">
                    <i class="fas fa-coffee"></i>
                </div>
                <div class="sidebar-brand-text mx-3">Titik Temu</div>
            </a>

            <hr class="sidebar-divider my-0">

            {{-- Dashboard khusus admin --}}
        @if($Admin)
            <li class="nav-item {{ Request::is('dashboard') ? 'active' : '' }}">
                <a class="nav-link" href="{{ url('/dashboard') }}">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</span>
                </a>
            </li>
        @endif

        <hr class="sidebar-divider">

        <div class="sidebar-heading">
            Transaksi
        </div>

        <li class="nav-item {{ Request::is('transaksi/create') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('transaksi.create') }}">
                <i class="fas fa-fw fa-cash-register"></i>
                <span>Kasir (POS)</span>
            </a>
        </li>

        <li class="nav-item {{ Request::is('transaksi') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('transaksi.index') }}">
                <i class="fas fa-fw fa-history"></i>
                <span>Riwayat Transaksi</span>
            </a>
        </li>

        <li class="nav-item {{ Request::is('customer*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('customer.index') }}">
                <i class="fas fa-fw fa-user-friends"></i>
                <span>Customer</span>
            </a>
        </li>

        {{-- Master Data khusus admin --}}
        @if($Admin)
            <hr class="sidebar-divider">

            <div class="sidebar-heading">
                Master Data
            </div>

            <li class="nav-item {{ Request::is('kategori*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('kategori.index') }}">
                    <i class="fas fa-fw fa-cat"></i>
                    <span>Kategori</span>
                </a>
            </li>

            <li class="nav-item {{ Request::is('menu*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('menu.index') }}">
                    <i class="fas fa-fw fa-utensils"></i>
                    <span>Menu</span>
                </a>
            </li>

            <li class="nav-item {{ Request::is('diskon*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('diskon.index') }}">
                    <i class="fas fa-fw fa-tags"></i>
                    <span>Diskon</span>
                </a>
            </li>

            <li class="nav-item {{ Request::is('user*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('user.index') }}">
                    <i class="fas fa-fw fa-users"></i>
                    <span>User Management</span>
                </a>
            </li>

            <li class="nav-item {{ Request::is('laporan*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('laporan.index') }}">
                    <i class="fas fa-fw fa-clipboard-list"></i>
                    <span>Laporan</span>
                </a>
            </li>

            <li class="nav-item {{ Request::is('rekomendasi*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('rekomendasi.index') }}">
                    <i class="fas fa-fw fa-users"></i>
                    <span>Rekomendasi Bundling</span>
                </a>
            </li>
        @endif
            <hr class="sidebar-divider d-none d-md-block">

            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>

        </ul>
        <div id="content-wrapper" class="d-flex flex-column">

            <div id="content">

                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-3 shadow">

                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>

                    <ul class="navbar-nav ml-auto">

                        <div class="topbar-divider d-none d-sm-block"></div>

                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small">
                                    {{ auth()->user()->nama }} ({{ auth()->user()->role_id == 1 ? 'Admin' : 'Kasir' }})
                                </span>
                                <img class="img-profile rounded-circle"
                                    src="https://ui-avatars.com/api/?name={{ auth()->user()->nama }}&background=4e73df&color=fff">
                            </a>
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="userDropdown">
                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Logout
                                </a>
                            </div>
                        </li>

                    </ul>

                </nav>
                <div class="container-fluid">

                    @if (session('success'))
                        <div id="alert-msg" class="alert alert-success alert-dismissible fade show alert-fixed">
                            <i class="fas fa-check-circle mr-2 "></i> {{ session('success') }}
                            <button type="button" class="close" data-dismiss="alert">&times;</button>
                        </div>
                    @endif

                    @if (session('error'))
                        <div id="alert-msg" class="alert alert-danger alert-dismissible fade show alert-fixed">
                            <i class="fas fa-exclamation-triangle mr-2"></i> {{ session('error') }}
                            <button type="button" class="close" data-dismiss="alert">&times;</button>
                        </div>
                    @endif

                    @yield('content')

                </div>
            </div>
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy; Titik Temu 2026</span>
                    </div>
                </div>
            </footer>
        </div>
    </div>
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Yakin ingin keluar?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Pilih "Logout" di bawah jika Anda ingin mengakhiri sesi ini.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Batal</button>
                    <a class="btn btn-primary" href="#"
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('vendor/jquery-easing/jquery.easing.min.js') }}"></script>

    <script src="{{ asset('js/sb-admin-2.min.js') }}"></script>

    <script src="{{ asset('vendor/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>

    <script src="js/demo/datatables-demo.js"></script>

    <script>
        $(document).ready(function() {
            // Memeriksa apakah ada elemen alert di halaman
            if ($('#alert-msg').length > 0) {
                // Sembunyikan otomatis setelah 4000ms (4 detik)
                setTimeout(function() {
                    $('#alert-msg').fadeOut('slow', function() {
                        $(this).remove();
                    });
                }, 4000); 
            }
        });
    </script>

    @stack('scripts')

    <script src="{{ asset('js/preview.js') }}"></script>
</body>

</html>