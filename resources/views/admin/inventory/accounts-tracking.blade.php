@extends('admin.layouts.app')


@section('title', 'Accounts Tracking')


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
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard.index') }}">Home</a></li>
                    <li class="breadcrumb-item active">Accounts Tracking</li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->


<section class="content">
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    Accounts Tracking
                </h3>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover text-nowrap" id="dataTable">
                        <thead>
                            <tr>
                                <th>SL.</th>
                                <th>Product Name</th>
                                <th>Stock Quantity</th>
                                <th>Purchase Price</th>
                                <th>Package Price (Regular Price)</th>
                                <th>Package Price (Final Sale Price)</th>
                                <th>Sell Price</th>
                                <th>Discount Price</th>
                                <th>Profit</th>
                                <th>Loss</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($products as $product)
                            @php
                            // Purchase Price = "Purchase Package Price" (Purchase Per Piece ×
                            // Minimum Order), auto-calculated on the Inventory Update form.
                            $purchasePrice = (float) ($product->purchase_price ?? 0);
                            // "Sell Price" is what the admin actually enters as the
                            // per-piece selling price on the Inventory form — that's
                            // sale_price, not regular_price.
                            $salePrice = (float) ($product->sale_price ?? 0);
                            $regularPrice = (float) ($product->regular_price ?? 0);
                            // Package Price is now saved as the ACTUAL final selling price
                            // (Regular Price minus the configured discount already applied),
                            // so it directly reflects what a customer actually pays.
                            $packagePrice = (float) ($product->package_price ?? 0);
                            $discountType = $product->discount_type ?? 'NONE';
                            $discountValue = (float) ($product->discount_value ?? 0);
                            $stockQty = (int) ($product->stock_quantity ?? 0);

                            // Profit/Loss = Package Price (final selling price) − Purchase
                            // Package Price (final purchase cost). Positive → profit;
                            // negative (cost more than the selling price) → loss.
                            $net = $packagePrice - $purchasePrice;
                            $profit = $net > 0 ? $net : 0;
                            $loss = $net < 0 ? abs($net) : 0;
                            @endphp
                            <tr>
                                <td>{{ $loop->iteration }}.</td>
                                <td>{{ $product->name }}</td>
                                <td>{{ $stockQty }}</td>
                                <td>
                                    ৳{{ number_format($purchasePrice, 2) }}
                                </td>
                                <td>
                                    ৳{{ number_format($regularPrice, 2) }}
                                </td>
                                <td>
                                    ৳{{ number_format($packagePrice, 2) }}
                                </td>
                                <td>
                                    ৳{{ number_format($salePrice, 2) }}
                                </td>
                                <td>
                                    @if($discountValue > 0 && $discountType === 'PERCENTAGE')
                                    {{ number_format($discountValue, 2) }}%
                                    @elseif($discountValue > 0 && $discountType === 'FLAT')
                                    ৳{{ number_format($discountValue, 2) }}
                                    @else
                                    N/A
                                    @endif
                                </td>
                                <td>
                                    @if($profit > 0)
                                    <span class="badge bg-success">
                                        +৳{{ number_format($profit, 2) }}
                                    </span>
                                    @else
                                    <span class="badge bg-secondary">
                                        ৳0
                                    </span>
                                    @endif
                                </td>
                                <td>
                                    @if($loss > 0)
                                    <span class="badge bg-danger">
                                        -৳{{ number_format($loss, 2) }}
                                    </span>

                                    @else
                                    <span class="badge bg-success">
                                        ৳0
                                    </span>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="10" class="text-center">
                                    No accounts tracking data found
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
