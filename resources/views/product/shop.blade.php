@extends('layout.master')

@section('title', 'Shop — All Products')

@section('content')
<style>
    .product-cart-wrap:hover {
        box-shadow: 0 15px 35px rgba(0,0,0,0.1) !important;
        transform: translateY(-8px) !important;
        border: 1px solid #3BB77E !important;
    }
</style>
<main class="main">
    <div class="page-header breadcrumb-wrap">
        <div class="container">
            <div class="breadcrumb">
                <a href="{{ route('home.index') }}" rel="nofollow">Home</a>
                <span></span> Shop — All Products
            </div>
        </div>
    </div>

    <section class="mt-20 mb-50">
        <div class="container">
            <div class="section-header-flex mb-25">
                <h3 class="section-title style-1 mb-0">
                    @if(request('discount'))
                        <span>Discounted</span> Products
                    @else
                        <span>All</span> Products
                    @endif
                </h3>
                <span class="text-muted" style="font-size:13px;">
                    {{ $products->total() }} products
                    @if(request('discount'))
                        &nbsp;·&nbsp;<a href="{{ route('shop') }}" style="color:var(--brand-red);font-weight:600;font-size:12px;">Show all</a>
                    @else
                        — A to Z
                    @endif
                </span>
            </div>

            @if($products->isEmpty())
            <div class="text-center py-80" style="padding:80px 0;">
                <i class="fi-rs-box-alt" style="font-size:60px;color:#ddd;display:block;margin-bottom:20px;"></i>
                <h4 style="color:#aaa;">No products found.</h4>
            </div>
            @else
            <div class="row product-grid-4">
                @foreach($products as $prod)
                <div class="col-lg-3 col-md-3 col-6 col-sm-6" style="padding:10px 8px;">
                    <div class="product-cart-wrap small hover-up">
                        <div class="product-img-action-wrap" style="padding:0;">
                            <div class="product-img product-img-zoom">
                                <a href="{{ route('Product_Details', [
                                    'product_name'    => $prod->name,
                                    'category_name'   => $prod->category->name,
                                    'auth_expired_key'=> 'eyJhbGciOiJFZERTQSIsInR5cCI6IkpXVCJ9.eyJzdWIiOiIxMjM0NTY3ODkwIiwibmFtZSI6IkpvaG4gRG9lIiwiYWRtaW4iOnRydWUsImlhdCI6MTUxNjIzOTAyMn0.JkKWCY39IdWEQttmdqR7VdsvT-_QxheW_eb0S5wr_j83ltux_JDUIXs7a3Dtn3xuqzuhetiuJrWIvy5TzimeCg',
                                    'category_id'     => $prod->category->id,
                                    'product_id'      => $prod->id,
                                ]) }}">
                                    @foreach($prod->media as $media)
                                        @if($media->position == 1)
                                            <img class="default-img"
                                                 src="{{ asset($media->file_path . $media->image_name) }}"
                                                 alt="{{ $media->image_name }}">
                                        @else
                                            <img class="hover-img"
                                                 src="{{ asset($media->file_path . $media->image_name) }}"
                                                 alt="{{ $media->image_name }}">
                                        @endif
                                    @endforeach
                                </a>
                            </div>
                            <div class="product-badges product-badges-position product-badges-mrg">
                                @if($prod->is_discounted)
                                    <span class="badge sale">
                                        @if($prod->discount_type === 'PERCENTAGE')
                                            {{ number_format($prod->discount_value, 0) }}% Off
                                        @else
                                            ৳{{ number_format($prod->discount_value, 0) }} Off
                                        @endif
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="product-content-wrap" style="text-align:left;">
                            <div class="product-category" style="font-size:11px;color:#aaa;text-transform:uppercase;letter-spacing:.5px;margin-bottom:4px;">
                                {{ $prod->category->name }}
                            </div>
                            <h2>
                                <a href="{{ route('Product_Details', [
                                    'product_name'    => $prod->name,
                                    'category_name'   => $prod->category->name,
                                    'auth_expired_key'=> 'eyJhbGciOiJFZERTQSIsInR5cCI6IkpXVCJ9.eyJzdWIiOiIxMjM0NTY3ODkwIiwibmFtZSI6IkpvaG4gRG9lIiwiYWRtaW4iOnRydWUsImlhdCI6MTUxNjIzOTAyMn0.JkKWCY39IdWEQttmdqR7VdsvT-_QxheW_eb0S5wr_j83ltux_JDUIXs7a3Dtn3xuqzuhetiuJrWIvy5TzimeCg',
                                    'category_id'     => $prod->category->id,
                                    'product_id'      => $prod->id,
                                ]) }}">{{ $prod->name }}</a>
                            </h2>
                            <div class="product-price">
                                <span>৳{{ $prod->sale_price }}</span>
                                @if($prod->regular_price && $prod->regular_price != $prod->sale_price)
                                    <span class="old-price">৳{{ $prod->regular_price }}</span>
                                @endif
                            </div>
                            <div class="product-action-1 show">
                                <a aria-label="Add To Cart" class="action-btn hover-up"
                                   href="{{ route('Product_Cart_Add', [
                                       'product_name'    => $prod->name,
                                       'auth_expired_key'=> 'eyJhbGciOiJFZERTQSIsInR5cCI6IkpXVCJ9.eR67Hyabjda0wIiwibmFtZSI6IkpvaG4gRG9lIiwiYWRtaW4iOnRydWUsImlhdCI6MTUxNjIzOTAyMn0.JkKWCY39IdWEQttmdqR7VdsvT-_QxheW_eb0S5wr_j83ltux_JDUIXs7a3Dtn3xuqzuhetiuJrWIvy5TzimeCg',
                                       'product_id'      => $prod->id,
                                   ]) }}">
                                    <i class="fi-rs-shopping-bag-add"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <div class="pagination-area mt-20 mb-20 d-flex justify-content-center">
                {{ $products->links() }}
            </div>
            @endif
        </div>
    </section>
</main>
@endsection
