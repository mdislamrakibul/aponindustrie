@extends('admin.layouts.app')

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
                                <th>Sell Price</th>
                                <th>Discount Price</th>
                                <th>Profit</th>
                                <th>Loss</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($products as $product)
                            @php
                            $purchasePrice = (float) ($product->purchase_price ?? 0);
                            $salePrice = (float) (
                            $product->regular_price ?? 0
                            );
                            $discountPrice = (float) ($product->discount_value ?? 0);
                            $stockQty = (int) ($product->stock_quantity ?? 0);
                            $profit = $salePrice - $purchasePrice;
                            $loss = $purchasePrice > $salePrice
                            ? $purchasePrice - $salePrice
                            : 0;

                            @endphp
                            <tr>
                                <td>{{ $loop->iteration }}.</td>
                                <td>{{ $product->name }}</td>
                                <td>{{ $stockQty }}</td>
                                <td>
                                    ${{ number_format($purchasePrice, 2) }}
                                </td>
                                <td>
                                    ${{ number_format($salePrice, 2) }}
                                </td>
                                <td>
                                    @if($discountPrice > 0)
                                    ${{ number_format($discountPrice, 2) }}
                                    @else
                                    N/A
                                    @endif
                                </td>
                                <td>
                                    @if($profit > 0)
                                    <span class="badge bg-success">
                                        +${{ number_format($profit, 2) }}
                                    </span>
                                    @else
                                    <span class="badge bg-secondary">
                                        $0
                                    </span>
                                    @endif
                                </td>
                                <td>
                                    @if($loss > 0)
                                    <span class="badge bg-danger">
                                        -${{ number_format($loss, 2) }}
                                    </span>

                                    @else
                                    <span class="badge bg-success">
                                        $0
                                    </span>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="8" class="text-center">
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
