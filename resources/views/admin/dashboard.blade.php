@extends('admin.layouts.app')

@section('title', 'Admin Dashboard')

@section('content')

<div class="content-header py-3">
    <div class="container-fluid">

        {{-- Dashboard Header --}}
        <div class="row mb-4">
            <div class="col-12">

                <div class="card shadow-sm border-0">
                    <div class="card-body py-3 px-4">

                        <h1 class="m-0 fw-bold">
                            Dashboard
                        </h1>

                    </div>
                </div>

            </div>
        </div>
      
        {{-- USER ANALYTICS --}}
        <div class="dashboard-section">

            <div class="section-header mb-4">

                <div>
                    <h4 class="section-title">
                        User Analytics
                    </h4>

                    <p class="section-subtitle">
                        System users overview and role statistics
                    </p>
                </div>

            </div>

            <div class="row">

                {{-- TOTAL USERS --}}
                <div class="col-lg-3 col-md-6 mb-4">

                    <div class="modern-card modern-card-blue">

                        <div class="modern-card-body">

                            <div>
                                <span class="card-label">
                                    Total Users
                                </span>

                                <h2>
                                    {{ $totalUsers }}
                                </h2>
                            </div>

                            <div class="modern-icon">
                                <i class="fas fa-users"></i>
                            </div>

                        </div>

                    </div>

                </div>

                {{-- ADMINS --}}
                <div class="col-lg-3 col-md-6 mb-4">

                    <div class="modern-card modern-card-dark">

                        <div class="modern-card-body">

                            <div>
                                <span class="card-label">
                                    Admins
                                </span>

                                <h2>
                                    {{ $totalAdmins }}
                                </h2>
                            </div>

                            <div class="modern-icon">
                                <i class="fas fa-user-shield"></i>
                            </div>

                        </div>

                    </div>

                </div>

                {{-- VENDORS --}}
                <div class="col-lg-3 col-md-6 mb-4">

                    <div class="modern-card modern-card-orange">

                        <div class="modern-card-body">

                            <div>
                                <span class="card-label">
                                    Vendors
                                </span>

                                <h2>
                                    {{ $totalVendors }}
                                </h2>
                            </div>

                            <div class="modern-icon">
                                <i class="fas fa-store"></i>
                            </div>

                        </div>

                    </div>

                </div>

                {{-- CUSTOMERS --}}
                <div class="col-lg-3 col-md-6 mb-4">

                    <div class="modern-card modern-card-purple">

                        <div class="modern-card-body">

                            <div>
                                <span class="card-label">
                                    Customers
                                </span>

                                <h2>
                                    {{ $totalCustomers }}
                                </h2>
                            </div>

                            <div class="modern-icon">
                                <i class="fas fa-user-tag"></i>
                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>

        {{-- PRODUCT STOCK ANALYTICS --}}
        <div class="dashboard-section mt-2">

            <div class="section-header mb-4">

                <div>
                    <h4 class="section-title">
                        Product By Catagory Stock Analytics
                    </h4>

                    <p class="section-subtitle">
                        Product availability and stock monitoring
                    </p>
                </div>

            </div>

            <div class="row">

                <div class="col-lg-3 col-md-6 mb-4">

                    <div class="modern-card modern-card-cyan">

                        <div class="modern-card-body">

                            <div>
                                <span class="card-label">
                                    Total Catagory
                                </span>

                                <h2>{{ $totalProducts }}</h2>
                            </div>

                            <div class="modern-icon">
                                <i class="fas fa-boxes"></i>
                            </div>

                        </div>

                    </div>

                </div>

                <div class="col-lg-3 col-md-6 mb-4">

                    <div class="modern-card modern-card-green">

                        <div class="modern-card-body">

                            <div>
                                <span class="card-label">
                                    In Stock
                                </span>

                                <h2>{{ $inStockProducts }}</h2>
                            </div>

                            <div class="modern-icon">
                                <i class="fas fa-check-circle"></i>
                            </div>

                        </div>

                    </div>

                </div>

                <div class="col-lg-3 col-md-6 mb-4">

                    <div class="modern-card modern-card-yellow">

                        <div class="modern-card-body">

                            <div>
                                <span class="card-label">
                                    Low Stock
                                </span>

                                <h2>{{ $lowStockProducts }}</h2>
                            </div>

                            <div class="modern-icon">
                                <i class="fas fa-exclamation-triangle"></i>
                            </div>

                        </div>

                    </div>

                </div>

                <div class="col-lg-3 col-md-6 mb-4">

                    <div class="modern-card modern-card-red">

                        <div class="modern-card-body">

                            <div>
                                <span class="card-label">
                                    Out Of Stock
                                </span>

                                <h2>{{ $outOfStockProducts }}</h2>
                            </div>

                            <div class="modern-icon">
                                <i class="fas fa-times-circle"></i>
                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>

        {{-- PRODUCT QUANTITY SUMMARY --}}
        <div class="dashboard-section mt-2">

            <div class="section-header mb-4">

                <div>
                    <h4 class="section-title">
                        Product Quantity Summary
                    </h4>

                    <p class="section-subtitle">
                        Product quantity overview and stock distribution
                    </p>
                </div>

            </div>

            <div class="row">

                {{-- TOTAL QUANTITY --}}
                <div class="col-lg-4 col-md-6 mb-4">

                    <div class="quantity-summary-card quantity-dark">

                        <div class="quantity-card-content">

                            <div>
                                <span class="quantity-label">
                                    Total Stock Quantity
                                </span>

                                <h2>
                                    {{ $totalStockQuantity }}
                                </h2>
                            </div>

                            <div class="quantity-icon">
                                <i class="fas fa-cubes"></i>
                            </div>

                        </div>

                    </div>

                </div>

                {{-- IN STOCK QUANTITY --}}
                <div class="col-lg-4 col-md-6 mb-4">

                    <div class="quantity-summary-card quantity-success">

                        <div class="quantity-card-content">

                            <div>
                                <span class="quantity-label">
                                    In Stock Quantity
                                </span>

                                <h2>
                                    {{ $inStockQuantity }}
                                </h2>
                            </div>

                            <div class="quantity-icon">
                                <i class="fas fa-layer-group"></i>
                            </div>

                        </div>

                    </div>

                </div>

                {{-- LOW STOCK QUANTITY --}}
                <div class="col-lg-4 col-md-6 mb-4">

                    <div class="quantity-summary-card quantity-warning">

                        <div class="quantity-card-content">

                            <div>
                                <span class="quantity-label">
                                    Low Stock Quantity
                                </span>

                                <h2>
                                    {{ $lowStockQuantity }}
                                </h2>
                            </div>

                            <div class="quantity-icon">
                                <i class="fas fa-chart-line"></i>
                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>
{{--
        <div class="row">
            <div class="col-lg-6">
              <div class="card">
                <div class="card-header border-0">
                  <div class="d-flex justify-content-between">
                    <h3 class="card-title">Online Store Visitors</h3>
                    <a href="javascript:void(0);">View Report</a>
                  </div>
                </div>
                <div class="card-body">
                  <div class="d-flex">
                    <p class="d-flex flex-column">
                      <span class="text-bold text-lg">820</span>
                      <span>Visitors Over Time</span>
                    </p>
                    <p class="ml-auto d-flex flex-column text-right">
                      <span class="text-success">
                        <i class="fas fa-arrow-up"></i> 12.5%
                      </span>
                      <span class="text-muted">Since last week</span>
                    </p>
                  </div>
                  <!-- /.d-flex -->

                  <div class="position-relative mb-4">
                    <canvas id="visitors-chart" height="200"></canvas>
                  </div>

                  <div class="d-flex flex-row justify-content-end">
                    <span class="mr-2">
                      <i class="fas fa-square text-primary"></i> This Week
                    </span>

                    <span>
                      <i class="fas fa-square text-gray"></i> Last Week
                    </span>
                  </div>
                </div>
              </div>
              <!-- /.card -->

              <div class="card">
                <div class="card-header border-0">
                  <h3 class="card-title">Products</h3>
                  <div class="card-tools">
                    <a href="#" class="btn btn-tool btn-sm">
                      <i class="fas fa-download"></i>
                    </a>
                    <a href="#" class="btn btn-tool btn-sm">
                      <i class="fas fa-bars"></i>
                    </a>
                  </div>
                </div>
                <div class="card-body table-responsive p-0">
                  <table class="table table-striped table-valign-middle">
                    <thead>
                    <tr>
                      <th>Product</th>
                      <th>Price</th>
                      <th>Sales</th>
                      <th>More</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                      <td>
                        <img src="dist/img/default-150x150.png" alt="Product 1" class="img-circle img-size-32 mr-2">
                        Some Product
                      </td>
                      <td>$13 USD</td>
                      <td>
                        <small class="text-success mr-1">
                          <i class="fas fa-arrow-up"></i>
                          12%
                        </small>
                        12,000 Sold
                      </td>
                      <td>
                        <a href="#" class="text-muted">
                          <i class="fas fa-search"></i>
                        </a>
                      </td>
                    </tr>
                    <tr>
                      <td>
                        <img src="dist/img/default-150x150.png" alt="Product 1" class="img-circle img-size-32 mr-2">
                        Another Product
                      </td>
                      <td>$29 USD</td>
                      <td>
                        <small class="text-warning mr-1">
                          <i class="fas fa-arrow-down"></i>
                          0.5%
                        </small>
                        123,234 Sold
                      </td>
                      <td>
                        <a href="#" class="text-muted">
                          <i class="fas fa-search"></i>
                        </a>
                      </td>
                    </tr>
                    <tr>
                      <td>
                        <img src="dist/img/default-150x150.png" alt="Product 1" class="img-circle img-size-32 mr-2">
                        Amazing Product
                      </td>
                      <td>$1,230 USD</td>
                      <td>
                        <small class="text-danger mr-1">
                          <i class="fas fa-arrow-down"></i>
                          3%
                        </small>
                        198 Sold
                      </td>
                      <td>
                        <a href="#" class="text-muted">
                          <i class="fas fa-search"></i>
                        </a>
                      </td>
                    </tr>
                    <tr>
                      <td>
                        <img src="dist/img/default-150x150.png" alt="Product 1" class="img-circle img-size-32 mr-2">
                        Perfect Item
                        <span class="badge bg-danger">NEW</span>
                      </td>
                      <td>$199 USD</td>
                      <td>
                        <small class="text-success mr-1">
                          <i class="fas fa-arrow-up"></i>
                          63%
                        </small>
                        87 Sold
                      </td>
                      <td>
                        <a href="#" class="text-muted">
                          <i class="fas fa-search"></i>
                        </a>
                      </td>
                    </tr>
                    </tbody>
                  </table>
                </div>
              </div>
              <!-- /.card -->
            </div>
            <!-- /.col-md-6 -->
            <div class="col-lg-6">
              <div class="card">
                <div class="card-header border-0">
                  <div class="d-flex justify-content-between">
                    <h3 class="card-title">Sales</h3>
                    <a href="javascript:void(0);">View Report</a>
                  </div>
                </div>
                <div class="card-body">
                  <div class="d-flex">
                    <p class="d-flex flex-column">
                      <span class="text-bold text-lg">$18,230.00</span>
                      <span>Sales Over Time</span>
                    </p>
                    <p class="ml-auto d-flex flex-column text-right">
                      <span class="text-success">
                        <i class="fas fa-arrow-up"></i> 33.1%
                      </span>
                      <span class="text-muted">Since last month</span>
                    </p>
                  </div>
                  <!-- /.d-flex -->

                  <div class="position-relative mb-4">
                    <canvas id="sales-chart" height="200"></canvas>
                  </div>

                  <div class="d-flex flex-row justify-content-end">
                    <span class="mr-2">
                      <i class="fas fa-square text-primary"></i> This year
                    </span>

                    <span>
                      <i class="fas fa-square text-gray"></i> Last year
                    </span>
                  </div>
                </div>
              </div>
              <!-- /.card -->

              <div class="card">
                <div class="card-header border-0">
                  <h3 class="card-title">Online Store Overview</h3>
                  <div class="card-tools">
                    <a href="#" class="btn btn-sm btn-tool">
                      <i class="fas fa-download"></i>
                    </a>
                    <a href="#" class="btn btn-sm btn-tool">
                      <i class="fas fa-bars"></i>
                    </a>
                  </div>
                </div>
                <div class="card-body">
                  <div class="d-flex justify-content-between align-items-center border-bottom mb-3">
                    <p class="text-success text-xl">
                      <i class="ion ion-ios-refresh-empty"></i>
                    </p>
                    <p class="d-flex flex-column text-right">
                      <span class="font-weight-bold">
                        <i class="ion ion-android-arrow-up text-success"></i> 12%
                      </span>
                      <span class="text-muted">CONVERSION RATE</span>
                    </p>
                  </div>
                  <!-- /.d-flex -->
                  <div class="d-flex justify-content-between align-items-center border-bottom mb-3">
                    <p class="text-warning text-xl">
                      <i class="ion ion-ios-cart-outline"></i>
                    </p>
                    <p class="d-flex flex-column text-right">
                      <span class="font-weight-bold">
                        <i class="ion ion-android-arrow-up text-warning"></i> 0.8%
                      </span>
                      <span class="text-muted">SALES RATE</span>
                    </p>
                  </div>
                  <!-- /.d-flex -->
                  <div class="d-flex justify-content-between align-items-center mb-0">
                    <p class="text-danger text-xl">
                      <i class="ion ion-ios-people-outline"></i>
                    </p>
                    <p class="d-flex flex-column text-right">
                      <span class="font-weight-bold">
                        <i class="ion ion-android-arrow-down text-danger"></i> 1%
                      </span>
                      <span class="text-muted">REGISTRATION RATE</span>
                    </p>
                  </div>
                  <!-- /.d-flex -->
                </div>
              </div>
            </div>
            <!-- /.col-md-6 -->
        </div>
--}}
        
    </div>
    
  </div>

  <div class="content">
    <div class="container-fluid">

        

    </div>
  </div>

  @endsection


