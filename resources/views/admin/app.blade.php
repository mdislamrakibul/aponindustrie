<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Admin Panel</title>

    <link rel="stylesheet" href="{{ asset('admin/plugins/fontawesome-free/css/all.min.css') }}">

    <link rel="stylesheet" href="{{ asset('admin/dist/css/adminlte.min.css') }}">

</head>

<body class="hold-transition sidebar-mini">

<div class="wrapper">

    <!-- Navbar -->

    <nav class="main-header navbar navbar-expand navbar-white navbar-light">

        <ul class="navbar-nav">

            <li class="nav-item has-treeview">

                <a class="nav-link" data-widget="pushmenu" href="#">

                    <i class="fas fa-bars"></i>

                </a>

            </li>

        </ul>

    </nav>

    <!-- Sidebar -->

    <aside class="main-sidebar sidebar-dark-primary elevation-4">

        <a href="#" class="brand-link">

            <span class="brand-text font-weight-light">Admin Panel</span>

        </a>

        <div class="sidebar">

            <nav class="mt-2">

                <ul class="nav nav-pills nav-sidebar flex-column">

                    <li class="nav-item">

                        <a href="/admin/dashboard" class="nav-link">

                            <i class="nav-icon fas fa-tachometer-alt"></i>

                            <p>Dashboard</p>

                        </a>

                    </li>

                </ul>

            </nav>

        </div>

    </aside>

    <!-- Content -->

    <div class="content-wrapper p-3">

        @yield('content')

    </div>

</div>
@stack('scripts')

<script src="{{ asset('admin/plugins/jquery/jquery.min.js') }}"></script>

<script src="{{ asset('admin/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

<script src="{{ asset('admin/dist/js/adminlte.min.js') }}"></script>

</body>

</html>