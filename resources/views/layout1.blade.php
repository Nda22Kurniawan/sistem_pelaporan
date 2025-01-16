<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SILAPOK POLDA JATENG</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('_img/favicon.ico') }}">

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Public+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="/assets/plugins/fontawesome-free/css/all.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Tempusdominus Bootstrap 4 -->
    <link rel="stylesheet" href="/assets/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" rel="stylesheet">
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
        :root {
            --primary-color: #003366;
            --secondary-bg: #f5f5f9;
            --menu-bg: #ffffff;
            --menu-text: #697a8d;
            --menu-hover: #003366;
            --menu-active-bg: #e7e7ff;
            --menu-active-text: #003366;
        }

        body {
            font-family: 'Public Sans', sans-serif;
            background-color: var(--secondary-bg);
            min-height: 100vh;
        }

        /* Sidebar Styles */
        .sidebar {
            width: 260px;
            background: var(--menu-bg);
            box-shadow: 0 2px 6px rgba(67, 89, 113, 0.12);
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            transition: all 0.3s ease;
            z-index: 1040;
        }

        /* Logo Container */
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

        .brand-text {
            color: white;
            font-size: 0.9rem;
            font-weight: 600;
            line-height: 1.2;
            margin-left: 8px;
        }

        /* Sidebar Menu */
        .sidebar-menu {
            padding: 1rem 0;
            overflow-y: auto;
            height: calc(100vh - 70px);
        }

        .menu-header {
            padding: 0.5rem 1.5rem;
            font-size: 0.75rem;
            text-transform: uppercase;
            color: #a1acb8;
            font-weight: 600;
            margin-top: 0.5rem;
        }

        .nav-item {
            margin: 4px 1rem;
        }

        .nav-link {
            display: flex;
            align-items: center;
            padding: 0.625rem 1rem;
            color: var(--menu-text);
            border-radius: 0.375rem;
            transition: all 0.3s ease;
            font-size: 0.9375rem;
            font-weight: 500;
            white-space: nowrap;
        }

        .nav-link i {
            font-size: 1.125rem;
            margin-right: 1rem;
            flex-shrink: 0;
            width: 22px;
            text-align: center;
        }

        .nav-link:hover {
            color: var(--menu-hover);
            background: rgba(67, 89, 113, 0.04);
        }

        .nav-link.active {
            color: var(--menu-active-text);
            background: var(--menu-active-bg);
            font-weight: 600;
            box-shadow: 0 2px 6px rgba(67, 89, 113, 0.08);
        }

        /* Navbar */
        .navbar-custom {
            margin-left: 260px;
            height: 70px;
            background-color: var(--primary-color);
            padding: 0 1rem;
            box-shadow: 0 2px 6px rgba(67, 89, 113, 0.12);
        }

        /* Search Bar */
        .search-bar {
            position: relative;
            max-width: 400px;
        }

        .search-bar input {
            padding: 0.5rem 1rem 0.5rem 2.75rem;
            background-color: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.1);
            color: white;
            border-radius: 0.375rem;
            font-size: 0.9375rem;
            width: 100%;
        }

        .search-bar input::placeholder {
            color: rgba(255, 255, 255, 0.7);
        }

        .search-bar i {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: rgba(255, 255, 255, 0.7);
        }

        /* Profile Dropdown */
        .profile-dropdown .dropdown-toggle {
            padding: 0.5rem;
            border-radius: 0.375rem;
            display: flex;
            align-items: center;
            color: white;
        }

        .profile-dropdown .dropdown-toggle:hover {
            background: rgba(255, 255, 255, 0.1);
        }

        .profile-dropdown .dropdown-toggle::after {
            display: none;
        }

        .profile-dropdown .dropdown-menu {
            margin-top: 0.5rem;
            border: none;
            box-shadow: 0 2px 16px rgba(67, 89, 113, 0.1);
            border-radius: 0.5rem;
        }

        .profile-dropdown .dropdown-item {
            padding: 0.75rem 1.25rem;
            color: var(--menu-text);
            font-size: 0.9375rem;
            transition: all 0.3s ease;
        }

        .profile-dropdown .dropdown-item:hover {
            background: rgba(67, 89, 113, 0.04);
            color: var(--menu-hover);
        }

        /* Main Content */
        .main-content {
            margin-left: 260px;
            padding: 1.5rem;
            min-height: calc(100vh - 70px);
            margin-top: 70px;
            background: var(--secondary-bg);
            transition: all 0.3s ease;
        }

        /* Responsive */
        @media (max-width: 992px) {
            .sidebar {
                transform: translateX(-100%);
            }

            .sidebar.show {
                transform: translateX(0);
            }

            .navbar-custom,
            .main-content {
                margin-left: 0;
            }
        }
    </style>
