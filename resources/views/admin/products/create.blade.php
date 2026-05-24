@extends('admin.layouts.app')

@section('content')

<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <h3 class="fw-bold">
            Add Product
        </h3>

        <a href="{{ route('admin.products.index') }}"
           class="btn btn-secondary">
            Back
        </a>

    </div>

    @include('admin.products.form-content', [
        'isEdit' => false,
        'product' => null
    ])

</div>

@endsection
@push('scripts')

<script>


</script>

@endpush
