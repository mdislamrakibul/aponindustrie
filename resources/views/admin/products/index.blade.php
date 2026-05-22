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
                            <button
                                type="button"
                                class="action-btn view-product-btn"
                                data-id="{{ $product->id }}"
                            >
                                <i class="fas fa-eye">

                                </i>
                            </button>

                            {{-- EDIT --}}
                            <button
                                type="button"
                                class="action-btn edit-product-btn"
                                data-id="{{ $product->id }}"
                                title="Edit"
                            >

                                <i class="fas fa-pen"></i>

                            </button>

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


{{-- ADD PRODUCT MODAL --}}
@include('admin.products.create-form')

{{-- EDIT PRODUCT MODAL --}}
@include('admin.products.edit-form')
<!-- VIEW PRODUCT MODAL -->
<div class="modal fade"
     id="viewProductModal"
     tabindex="-1"
     aria-hidden="true">
     <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content rounded-4 border-0">
            <div class="modal-header">
                <h5 class="modal-title">
                     Product Details
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" id="viewProductContent"> Loading...

            </div>
        </div>
    </div>
</div>


@push('scripts')
// VIEW PRODUCT
<script>
$(document).on('click', '.view-product-btn', function () {

    let productId = $(this).data('id');

    $('#viewProductModal').modal('show');

    $('#viewProductContent').html(`
        <div class="p-5 text-center">
            Loading...
        </div>
    `);

    $.get('/admin/products/' + productId, function (response) {

        $('#viewProductContent').html(response);

    });

});
</script>

<script>
$(document).on('click', '.edit-product-btn', function(){

    let productId = $(this).data('id');

    $('#editProductModal').modal('show');

    $('#editProductContent').html(`
        <div class="p-5 text-center">
            Loading...
        </div>
    `);

    $.get('/admin/products/' + productId + '/edit', function(response){

        $('#editProductContent').html(response);

    }).fail(function(xhr){

        console.log(xhr.responseText);

        $('#editProductContent').html(`
            <div class="p-5 text-danger text-center">
                Failed to load edit form
            </div>
        `);

    });

});

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
