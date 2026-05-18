@extends('admin.layouts.app')

@section('content')

<section class="content-header">

    <div class="container-fluid">

        <div class="row mb-2">

            <div class="col-sm-6">
                <h1>Inventory Management</h1>
            </div>

        </div>

    </div>

</section>

<section class="content">

    <div class="container-fluid">

        {{-- SUMMARY CARDS --}}
        <div class="row">

            <div class="col-lg-3 col-6">

                <div class="small-box bg-info">

                    <div class="inner">
                        <h3>1250</h3>
                        <p>Total Inventory</p>
                    </div>

                    <div class="icon">
                        <i class="fas fa-boxes"></i>
                    </div>

                </div>

            </div>

            <div class="col-lg-3 col-6">

                <div class="small-box bg-success">

                    <div class="inner">
                        <h3>25</h3>
                        <p>Total Categories</p>
                    </div>

                    <div class="icon">
                        <i class="fas fa-tags"></i>
                    </div>

                </div>

            </div>

            <div class="col-lg-3 col-6">

                <div class="small-box bg-warning">

                    <div class="inner">
                        <h3>$52K</h3>
                        <p>Total Stock Value</p>
                    </div>

                    <div class="icon">
                        <i class="fas fa-dollar-sign"></i>
                    </div>

                </div>

            </div>

            <div class="col-lg-3 col-6">

                <div class="small-box bg-danger">

                    <div class="inner">
                        <h3>12</h3>
                        <p>Low Stock</p>
                    </div>

                    <div class="icon">
                        <i class="fas fa-exclamation-triangle"></i>
                    </div>

                </div>

            </div>

        </div>

        {{-- INVENTORY UPDATE --}}
        <div class="card">

            <div class="card-header">
                <h3 class="card-title">
                    Inventory Update
                </h3>
            </div>

            <div class="card-body">

                <form>

                    <div class="row">

                        <div class="col-md-3">

                            <div class="form-group">

                                <label>Product Name</label>

                                <input type="text"
                                       class="form-control"
                                       placeholder="Product Name">

                            </div>

                        </div>

                        <div class="col-md-3">

                            <div class="form-group">

                                <label>Quantity</label>

                                <input type="number"
                                       class="form-control"
                                       placeholder="Quantity">

                            </div>

                        </div>

                        <div class="col-md-3">

                            <div class="form-group">

                                <label>Purchase Price</label>

                                <input type="text"
                                       class="form-control"
                                       placeholder="Purchase Price">

                            </div>

                        </div>

                        <div class="col-md-3">

                            <div class="form-group">

                                <label>Selling Price</label>

                                <input type="text"
                                       class="form-control"
                                       placeholder="Selling Price">

                            </div>

                        </div>

                    </div>

                    <button class="btn btn-primary">
                        Save Inventory
                    </button>

                </form>

            </div>

        </div>

        {{-- INVENTORY LIST --}}
        <div class="card">

            <div class="card-header">

                <h3 class="card-title">
                    Inventory List
                </h3>

                <div class="card-tools">

                    <form action="{{ route('inventory.list') }}"
                          method="GET">

                        <div class="input-group input-group-sm"
                             style="width: 250px;">

                            <input type="text"
                                   name="search"
                                   value="{{ request('search') }}"
                                   class="form-control float-right"
                                   placeholder="Search by ID, Name, Category">

                            <div class="input-group-append">

                                <button type="submit"
                                        class="btn btn-default">

                                    <i class="fas fa-search"></i>

                                </button>

                            </div>

                        </div>

                    </form>

                </div>

            </div>

            <div class="card-body table-responsive p-0">

                <table class="table table-hover text-nowrap">

                    <thead>

                        <tr>
                            <th>Product</th>
                            <th>Category</th>
                            <th>Stock</th>
                            <th>Purchase Price</th>
                            <th>Selling Price</th>
                            <th>Status</th>
                        </tr>

                    </thead>

                    <tbody>

                    @forelse($products as $product)

                    <tr>

                        <td>{{ $product->name }}</td>

                        <td>
                            {{ $product->category_name ?? 'N/A' }}
                        </td>

                        <td>
                            {{ $product->stock_quantity ?? 0 }}
                        </td>

                        <td>
                            ${{ $product->purchase_price ?? 0 }}
                        </td>

                        <td>
                            ${{ $product->sale_price ?? $product->regular_price }}
                        </td>

                        <td>

                            @if($product->availability === 'INSTOCK')

                                <span class="badge bg-success">
                                    In Stock
                                </span>

                            @elseif($product->availability === 'OUTOFSTOCK')

                                <span class="badge bg-danger">
                                    Out of Stock
                                </span>

                            @else

                                <span class="badge bg-warning">
                                    Pre Order
                                </span>

                            @endif

                        </td>

                    </tr>

                    @empty

                    <tr>

                        <td colspan="6" class="text-center">

                            No inventory data found

                        </td>

                    </tr>

                    @endforelse

                    </tbody>

                </table>

            </div>

            <div class="card-footer clearfix">

                {{ $products->links() }}

            </div>

        </div>

    </div>

</section>

@endsection