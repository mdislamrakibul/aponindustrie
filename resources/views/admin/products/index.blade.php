@extends('admin.layouts.app')

@section('title', 'Product List')

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
                    <li class="breadcrumb-item active">Product</li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->


<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">

                <div class="card shadow-sm border-0 p-2">

                    <div class="card-header bg-white border-bottom d-flex align-items-center">

                        <div class="flex-grow-1">
                            <h3 class="card-title font-weight-bold mb-0">
                                Products
                            </h3>
                        </div>


                        <button type="button" class="btn btn-dark rounded-3 px-4" data-toggle="modal"
                            data-target="#addProductModal">
                            <i class="fas fa-plus me-1"></i>
                            Add Product
                        </button>

                    </div>
                    {{-- USER DASHBOARD CARDS --}}

                    @if(false)
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
                    @endif
                    {{-- INLINE CREATE FORM --}}
                    <div class="card-body border-bottom bg-light" id="userCreateForm" style="display:none;">
                        @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                        @endif

                        @if(session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                        @endif


                        {{-- DELETE BUTTON HIDDEN TEMPORARILY

                        <form action="{{ route('admin.users.store') }}" method="POST">
                            @csrf

                            <div class="row">

                                <div class="col-lg-3 col-md-6 mb-3">
                                    <label class="font-weight-semibold">First Name</label>

                                    <input type="text" name="first_name" class="form-control" placeholder="First Name"
                                        value="{{ old('first_name') }}" required>

                                    @error('first_name')
                                    <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="col-lg-3 col-md-6 mb-3">
                                    <label class="font-weight-semibold">Last Name</label>

                                    <input type="text" name="last_name" class="form-control"
                                        placeholder="Last Name (Optional)" value="{{ old('last_name') }}">

                                    @error('last_name')
                                    <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="col-lg-4 col-md-6 mb-3">
                                    <label class="font-weight-semibold">Mobile Number</label>
                                    <input type="text" name="mobile_no" class="form-control" placeholder="01XXXXXXXXX"
                                        required>
                                </div>

                                <div class="col-lg-2 col-md-6 mb-3">
                                    <label class="font-weight-semibold">Role</label>

                                    <select name="role" class="form-control" required>
                                        <option value="">Select</option>
                                        <option value="customer">Customer</option>
                                        <option value="vendor">Vendor</option>
                                        <option value="admin">Admin</option>
                                    </select>
                                </div>

                                <div class="col-lg-2 col-md-6 mb-3">
                                    <label class="font-weight-semibold d-block">&nbsp;</label>

                                    <button type="submit" class="btn btn-success btn-block">
                                        <i class="fas fa-save mr-1"></i>
                                        Save User
                                    </button>
                                </div>

                            </div>

                        </form>
                        --}}

                    </div>

                    {{-- Product TABLE --}}
                    <div class="card-body">

                        <div class="table-responsive">

                            <table class="table table-hover align-middle " id="dataTable">

                                <thead class="bg-light">

                                    <tr>

                                        <th>SL.</th>
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

                                        <td>{{ $loop->iteration }}.</td>

                                        <td>

                                            @php
                                            $image = $product->media->first();
                                            @endphp

                                            <img src="{{ $image ? asset($image->file_path . $image->image_name) : asset('admin/no-image.png') }}"
                                                width="50" height="50" style="object-fit:cover;border-radius:6px;">

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
                                                <button type="button" class="action-btn view-product-btn"
                                                    data-id="{{ $product->id }}">
                                                    <i class="fas fa-eye" style="color: blue;">

                                                    </i>
                                                </button>

                                                {{-- EDIT --}}
                                                <button type="button" class="action-btn edit-product-btn"
                                                    data-id="{{ $product->id }}" title="Edit">

                                                    <i class="fas fa-pen" style="color: cornflowerblue;"></i>

                                                </button>

                                                {{-- STATUS TOGGLE --}}
                                                <form action="{{ route('admin.products.toggle-status', $product->id) }}"
                                                    method="POST">

                                                    @csrf
                                                    @method('PATCH')

                                                    <button type="submit" class="action-btn border-0">

                                                        @if($product->status == 'PUBLISHED')

                                                        <i class="fas fa-trash" style="color: maroon;"></i>

                                                        @else

                                                        <i class="fas fa-undo" style="color: green;"></i>

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

                </div>

            </div>
        </div>
    </div><!-- /.container-fluid -->
</section>



{{-- ADD PRODUCT MODAL --}}
@include('admin.products.create-form')

{{-- EDIT PRODUCT MODAL --}}
@include('admin.products.edit-form')
<!-- VIEW PRODUCT MODAL -->
<div class="modal fade" id="viewProductModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content rounded-4 border-0">
            <div class="modal-header">
                <h5 class="modal-title">
                    Product Details
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="modal-body" id="viewProductContent"> Loading...

            </div>
        </div>
    </div>
</div>


@push('scripts')
{{-- // VIEW PRODUCT --}}
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
