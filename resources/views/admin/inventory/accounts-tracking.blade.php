@extends('admin.layouts.app')

@section('content')

<section class="content-header">

    <div class="container-fluid">

        <div class="row mb-2">

            <div class="col-sm-6">
                <h1>Accounts Tracking</h1>
            </div>

        </div>

    </div>

</section>

<section class="content">

    <div class="container-fluid">

        <div class="card">

            <div class="card-header">

                <h3 class="card-title">
                    Accounts Tracking
                </h3>

            </div>

            <div class="card-body table-responsive p-0">

                <table class="table table-hover text-nowrap">

                    <thead>

                        <tr>

                            <th>Product ID</th>
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
                            $product->package_price
                            ?? $product->regular_price
                            ?? 0
                        );

                        $discountPrice = (float) ($product->discount_value ?? 0);

                        $stockQty = (int) ($product->stock_quantity ?? 0);

                        $profit = $salePrice - $purchasePrice;

                        $loss = $purchasePrice > $salePrice
                            ? $purchasePrice - $salePrice
                            : 0;

                    @endphp

                    <tr>

                        <td>#PRD-{{ $product->id }}</td>

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

</section>

@endsection