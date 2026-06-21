@extends('admin.layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
<style>
    .dash-card {
        background: #fff;
        border-radius: 14px;
        box-shadow: 0 2px 14px rgba(13,59,102,.09);
        border: none;
        padding: 22px 20px;
        display: flex;
        align-items: center;
        gap: 18px;
        transition: transform .2s, box-shadow .2s;
        height: 100%;
    }
    .dash-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 8px 28px rgba(13,59,102,.16);
    }
    .dash-icon {
        width: 58px; height: 58px;
        border-radius: 14px;
        display: flex; align-items: center; justify-content: center;
        font-size: 1.6rem; color: #fff; flex-shrink: 0;
    }
    .dash-icon.navy   { background: linear-gradient(135deg, #0d3b66, #1a5276); }
    .dash-icon.red    { background: linear-gradient(135deg, #c54836, #e05a44); }
    .dash-icon.amber  { background: linear-gradient(135deg, #d97706, #f59e0b); }
    .dash-icon.slate  { background: linear-gradient(135deg, #374151, #6b7280); }
    .dash-num  { font-size: 2rem; font-weight: 800; color: #0d3b66; line-height: 1; }
    .dash-lbl  { font-size: 0.8rem; color: #6b7280; margin-top: 4px; text-transform: uppercase; letter-spacing: .5px; }
    .dash-section { font-size: 1rem; font-weight: 700; color: #0d3b66; padding: 18px 20px 10px; border-bottom: 2px solid #f0f4f8; margin-bottom: 20px; }
    .dash-wrap { background: #fff; border-radius: 14px; box-shadow: 0 2px 14px rgba(13,59,102,.08); margin-bottom: 24px; overflow: hidden; }
    .dash-row  { display: grid; gap: 16px; padding: 0 20px 20px; }
    .dash-row.cols-4 { grid-template-columns: repeat(4, 1fr); }
    .dash-row.cols-3 { grid-template-columns: repeat(3, 1fr); }
    @media (max-width: 991px) {
        .dash-row.cols-4 { grid-template-columns: repeat(2, 1fr); }
        .dash-row.cols-3 { grid-template-columns: repeat(2, 1fr); }
    }
    @media (max-width: 575px) {
        .dash-row.cols-4, .dash-row.cols-3 { grid-template-columns: 1fr 1fr; }
    }
    .dash-icon.blue { background: linear-gradient(135deg, #0d3b66, #1d6fa4); }
    .dash-card:has(.dash-icon.navy)  { background: linear-gradient(135deg, #e8f0f8, #dce8f4); }
    .dash-card:has(.dash-icon.blue)  { background: linear-gradient(135deg, #ddeefa, #d0e8f8); }
    .dash-card:has(.dash-icon.red)   { background: linear-gradient(135deg, #fce8e6, #fbd8d5); }
    .dash-card:has(.dash-icon.amber) { background: linear-gradient(135deg, #fef3dc, #fdecd0); }
</style>

    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Dashboard</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Dashboard</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">

            {{-- Product Stock Summary --}}
            <div class="dash-wrap">
                <div class="dash-section"><i class="fas fa-boxes mr-2" style="color:#c54836;"></i>Product Stock Summary</div>
                <div class="dash-row cols-4">
                    <div class="dash-card">
                        <div class="dash-icon navy"><i class="fas fa-boxes"></i></div>
                        <div>
                            <div class="dash-num">{{ $totalProducts }}</div>
                            <div class="dash-lbl">Total Products</div>
                        </div>
                    </div>
                    <div class="dash-card">
                        <div class="dash-icon blue"><i class="fas fa-check-circle"></i></div>
                        <div>
                            <div class="dash-num">{{ $inStockProducts }}</div>
                            <div class="dash-lbl">In Stock</div>
                        </div>
                    </div>
                    <div class="dash-card">
                        <div class="dash-icon amber"><i class="fas fa-exclamation-triangle"></i></div>
                        <div>
                            <div class="dash-num">{{ $lowStockProducts }}</div>
                            <div class="dash-lbl">Low Stock</div>
                        </div>
                    </div>
                    <div class="dash-card">
                        <div class="dash-icon red"><i class="fas fa-times-circle"></i></div>
                        <div>
                            <div class="dash-num">{{ $outOfStockProducts }}</div>
                            <div class="dash-lbl">Out of Stock</div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Product Quantity Summary --}}
            <div class="dash-wrap">
                <div class="dash-section"><i class="fas fa-cubes mr-2" style="color:#c54836;"></i>Product Quantity Summary</div>
                <div class="dash-row cols-3">
                    <div class="dash-card">
                        <div class="dash-icon navy"><i class="fas fa-cubes"></i></div>
                        <div>
                            <div class="dash-num">{{ $totalStockQuantity ?? 0 }}</div>
                            <div class="dash-lbl">Total Stock Qty</div>
                        </div>
                    </div>
                    <div class="dash-card">
                        <div class="dash-icon blue"><i class="fas fa-layer-group"></i></div>
                        <div>
                            <div class="dash-num">{{ $inStockQuantity ?? 0 }}</div>
                            <div class="dash-lbl">Available Qty</div>
                        </div>
                    </div>
                    <div class="dash-card">
                        <div class="dash-icon amber"><i class="fas fa-exclamation"></i></div>
                        <div>
                            <div class="dash-num">{{ $lowStockQuantity ?? 0 }}</div>
                            <div class="dash-lbl">Low Stock Qty</div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Users Summary --}}
            <div class="dash-wrap">
                <div class="dash-section"><i class="fas fa-users mr-2" style="color:#c54836;"></i>Users Summary</div>
                <div class="dash-row cols-4">
                    <div class="dash-card">
                        <div class="dash-icon navy"><i class="fas fa-users"></i></div>
                        <div>
                            <div class="dash-num">{{ $totalUsers }}</div>
                            <div class="dash-lbl">Total Users</div>
                        </div>
                    </div>
                    <div class="dash-card">
                        <div class="dash-icon blue"><i class="fas fa-user-check"></i></div>
                        <div>
                            <div class="dash-num">{{ $activeUsers }}</div>
                            <div class="dash-lbl">Active Users</div>
                        </div>
                    </div>
                    <div class="dash-card">
                        <div class="dash-icon red"><i class="fas fa-user-times"></i></div>
                        <div>
                            <div class="dash-num">{{ $inactiveUsers }}</div>
                            <div class="dash-lbl">Inactive Users</div>
                        </div>
                    </div>
                    <div class="dash-card">
                        <div class="dash-icon amber"><i class="fas fa-user-tag"></i></div>
                        <div>
                            <div class="dash-num">{{ $customerUsers }}</div>
                            <div class="dash-lbl">Customers</div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>

@endsection
