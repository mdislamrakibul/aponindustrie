<!DOCTYPE html>
<html>
<head>

    <title>Admin Panel</title>

    <link rel="stylesheet" href="{{ asset('admin/plugins/fontawesome-free/css/all.min.css') }}">

    <link rel="stylesheet" href="{{ asset('admin/dist/css/adminlte.min.css') }}">

</head>

<body class="hold-transition sidebar-mini">

<div class="wrapper">

    <nav class="main-header navbar navbar-expand navbar-white navbar-light">

        <span class="navbar-brand">Admin Panel</span>

    </nav>

    <aside class="main-sidebar sidebar-dark-primary elevation-4">

        <a href="#" class="brand-link">

            <span class="brand-text font-weight-light">AdminLTE</span>

        </a>

    </aside>

    <div class="content-wrapper">

        @yield('content')

    </div>

</div>

<script src="{{ asset('admin/plugins/jquery/jquery.min.js') }}"></script>

<script src="{{ asset('admin/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

<script src="{{ asset('admin/dist/js/adminlte.min.js') }}"></script>

</body>
</html>