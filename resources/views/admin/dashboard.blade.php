@extends('admin.layouts.app')

@section('title', 'Admin Dashboard')

@section('content')

    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Dashboard</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Dashboard</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">

            <!-- Small boxes (Stat box) -->

            {{-- USER DASHBOARD CARDS --}}
            <div class="row mb-4">

                {{-- TOTAL USERS --}}
                <div class="col-lg-3 col-6">

                    <div class="small-box bg-info">

                        <div class="inner">

                            <h3>{{ $totalUsers }}</h3>

                            <p>Total Users</p>

                        </div>

                        <div class="icon">
                            <i class="fas fa-users"></i>
                        </div>

                    </div>

                </div>

                {{-- ACTIVE USERS --}}
                <div class="col-lg-3 col-6">

                    <div class="small-box bg-success">

                        <div class="inner">

                            <h3>{{ $activeUsers }}</h3>

                            <p>Active Users</p>

                        </div>

                        <div class="icon">
                            <i class="fas fa-user-check"></i>
                        </div>

                    </div>

                </div>

                {{-- INACTIVE USERS --}}
                <div class="col-lg-3 col-6">

                    <div class="small-box bg-danger">

                        <div class="inner">

                            <h3>{{ $inactiveUsers }}</h3>

                            <p>Inactive Users</p>

                        </div>

                        <div class="icon">
                            <i class="fas fa-user-times"></i>
                        </div>

                    </div>

                </div>

                {{-- CUSTOMERS --}}
                <div class="col-lg-3 col-6">

                    <div class="small-box bg-warning">

                        <div class="inner">

                            <h3>{{ $customerUsers }}</h3>

                            <p>Customers</p>

                        </div>

                        <div class="icon">
                            <i class="fas fa-user-tag"></i>
                        </div>

                    </div>

                </div>

            </div>
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        Product Stock Summary
                    </h3>
                </div>

                {{-- SUMMARY CARDS --}}

                <div class="card-body">
                    <div class="row">

                        {{-- TOTAL PRODUCTS --}}
                        <div class="col-lg-3 col-6">

                            <div class="small-box bg-info">

                                <div class="inner">

                                    <h3>{{ $totalProducts }}</h3>

                                    <p>Total Inventory Products</p>

                                </div>

                                <div class="icon">
                                    <i class="fas fa-boxes"></i>
                                </div>

                            </div>

                        </div>

                        {{-- IN STOCK --}}
                        <div class="col-lg-3 col-6">

                            <div class="small-box bg-success">

                                <div class="inner">

                                    <h3>{{ $inStockProducts }}</h3>

                                    <p>In Stock</p>

                                </div>

                                <div class="icon">
                                    <i class="fas fa-check-circle"></i>
                                </div>

                            </div>

                        </div>

                        {{-- LOW STOCK --}}
                        <div class="col-lg-3 col-6">

                            <div class="small-box bg-warning">

                                <div class="inner">

                                    <h3>{{ $lowStockProducts }}</h3>

                                    <p>Low Stock</p>

                                </div>

                                <div class="icon">
                                    <i class="fas fa-exclamation-triangle"></i>
                                </div>

                            </div>

                        </div>

                        {{-- OUT OF STOCK --}}
                        <div class="col-lg-3 col-6">
                            <div class="small-box bg-danger">
                                <div class="inner">
                                    <h3>{{ $outOfStockProducts }}</h3>
                                    <p>Out Of Stock</p>
                                </div>
                                <div class="icon">
                                    <i class="fas fa-times-circle"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>



            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">

                        Product Quantity Summary
                    </h3>
                </div>
                <div class="card-body">
                    <div class="row mt-4">

                        {{-- TOTAL QUANTITY --}}
                        <div class="col-lg-4 col-md-6 mb-4">
                            <div class="quantity-card quantity-card-primary"
                                style="box-shadow: 1px 1px 1px 1px #2563eb !important ">
                                <div class="quantity-icon">
                                    <i class="fas fa-cubes"></i>
                                </div>
                                <div class="quantity-content">
                                    <h3>
                                        {{ $totalStockQuantity ?? 0 }}
                                    </h3>
                                    <p>
                                        Total Stock Quantity
                                    </p>
                                </div>
                            </div>

                        </div>

                        {{-- IN STOCK --}}
                        <div class="col-lg-4 col-md-6 mb-4">

                            <div class="quantity-card quantity-card-success"
                                style="box-shadow: 1px 1px 1px 1px #059669 !important ">

                                <div class="quantity-icon">
                                    <i class="fas fa-layer-group"></i>
                                </div>

                                <div class="quantity-content">

                                    <h3>
                                        {{ $inStockQuantity ?? 0 }}
                                    </h3>

                                    <p>
                                        Available Stock Quantity
                                    </p>

                                </div>

                            </div>

                        </div>

                        {{-- LOW STOCK --}}
                        <div class="col-lg-4 col-md-6 mb-4">

                            <div class="quantity-card quantity-card-warning"
                                style="box-shadow: 1px 1px 1px 1px #d97706 !important ">

                                <div class="quantity-icon">
                                    <i class="fas fa-exclamation"></i>
                                </div>

                                <div class="quantity-content">

                                    <h3>
                                        {{ $lowStockQuantity ?? 0 }}
                                    </h3>

                                    <p>
                                        Low Stock Quantity
                                    </p>

                                </div>

                            </div>

                        </div>

                    </div>
                </div>
            </div>

            <!-- /.row (main row) -->

        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->

@endsection


@push('css')

    <link rel="stylesheet" href="{{ asset('admin/custom/dashboard.css') }}">

@endpush