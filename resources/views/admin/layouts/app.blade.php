<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>@yield('title', 'title')</title>

    <link rel="stylesheet" href="{{ asset('admin/plugins/fontawesome-free/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/dist/css/adminlte.min.css') }}">
    <link rel="stylesheet" href="https://cdn.datatables.net/2.3.8/css/dataTables.dataTables.css" />



    <style>
        .child-menu {

            margin-left: 22px !important;
        }

        .child-menu .nav-link {

            padding-left: 18px !important;

            font-size: 14px;

            opacity: .95;
        }
    </style>

    @stack('css')

</head>

<body class="hold-transition sidebar-mini layout-fixed">

    <div class="wrapper">

        {{-- Navbar --}}
        @include('admin.layouts.navbar')

        {{-- Sidebar --}}
        @include('admin.layouts.sidebar')


        <section class="content pt-3">
            <div class="container-fluid">

                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show">
                        {{ session('success') }}

                        <button type="button"
                                class="close"
                                data-dismiss="alert">

                            <span>&times;</span>

                        </button>
                    </div>
                @endif

                @if ($errors->any())
                    <div class="alert alert-danger">

                        <ul class="mb-0">

                            @foreach ($errors->all() as $error)

                                <li>{{ $error }}</li>

                            @endforeach

                        </ul>

                    </div>
                @endif

                @yield('content')

            </div>
        </section>

    </div>

    <script src="{{ asset('admin/plugins/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('admin/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('admin/dist/js/adminlte.min.js') }}"></script>
    <script src="https://cdn.datatables.net/2.3.8/js/dataTables.js"></script>
    <script>
        $(document).ready( function () {
            $('#dataTable').DataTable();
        } );
    </script>
    @stack('scripts')
    @stack('js')


</body>

</html>
<style>
    .action-btn {

        width: 34px;
        height: 34px;

        border-radius: 10px;

        background: #fff;

        border: 0px solid #e5e7eb;

        display: flex;
        align-items: center;
        justify-content: center;

        color: #111827;

        transition: all .25s ease;

        text-decoration: none;
    }

    .action-btn i {

        font-size: 14px;
    }

    .action-btn:hover {

        background: #38bdf8;

        color: #fff;

        border-color: #38bdf8;

        transform: translateY(-1px);
    }

    .action-btn:focus {

        box-shadow: none;
    }
</style>
