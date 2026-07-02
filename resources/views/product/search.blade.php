@extends('layout.master')

@section('title', 'Search Results')

@section('content')
<main class="main">
    <div class="page-header breadcrumb-wrap">
        <div class="container">
            <div class="breadcrumb">
                <a href="{{ route('home.index') }}" rel="nofollow">Home</a>
                <span></span> Search Results
            </div>
        </div>
    </div>

    <section class="mt-20 mb-20">
        <div class="container">
            <div class="shop-product-fillter mb-20">
                <div class="totall-product">
                    @if($q !== '')
                        <p style="font-weight:bold;">
                            Results for <strong class="text-brand">"{{ $q }}"</strong>
                            &mdash; <strong class="text-brand">{{ $products->total() }}</strong> item(s) found
                        </p>
                    @else
                        <p style="font-weight:bold;">
                            Showing all <strong class="text-brand">{{ $products->total() }}</strong> products
                        </p>
                    @endif
                </div>
            </div>

            @if($products->isEmpty())
                <div class="text-center py-60">
                    <i class="fi-rs-search" style="font-size:48px;color:#ccc;"></i>
                    <h3 class="mt-20" style="color:#777;">No products found</h3>
                    @if($q !== '')
                        <p style="color:#aaa;">Try a different keyword or <a href="{{ route('home.index') }}">browse the store</a>.</p>
                    @endif
                </div>
            @else
                <div class="row product-grid-3">
                    @foreach($products as $prod)
                        <div class="col-lg-3 col-md-3 col-6 col-sm-6" style="padding:10px 0;">
                            <div class="product-cart-wrap small hover-up">
                                <div class="product-img-action-wrap" style="padding:0 !important;">
                                    <div class="product-img product-img-zoom">
                                        <a href="{{ route('Product_Details', [
                                            'product_name'    => $prod->name,
                                            'category_name'   => optional($prod->category)->name,
                                            'auth_expired_key'=> 'eyJhbGciOiJFZERTQSIsInR5cCI6IkpXVCJ9.eyJzdWIiOiIxMjM0NTY3ODkwIiwibmFtZSI6IkpvaG4gRG9lIiwiYWRtaW4iOnRydWUsImlhdCI6MTUxNjIzOTAyMn0.JkKWCY39IdWEQttmdqR7VdsvT-_QxheW_eb0S5wr_j83ltux_JDUIXs7a3Dtn3xuqzuhetiuJrWIvy5TzimeCg',
                                            'category_id'     => optional($prod->category)->id,
                                            'product_id'      => $prod->id,
                                        ]) }}">
                                            @forelse($prod->media as $media)
                                                @if($media->position == 1)
                                                    <img class="default-img"
                                                         src="{{ asset($media->file_path . $media->image_name) }}"
                                                         alt="{{ $prod->name }}">
                                                @else
                                                    <img class="hover-img"
                                                         src="{{ asset($media->file_path . $media->image_name) }}"
                                                         alt="{{ $prod->name }}">
                                                @endif
                                            @empty
                                                <img class="default-img"
                                                     src="{{ asset('assets/imgs/shop/product-placeholder.png') }}"
                                                     alt="{{ $prod->name }}">
                                            @endforelse
                                        </a>
                                    </div>

                                    <div class="product-badges product-badges-position product-badges-mrg">
                                        @if(!empty($prod->is_discounted) && in_array($prod->discount_type ?? '', ['PERCENTAGE','FLAT']) && ($prod->discount_value ?? 0) > 0)
                                            <span class="badge sale">
                                                @if($prod->discount_type === 'PERCENTAGE')
                                                    {{ number_format($prod->discount_value, 0) }}% Off
                                                @elseif($prod->discount_type === 'FLAT')
                                                    ৳{{ number_format($prod->discount_value, 0) }} Off
                                                @endif
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="product-content-wrap" style="text-align:left;">
                                    <div class="product-category">
                                        <a href="#">{{ optional($prod->category)->name }}</a>
                                    </div>
                                    <h2>
                                        <a href="{{ route('Product_Details', [
                                            'product_name'    => $prod->name,
                                            'category_name'   => optional($prod->category)->name,
                                            'auth_expired_key'=> 'eyJhbGciOiJFZERTQSIsInR5cCI6IkpXVCJ9.eyJzdWIiOiIxMjM0NTY3ODkwIiwibmFtZSI6IkpvaG4gRG9lIiwiYWRtaW4iOnRydWUsImlhdCI6MTUxNjIzOTAyMn0.JkKWCY39IdWEQttmdqR7VdsvT-_QxheW_eb0S5wr_j83ltux_JDUIXs7a3Dtn3xuqzuhetiuJrWIvy5TzimeCg',
                                            'category_id'     => optional($prod->category)->id,
                                            'product_id'      => $prod->id,
                                        ]) }}">{{ $prod->name }}</a>
                                    </h2>

                                    @php $rating = $prod->reviews_avg_rating ?? 0; @endphp
                                    <div style="display:flex;gap:8px;align-items:center;">
                                        <div>
                                            @for($i = 1; $i <= 5; $i++)
                                                @if($i <= $rating)
                                                    <i class="fa fa-star" style="color:#f15412;"></i>
                                                @elseif(($i - 0.5) <= $rating)
                                                    <i class="fa fa-star-half-empty" style="color:#f15412;"></i>
                                                @else
                                                    <i class="fa fa-star-o" style="color:#f15412;"></i>
                                                @endif
                                            @endfor
                                        </div>
                                        <div style="color:#f15412;font-weight:bold;font-size:15px;">
                                            ({{ number_format($rating, 1) }})
                                        </div>
                                    </div>

                                    <div class="product-price">
                                        <span>৳{{ $prod->sale_price }}</span>
                                        @if($prod->regular_price > $prod->sale_price)
                                            <span class="old-price">৳{{ $prod->regular_price }}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="pagination-area mt-20 mb-20">
                    {{ $products->links() }}
                </div>
            @endif
        </div>
    </section>
</main>
@endsection
