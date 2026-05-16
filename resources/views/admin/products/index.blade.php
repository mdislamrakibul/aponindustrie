@extends('admin.layouts.app')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-3">

    <h3>All Products</h3>

    <button
        type="button"
        class="btn btn-dark rounded-3 px-4"
        data-toggle="modal"
        data-target="#addProductModal"
    >
        <i class="fas fa-plus me-1"></i>
        Add Product
    </button>

</div>

<form method="GET" class="mb-3">

    <div class="row">

        <div class="col-md-4">

            <input
                type="text"
                name="search"
                class="form-control"
                placeholder="Search by Product ID or Name"
                value="{{ request('search') }}"
            >

        </div>

        <div class="col-md-3">

            <select
                name="category_id"
                class="form-control"
            >

                <option value="">
                    All Categories
                </option>

                @foreach($categories as $cat)

                    <option
                        value="{{ $cat->id }}"
                        {{ request('category_id') == $cat->id ? 'selected' : '' }}
                    >
                        {{ $cat->name }}
                    </option>

                @endforeach

            </select>

        </div>

        <div class="col-md-2">

            <button class="btn btn-primary w-100">

                Search

            </button>

        </div>

    </div>

</form>

<div class="card">

    <div class="card-body table-responsive p-0">

        <table class="table table-hover text-nowrap">

            <thead>

                <tr>

                    <th>ID</th>
                    <th>Image</th>
                    <th>Name</th>
                    <th>Category</th>
                    <th>Price</th>
                    <th>Stock</th>
                    <th>Status</th>
                    <th>Action</th>

                </tr>

            </thead>

            <tbody>

                @forelse($products as $product)

                <tr>

                    <td>{{ $product->id }}</td>

                    <td>

                        @php
                            $image = $product->media->first();
                        @endphp

                        <img
                            src="{{ $image ? asset($image->file_path . $image->image_name) : asset('admin/no-image.png') }}"
                            width="50"
                            height="50"
                            style="object-fit:cover;border-radius:6px;"
                        >

                    </td>

                    <td>{{ $product->name }}</td>

                    <td>{{ $product->category->name ?? 'N/A' }}</td>

                    <td>৳ {{ $product->regular_price }}</td>

                    <td>{{ $product->stock_quantity }}</td>

                    <td>
                        <span class="badge
                            {{ $product->status == 'PUBLISHED' ? 'bg-success' : '' }}
                            {{ $product->status == 'INACTIVE' ? 'bg-danger' : '' }}
                            {{ $product->status == 'PENDING' ? 'bg-warning text-dark' : '' }}
                            px-3 py-2
                        ">

                            {{ $product->status }}

                        </span>
                    </td>

                    <td>

                        <div class="d-flex align-items-center gap-2">

                            {{-- VIEW --}}
                            <a href="{{ route('admin.products.show', $product->id) }}"
                            class="action-btn"
                            title="View">

                                <i class="fas fa-eye"></i>

                            </a>

                            {{-- EDIT --}}
                            <a href="{{ route('admin.products.edit', $product->id) }}"
                            class="action-btn"
                            title="Edit">

                                <i class="fas fa-pen"></i>

                            </a>

                            {{-- STATUS TOGGLE --}}
                            <form action="{{ route('admin.products.toggle-status', $product->id) }}"
                                method="POST">

                                @csrf
                                @method('PATCH')

                                <button type="submit"
                                        class="action-btn border-0">

                                    @if($product->status == 'ACTIVE')

                                        <i class="fas fa-trash"></i>

                                    @else

                                        <i class="fas fa-undo"></i>

                                    @endif

                                </button>

                            </form>

                        </div>

                    </td>

                </tr>

                @empty

                <tr>

                    <td colspan="8" class="text-center">

                        No Products Found

                    </td>

                </tr>

                @endforelse

            </tbody>

        </table>

    </div>

</div>

<div class="mt-3 d-flex justify-content-center pagination-sm-wrapper">

    {{ $products->onEachSide(1)->links('pagination::bootstrap-4') }}

</div>
<!-- ADD PRODUCT MODAL -->

