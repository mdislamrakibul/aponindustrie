@extends('admin.layouts.app')

@section('content')

<div class="card">

    <div class="card-header">

        <h3>Product Details</h3>

    </div>

    <div class="card-body">

        <h4>{{ $product->name }}</h4>

        <p>Price: ৳ {{ $product->regular_price }}</p>

        <p>Stock: {{ $product->stock_quantity }}</p>

        <p>Status: {{ $product->status }}</p>

        <p>Category: {{ $product->category->name ?? 'N/A' }}</p>

        @if($product->media->first())

            <img
                src="{{ asset($product->media->first()->file_path . $product->media->first()->image_name) }}"
                width="150"
            >

        @endif

    </div>

</div>

@endsection