@push('css')

<style>

.dashboard-section{
    margin-bottom: 35px;
}

.section-title{
    font-size: 24px;
    font-weight: 700;
    color: #111827;
    margin-bottom: 4px;
}

.section-subtitle{
    color: #6b7280;
    margin: 0;
    font-size: 14px;
}

.modern-card{
    border-radius: 22px;
    overflow: hidden;
    padding: 26px;
    position: relative;
    transition: all .3s ease;
    box-shadow: 0 10px 25px rgba(0,0,0,.08);
}

.modern-card:hover{
    transform: translateY(-6px);
}

.modern-card-body{
    display:flex;
    justify-content:space-between;
    align-items:center;
}

.card-label{
    font-size: 14px;
    font-weight: 500;
    opacity: .9;
    display:block;
    margin-bottom: 10px;
    color:#fff;
}

.modern-card h2{
    font-size: 34px;
    font-weight: 800;
    color:#fff;
    margin:0;
}

.modern-icon{
    width:70px;
    height:70px;
    border-radius:20px;
    background:rgba(255,255,255,.15);
    display:flex;
    align-items:center;
    justify-content:center;
}

.modern-icon i{
    color:#fff;
    font-size:28px;
}

/* COLORS */

.modern-card-blue{
    background: linear-gradient(135deg,#2563eb,#1d4ed8);
}

.modern-card-dark{
    background: linear-gradient(135deg,#111827,#1f2937);
}

.modern-card-orange{
    background: linear-gradient(135deg,#f97316,#ea580c);
}

.modern-card-purple{
    background: linear-gradient(135deg,#7c3aed,#6d28d9);
}

.modern-card-cyan{
    background: linear-gradient(135deg,#06b6d4,#0891b2);
}

.modern-card-green{
    background: linear-gradient(135deg,#10b981,#059669);
}

.modern-card-yellow{
    background: linear-gradient(135deg,#f59e0b,#d97706);
}

.modern-card-red{
    background: linear-gradient(135deg,#ef4444,#dc2626);
}


/* PRODUCT QUANTITY SUMMARY */

.quantity-summary-card{
    border-radius: 22px;
    padding: 28px;
    position: relative;
    overflow: hidden;
    transition: all .3s ease;
    box-shadow: 0 10px 30px rgba(0,0,0,.08);
    background: #fff;
    border: 1px solid rgba(255,255,255,.08);
}

.quantity-summary-card:hover{
    transform: translateY(-6px);
}

.quantity-card-content{
    display:flex;
    align-items:center;
    justify-content:space-between;
}

.quantity-label{
    display:block;
    font-size:14px;
    font-weight:600;
    margin-bottom:10px;
    color:rgba(255,255,255,.85);
    letter-spacing:.3px;
}

.quantity-summary-card h2{
    margin:0;
    font-size:34px;
    font-weight:800;
    color:#fff;
}

.quantity-icon{
    width:72px;
    height:72px;
    border-radius:22px;
    display:flex;
    align-items:center;
    justify-content:center;
    background:rgba(255,255,255,.12);
    backdrop-filter: blur(6px);
}

.quantity-icon i{
    font-size:28px;
    color:#fff;
}

/* CARD COLORS */

.quantity-dark{
    background: linear-gradient(135deg,#111827,#374151);
}

.quantity-success{
    background: linear-gradient(135deg,#059669,#10b981);
}

.quantity-warning{
    background: linear-gradient(135deg,#d97706,#f59e0b);
}
</style>

@endpush
