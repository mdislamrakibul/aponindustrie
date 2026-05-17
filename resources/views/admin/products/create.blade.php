@extends('admin.layouts.app')

@section('content')

<div class="container-fluid">

    <div class="card">

        <div class="card-body">

            <h3 class="mb-4">
                Add Product
            </h3>

            @include('admin.products.partials.form')

        </div>

    </div>

</div>

@endsection