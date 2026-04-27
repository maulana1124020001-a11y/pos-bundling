<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Titik Temu</title>

    <!-- Font -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,300,400,600,700,800,900" rel="stylesheet">

    <!-- Font Awesome -->
    <link href="{{ asset('vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet">

    <!-- SB Admin -->
    <link href="{{ asset('css/sb-admin-2.min.css') }}" rel="stylesheet">

    <!-- DataTables -->
    <link href="{{ asset('vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
</head>


<body id="page-top">

    <div id="wrapper">

        <!-- SIDEBAR -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="#">
                <div class="sidebar-brand-icon">
                    <i class="fas fa-coffee"></i>
                </div>
                <div class="sidebar-brand-text mx-3">Titik Temu</div>
            </a>

            <hr class="sidebar-divider">

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
                <a class="nav-link" href="{{ route('diskon.index') }}">
                    <i class="fas fa-bell"></i>
                    <span>Diskon</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="{{ route('transaksi.index') }}">
                    <i class="fas fa-envelope"></i>
                    <span>Transaksi</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="{{ route('user.index') }}">
                    <i class="fas fa-users"></i>
                    <span>User</span>
                </a>
            </li>


            <hr class="sidebar-divider d-none d-md-block">

        </ul>
        <!-- END SIDEBAR -->


        <!-- CONTENT -->
        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">

                <!-- TOPBAR (INI YANG KURANG TADI) -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 shadow">

                    <!-- Toggle -->
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>

                <!-- RIGHT MENU -->
                <ul class="navbar-nav ml-auto">

                        <!-- NOTIF -->
                        <li class="nav-item mx-2">
                            <a class="nav-link" href="#">
                                <i class="fas fa-bell"></i>
                                <span class="badge badge-danger">3</span>
                            </a>
                        </li>

                        <!-- MESSAGE -->
                        <li class="nav-item mx-2">
                            <a class="nav-link" href="#">
                                <i class="fas fa-envelope"></i>
                                <span class="badge badge-danger">7</span>
                            </a>
                        </li>

                        <div class="topbar-divider d-none d-sm-block"></div>

                        <!-- USER -->
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small">Admin</span>
                                <img class="img-profile rounded-circle" src="https://via.placeholder.com/60">
                            </a>

                            <div class="dropdown-menu dropdown-menu-right shadow">
                                <a class="dropdown-item" href="#">Profile</a>
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-link text-danger nav-link"
                                        style="display:inline; cursor:pointer;">
                                        Logout ({{ auth()->user()->nama }})
                                    </button>
                                </form>
                            </div>
                        </li>

                    </ul>
                </nav>
                <!-- END TOPBAR -->


                <!-- ISI -->
                <div class="container-fluid">

                    @if(session('success'))
                        <div id="alert-success" class="alert alert-success alert-dismissible fade show">
                            {{ session('success') }}
                            <button type="button" class="close" data-dismiss="alert">&times;</button>
                        </div>
                    @endif

                    <script>
                        setTimeout(function () {
                            let alert = document.getElementById('alert-success');
                            if (alert) {
                                $(alert).fadeOut(500, function () {
                                    $(this).remove();
                                });
                            }
                        }, 3000);
                    </script>

                    @yield('content')

                </div>

            </div>

            <!-- FOOTER -->
            <footer class="sticky-footer bg-white">
                <div class="container text-center">
                    <span>© Titik Temu 2026</span>
                </div>
            </footer>

        </div>

    </div>


    <!-- SCRIPT -->
    <script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('vendor/jquery-easing/jquery.easing.min.js') }}"></script>

    <script src="{{ asset('js/sb-admin-2.min.js') }}"></script>

    <!-- DataTables -->
    <script src="{{ asset('vendor/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>

    <script>
        $(document).ready(function () {
            $('#dataTable').DataTable();
        });
    </script>



</body>

</html>