<div class="modal fade"
     id="addProductModal"
     tabindex="-1"
     aria-hidden="true">

    <div class="modal-dialog modal-xl modal-dialog-scrollable">

        <div class="modal-content border-0 rounded-4 overflow-hidden">

            <div class="modal-header border-bottom bg-white px-4 py-3">

                <h5 class="modal-title fw-bold">
                    Add Product
                </h5>

                <button type="button"
                        class="close"
                        data-dismiss="modal">

                    <span>&times;</span>

                </button>

            </div>

            <form method="POST"
                  action="{{ route('admin.products.store') }}"
                  enctype="multipart/form-data">

                @csrf

                <div class="modal-body bg-light">

                    <div class="row g-4">

                        <!-- LEFT -->

                        <div class="col-lg-8">

                            <div class="card border-0 shadow-sm rounded-4">

                                <div class="card-body p-4">

                                    <h5 class="fw-bold mb-4">
                                        Basic Information
                                    </h5>

                                    <div class="mb-4">

                                        <label class="form-label fw-semibold">
                                            Product Name
                                        </label>

                                        <input type="text"
                                               name="name"
                                               class="form-control rounded-3"
                                               placeholder="Product Name">

                                    </div>
                                    <div class="row">

                                        <div class="col-md-6 mb-4">

                                            <label class="form-label fw-semibold">
                                                SKU
                                            </label>

                                            <input type="text"
                                                   name="sku"
                                                   class="form-control rounded-3">

                                        </div>

                                        <div class="col-md-6 mb-4">

                                            <label class="form-label fw-semibold">
                                                Barcode
                                            </label>

                                            <input type="text"
                                                   name="barcode"
                                                   class="form-control rounded-3">

                                        </div>

                                    </div>

                                    <div class="mb-4">

                                        <label class="form-label fw-semibold">
                                            Short Description
                                        </label>

                                        <textarea
                                            name="short_description"
                                            rows="4"
                                            class="form-control rounded-3"></textarea>

                                    </div>

                                    <div>
                                        <label class="form-label fw-semibold">
                                            Full Description
                                        </label>

                                        <textarea
                                            name="description"
                                            rows="7"
                                            class="form-control rounded-3"></textarea>

                                    </div>

                                </div>

                            </div>


                            <div class="card border-0 shadow-sm rounded-4 mt-4">

                                <div class="card-body p-4">

                                    <h5 class="fw-bold mb-4">
                                        Pricing & Inventory
                                    </h5>

                                    <div class="row">

                                        <div class="col-md-4 mb-4">

                                            <label class="form-label fw-semibold">
                                                Regular Price
                                            </label>

                                            <input type="number"
                                                   name="regular_price"
                                                   class="form-control rounded-3">

                                        </div>
                                        <div class="col-md-4 mb-4">

                                            <label class="form-label fw-semibold">
                                                Sale Price
                                            </label>

                                            <input type="number"
                                                   name="sale_price"
                                                   class="form-control rounded-3">

                                        </div>

                                        <div class="col-md-4 mb-4">

                                            <label class="form-label fw-semibold">
                                                Stock Quantity
                                            </label>

                                            <input type="number"
                                                   name="stock_quantity"
                                                   class="form-control rounded-3">

                                        </div>

                                    </div>

                                </div>

                            </div>

                        </div>
                        <!-- RIGHT -->

                        <div class="col-lg-4">

                            <div class="card border-0 shadow-sm rounded-4">

                                <div class="card-body p-4">

                                    <h5 class="fw-bold mb-4">
                                        Product Image
                                    </h5>

                                    <div class="mb-3 text-center">

                                        <img
                                            id="preview-image"
                                            src="{{ asset('admin/no-image.png') }}"
                                            class="img-fluid rounded-4 border"
                                            style="height:250px;width:100%;object-fit:cover;">

                                    </div>

                                    <input type="file"
                                           name="image"
                                           id="image-input"
                                           class="form-control rounded-3">

                                </div>

                            </div>


                            <div class="card border-0 shadow-sm rounded-4 mt-4">

                                <div class="card-body p-4">

                                    <h5 class="fw-bold mb-4">
                                        Product Settings
                                    </h5>

                                    <div class="mb-4">

                                        <label class="form-label fw-semibold">
                                            Category
                                        </label>
                                        <select name="category_id"
                                                class="form-select rounded-3">

                                            @foreach($categories as $category)

                                                <option value="{{ $category->id }}">
                                                    {{ $category->name }}
                                                </option>

                                            @endforeach

                                        </select>

                                    </div>

                                    <div class="mb-4">

                                        <label class="form-label fw-semibold">
                                            Status
                                        </label>

                                        <select name="status"
                                                class="form-select rounded-3">

                                            <option value="PUBLISHED">
                                                Published
                                            </option>

                                            <option value="DRAFT">
                                                Draft
                                            </option>

                                        </select>

                                    </div>
                                    <button class="btn btn-dark w-100 rounded-3 py-3">

                                        <i class="fas fa-save me-1"></i>
                                        Save Product

                                    </button>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>

            </form>

        </div>

    </div>

</div>
@include('admin.products.create-form')
@push('scripts')

<script>

$('#image-input').on('change', function(e){

    let reader = new FileReader();

    reader.onload = function(event){

        $('#preview-image').attr('src', event.target.result);

    }

    reader.readAsDataURL(e.target.files[0]);

});

</script>

@endpush

@endsection