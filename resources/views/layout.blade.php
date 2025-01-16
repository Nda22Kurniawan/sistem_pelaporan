<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SILAPOK POLDA JATENG</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('_img/favicon.ico') }}">

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="/assets/plugins/fontawesome-free/css/all.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Tempusdominus Bootstrap 4 -->
    <link rel="stylesheet" href="/assets/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
    <!-- iCheck -->
    <link rel="stylesheet" href="/assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <!-- JQVMap -->
    <link rel="stylesheet" href="/assets/plugins/jqvmap/jqvmap.min.css">

    <!-- DataTables -->
    <link rel="stylesheet" href="/assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="/assets/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet" href="/assets/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">

    <!-- Theme style -->
    <link rel="stylesheet" href="/assets/dist/css/adminlte.min.css">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="/assets/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
    <!-- Daterange picker -->
    <link rel="stylesheet" href="/assets/plugins/daterangepicker/daterangepicker.css">
    <!-- summernote -->
    <link rel="stylesheet" href="/assets/plugins/summernote/summernote-bs4.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <style>
        .logo-container {
            padding: 1rem;
            background: var(--primary-color);
            display: flex;
            align-items: center;
            height: 70px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .logo-container img {
            height: 40px;
            width: auto;
            margin-right: 8px;
        }
    </style>
</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
        <!-- Preloader -->
        <!-- <div class="preloader flex-column justify-content-center align-items-center">
            <img class="animation__shake" src="/assets/dist/img/AdminLTELogo.png" alt="AdminLTELogo"
                height="60" width="60">
        </div> -->
        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                    <a href="index3.html" class="nav-link">Home</a>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                    <a href="#" class="nav-link">Contact</a>
                </li>
            </ul>
            <!-- Right navbar links -->
            <ul class="navbar-nav ml-auto">
                <!-- Navbar Search -->
                <li class="nav-item">
                    <a class="nav-link" data-widget="navbar-search" href="#" role="button">
                        <i class="fas fa-search"></i>
                    </a>
                    <div class="navbar-search-block">
                        <form class="form-inline">
                            <div class="input-group input-group-sm">
                                <input class="form-control form-control-navbar" type="search"
                                    placeholder="Search" aria-label="Search">
                                <div class="input-group-append">
                                    <button class="btn btn-navbar" type="submit">
                                        <i class="fas fa-search"></i>
                                    </button>
                                    <button class="btn btn-navbar" type="button" data-widget="navbar-search">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </li>
                <!-- Notifications Dropdown Menu -->
                <li class="nav-item dropdown">
                    <a class="nav-link" data-toggle="dropdown" href="#">
                        <i class="far fa-bell"></i>
                        <span class="badge badge-warning navbar-badge">15</span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                        <span class="dropdown-item dropdown-header">15 Notifications</span>
                        <div class="dropdown-divider"></div>
                        <a href="#" class="dropdown-item">
                            <i class="fas fa-envelope mr-2"></i> 4 new messages
                            <span class="float-right text-muted text-sm">3 mins</span>
                        </a>
                        <div class="dropdown-divider"></div>
                        <a href="#" class="dropdown-item">
                            <i class="fas fa-users mr-2"></i> 8 friend requests
                            <span class="float-right text-muted text-sm">12 hours</span>
                        </a>
                        <div class="dropdown-divider"></div>
                        <a href="#" class="dropdown-item">
                            <i class="fas fa-file mr-2"></i> 3 new reports
                            <span class="float-right text-muted text-sm">2 days</span>
                        </a>
                        <div class="dropdown-divider"></div>
                        <a href="#" class="dropdown-item dropdown-footer">See All Notifications</a>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                        <i class="fas fa-expand-arrows-alt"></i>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#"
                        role="button">
                        <i class="fas fa-th-large"></i>
                    </a>
                </li>
                <li>
                    <button class="btn dropdown-toggle" type="button" id="profileDropdown" data-bs-toggle="dropdown">
                        <img src="/assets/dist/img/user2-160x160.jpg" alt="Profile" class="rounded-circle" width="35">
                        <span class="ms-2 d-none d-md-inline">John Doe</span>
                    </button>
                </li>
            </ul>
        </nav>
        <!-- /.navbar -->
        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <!-- Brand Logo -->
            <div class="logo-container">
                <img src="{{ asset('assets/dist/img/logo_polda.png') }}" alt="Logo Polda Jateng">
                <img src="{{ asset('assets/dist/img/tik_polri.png') }}" alt="Logo TIK">
                <div class="brand-text text-white">
                    Bid TIK<br>Polda Jateng
                </div>
            </div>
            <!-- Sidebar -->
            <div class="sidebar">
                <!-- Sidebar user panel (optional) -->
                <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                    <div class="image">
                        <img src="/assets/dist/img/user2-160x160.jpg" class="img-circle elevation-2"
                            alt="User Image">
                    </div>
                    <div class="info">
                        <a href="#" class="d-block">Nanda Dwi Kurniawan</a>
                    </div>
                </div>
                <!-- SidebarSearch Form -->
                <div class="form-inline">
                    <div class="input-group" data-widget="sidebar-search">
                        <input class="form-control form-control-sidebar" type="search" placeholder="Search"
                            aria-label="Search">
                        <div class="input-group-append">
                            <button class="btn btn-sidebar">
                                <i class="fas fa-search fa-fw"></i>
                            </button>
                        </div>
                    </div>
                </div>
                <!-- Sidebar Menu -->
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                        <li class="nav-item">
                            <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-home"></i>
                                <p>Dashboard</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('users.index') }}" class="nav-link {{ request()->routeIs('users.*') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-user"></i>
                                <p>Data Personil</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('sprin.index') }}" class="nav-link {{ request()->routeIs('sprin.*') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-file-alt"></i>
                                <p>Surat Perintah</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('laporan.index') }}" class="nav-link {{ request()->routeIs('laporan.*') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-chart-bar"></i>
                                <p>Laporan Kegiatan</p>
                            </a>
                        </li>
                    </ul>
                </nav>
                <!-- /.sidebar-menu -->
            </div>
            <!-- /.sidebar -->
        </aside>


        <!-- Content Wrapper. Contains page content -->
        @yield('content')
        <!-- /.content-wrapper -->
        <footer class="main-footer">
            <strong>BID TIK Polda Jateng</strong>
            <div class="float-right d-none d-sm-inline-block">
                <b>2025</b>
            </div>
        </footer>
        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->
    </div>
    <!-- ./wrapper -->

    <!-- Scripts -->
    <script src="/assets/plugins/jquery/jquery.min.js"></script>
    <script src="/assets/plugins/jquery-ui/jquery-ui.min.js"></script>
    <script>
        $.widget.bridge('uibutton', $.ui.button);
    </script>
    <script src="/assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="/assets/plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="/assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
    <script src="/assets/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
    <script src="/assets/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
    <script src="/assets/plugins/jszip/jszip.min.js"></script>
    <script src="/assets/plugins/pdfmake/pdfmake.min.js"></script>
    <script src="/assets/plugins/pdfmake/vfs_fonts.js"></script>
    <script src="/assets/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>


    <script>
        // Toastr message script
        @if(Session::has('success'))
        toastr.success("{{ Session::get('success') }}", "BERHASIL!");
        @elseif(Session::has('error'))
        toastr.error("{{ Session::get('error') }}", "GAGAL!");
        @endif
    </script>

    <!-- DataTable Script -->
    <script>
        $(function() {
            $("#example1").DataTable({
                "responsive": true,
                "lengthChange": false,
                "autoWidth": false,
                "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
            }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
            $('#example2').DataTable({
                "paging": true,
                "lengthChange": false,
                "searching": false,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
            });
        });
    </script>
</body>

</html>