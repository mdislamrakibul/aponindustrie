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
        {{-- INVENTORY UPDATE --}}
        <div class="card">

            <div class="card-header">
                <h3 class="card-title">
                    Inventory Update
                </h3>
            </div>

            <div class="card-body">

                <form action="{{ route('inventory.update') }}"
                    method="POST">

                    @csrf

                    <div class="row">

                        <div class="col-md-3">

                            <div class="form-group">

                                <label>Product</label>

                                <select name="product_id"
                                        class="form-control"
                                        required>

                                    <option value="">
                                        Select Product
                                    </option>

                                    @foreach($products as $product)

                                        <option value="{{ $product->id }}">
                                            {{ $product->name }}
                                        </option>

                                    @endforeach

                                </select>

                            </div>
                        </div>


                        <div class="col-md-3">

                            <div class="form-group">

                                <label>Quantity</label>

                                <input type="number"
                                    name="stock_quantity"
                                    class="form-control"
                                    >

                            </div>

                        </div>


                        <div class="col-md-3">

                            <div class="form-group">

                                <label>Purchase Price</label>

                                <input type="number"
                                    step="0.01"
                                    name="purchase_price"
                                    class="form-control"
                                    >

                            </div>

                        </div>
                        <div class="col-md-3">

                            <div class="form-group">

                                <label>Selling Price</label>

                                <input type="number"
                                    step="0.01"
                                    name="regular_price"
                                    class="form-control"
                                    >

                            </div>

                        </div>
                        @if(session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif

                    </div>


                    <button type="submit"
                            class="btn btn-primary">

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

                            <td>
                                {{ $product->name }}
                            </td>

                            <td>
                                {{ $product->category->name ?? 'N/A' }}
                            </td>

                            <td>
                                {{ $product->stock_quantity }}
                            </td>

                            <td>
                                ৳ {{ number_format($product->purchase_price, 2) }}
                            </td>

                            <td>
                                ৳ {{ number_format($product->regular_price, 2) }}
                            </td>

                            <td>

                                @if($product->stock_quantity == 0)

                                    <span class="badge bg-danger">
                                        Out of Stock
                                    </span>

                                @elseif($product->stock_quantity >= 1 && $product->stock_quantity <= 99)

                                    <span class="badge bg-warning text-dark">
                                        Low Stock
                                    </span>

                                @else

                                    <span class="badge bg-success">
                                        In Stock
                                    </span>

                                @endif

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td colspan="6" class="text-center">
                                No inventory products found.
                            </td>

                        </tr>

                    @endforelse

                    </tbody>

                </table>
                <div class="card-footer clearfix">
                    {{ $products->links() }}
                </div>

            </div>



        </div>

    </div>

</section>

@endsection