</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">

        <!-- Navbar -->
        <nav class="navbar navbar-expand-lg navbar-custom navbar-dark fixed-top">
            <div class="container-fluid">
                <button class="btn text-white border-0" type="button" id="sidebarToggle">
                    <i class="fas fa-bars"></i>
                </button>

                <div class="search-bar d-none d-md-block ms-3">
                    <i class="fas fa-search"></i>
                    <input type="text" class="form-control bg-transparent" placeholder="Search (Ctrl + /)">
                </div>

                <div class="ms-auto d-flex align-items-center">
                    <div class="dropdown profile-dropdown">
                        <button class="btn dropdown-toggle" type="button" id="profileDropdown" data-bs-toggle="dropdown">
                            <img src="{{ asset('assets/img/avatars/default.png') }}" alt="Profile" class="rounded-circle" width="35">
                            <span class="ms-2 d-none d-md-inline">John Doe</span>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="#"><i class="fas fa-user me-2"></i> Profile</a></li>
                            <li><a class="dropdown-item" href="#"><i class="fas fa-cog me-2"></i> Settings</a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li>
                                <form>
                                    @csrf
                                    <button type="submit" class="dropdown-item"><i class="fas fa-sign-out-alt me-2"></i> Logout</button>
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Sidebar -->
        <aside class="main-sidebar sidebar-light-primary elevation-4">
            <div class="logo-container">
                <img src="{{ asset('assets/dist/img/logo_polda.png') }}" alt="Logo Polda Jateng">
                <img src="{{ asset('assets/dist/img/tik_polri.png') }}" alt="Logo TIK">
                <div class="brand-text">
                    Bid TIK<br>Polda Jateng
                </div>
            </div>

            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                    data-accordion="false">
                    <!-- Add icons to the links using the .nav-icon class with font-awesome or any other icon font library -->
                    <li class="nav-item">
                        <a href="dashboard.html" class="nav-link">
                            <i class="nav-icon fas fa-home"></i>
                            <p>
                                Dashboard
                            </p>
                        </a>
                    </li>
                    <li class="nav-item menu-open">
                        <a href="#" class="nav-link active">
                            <i class="nav-icon fas fa-user"></i>
                            <p>
                                Master
                                <i class="fas fa-angle-left right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a class="nav-link active">
                                    <i class="far fa-file-alt nav-icon"></i>
                                    <p>User</p>
                                </a>
                            </li>
                        </ul>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a class="nav-link active">
                                    <i class="far fa-chart-bar nav-icon"></i>
                                    <p>User</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </nav>
        </aside>

        <!-- Footer -->
        <footer class="footer-custom">
            <strong>&copy; 2025 Bid TIK Polda Jateng.</strong> All rights reserved.
        </footer>

        <!-- Main Content -->
        <main class="main-content">
            @yield('content')
        </main>
        <!-- /.content-wrapper -->
    </div>
    <!-- ./wrapper -->

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"></script>
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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        // Sidebar Toggle
        document.getElementById('sidebarToggle').addEventListener('click', function() {
            document.querySelector('.sidebar').classList.toggle('show');
        });

        // Close sidebar when clicking outside on mobile
        document.addEventListener('click', function(event) {
            const sidebar = document.querySelector('.sidebar');
            const sidebarToggle = document.getElementById('sidebarToggle');

            if (window.innerWidth < 992 &&
                !sidebar.contains(event.target) &&
                !sidebarToggle.contains(event.target)) {
                sidebar.classList.remove('show');
            }
        });
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
    @stack('scripts')
</body>

</html>