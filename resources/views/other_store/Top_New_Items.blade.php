@extends('layout.master')

@section('title', 'E-Commerce')


@section('content')
    <style>
        .product-cart-wrap:hover {
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1) !important;
            transform: translateY(-8px) !important;
            border: 1px solid #fd6282 !important;
        }
    </style>
    <!--main area-->
    <main class="main">
        <div class="page-header breadcrumb-wrap">
            <div class="container">
                <div class="breadcrumb">
                    <a href="{{ route('home.index') }}" rel="nofollow">Home</a>
                    <span></span> Shop
                </div>
            </div>
        </div>
        <section class="mt-20 mb-20">
            <div class="container">
                <div class="row">
                    <div class="col-lg-9">
                        <div class="shop-product-fillter">
                            <div class="totall-product">
                                <p style="font-weight: bold"> We found <strong class="text-brand">{{ $total_item }}</strong>
                                    items for
                                    you!</p>
                            </div>
                            {{-- <div class="sort-by-product-area">
                                <div class="sort-by-cover mr-10">
                                    <div class="sort-by-product-wrap">
                                        <div class="sort-by">
                                            <span><i class="fi-rs-apps"></i>Show:</span>
                                        </div>
                                        <div class="sort-by-dropdown-wrap">
                                            <span> 50 <i class="fi-rs-angle-small-down"></i></span>
                                        </div>
                                    </div>
                                    <div class="sort-by-dropdown">
                                        <ul>
                                            <li><a class="active" href="#">50</a></li>
                                            <li><a href="#">100</a></li>
                                            <li><a href="#">150</a></li>
                                            <li><a href="#">200</a></li>
                                            <li><a href="#">All</a></li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="sort-by-cover">
                                    <div class="sort-by-product-wrap">
                                        <div class="sort-by">
                                            <span><i class="fi-rs-apps-sort"></i>Sort by:</span>
                                        </div>
                                        <div class="sort-by-dropdown-wrap">
                                            <span> Featured <i class="fi-rs-angle-small-down"></i></span>
                                        </div>
                                    </div>
                                    <div class="sort-by-dropdown">
                                        <ul>
                                            <li><a class="active" href="#">Featured</a></li>
                                            <li><a href="#">Price: Low to High</a></li>
                                            <li><a href="#">Price: High to Low</a></li>
                                            <li><a href="#">Release Date</a></li>
                                            <li><a href="#">Avg. Rating</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div> --}}
                        </div>
                        <div class="row product-grid-3">
                            {{-- <div class="col-lg-3 col-md-3 col-6 col-sm-6">
                                <div class="product-cart-wrap mb-30">
                                    <div class="product-img-action-wrap">
                                        <div class="product-img product-img-zoom">
                                            <a href="product-details.html">
                                                <img class="default-img" src="{{asset('assets/imgs/shop/product-2-1.jpg')}}"
                                                    alt="">
                                                <img class="hover-img" src="{{asset('assets/imgs/shop/product-2-2.jpg')}}"
                                                    alt="">
                                            </a>
                                        </div>
                                        <div class="product-action-1">
                                            <a aria-label="Quick view" class="action-btn hover-up" data-bs-toggle="modal"
                                                data-bs-target="#quickViewModal">
                                                <i class="fi-rs-search"></i></a>
                                            <a aria-label="Add To Wishlist" class="action-btn hover-up"
                                                href="wishlist.php"><i class="fi-rs-heart"></i></a>
                                            <a aria-label="Compare" class="action-btn hover-up" href="compare.php"><i
                                                    class="fi-rs-shuffle"></i></a>
                                        </div>
                                        <div class="product-badges product-badges-position product-badges-mrg">
                                            <span class="hot">Hot</span>
                                        </div>
                                    </div>
                                    <div class="product-content-wrap">
                                        <div class="product-category">
                                            <a href="shop.html">Music</a>
                                        </div>
                                        <h2><a href="product-details.html">Colorful Pattern Shirts</a></h2>
                                        <div class="rating-result" title="90%">
                                            <span>
                                                <span>90%</span>
                                            </span>
                                        </div>
                                        <div class="product-price">
                                            <span>৳238.85 </span>
                                            <span class="old-price">৳245.8</span>
                                        </div>
                                        <div class="product-action-1 show">
                                            <a aria-label="Add To Cart" class="action-btn hover-up" href="shop-cart.php"><i
                                                    class="fi-rs-shopping-bag-add"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </div> --}}


                            @foreach ($featuredProducts as $prod)
                                                    <div class="col-lg-3 col-md-3 col-6 col-sm-6" style="padding: 10px 0px;">
                                                        <div class="product-cart-wrap small hover-up ">
                                                            <div class="product-img-action-wrap" style="padding: 0px 0px !important">
                                                                <div class="product-img product-img-zoom">
                                                                    <a href="{{ route('Product_Details', [
                                    'category_name' => $prod->category->name,
                                    'auth_expired_key' => 'eyJhbGciOiJFZERTQSIsInR5cCI6IkpXVCJ9.eyJzdWIiOiIxMjM0NTY3ODkwIiwibmFtZSI6IkpvaG4gRG9lIiwiYWRtaW4iOnRydWUsImlhdCI6MTUxNjIzOTAyMn0.JkKWCY39IdWEQttmdqR7VdsvT-_QxheW_eb0S5wr_j83ltux_JDUIXs7a3Dtn3xuqzuhetiuJrWIvy5TzimeCg',
                                    'category_id' => $prod->category->id,
                                    'product_id' => $prod->id
                                ]) }}">
                                                                        @foreach ($prod->media as $media)
                                                                            @if ($media->position == 1)
                                                                                                            <img class="default-img"
                                                                                                                src="{{ asset($media->file_path . $media->image_name)}}" alt={{
                                                                                $media->image_name }}>
                                                                            @else

                                                                                                            <img class="hover-img"
                                                                                                                src="{{ asset($media->file_path . $media->image_name)}}" alt={{
                                                                                $media->image_name }}>
                                                                            @endif

                                                                        @endforeach


                                                                    </a>
                                                                </div>
                                                                {{-- <div class="product-action-1">
                                                                    <a aria-label="Quick view" class="action-btn small hover-up"
                                                                        data-bs-toggle="modal" data-bs-target="#quickViewModal">
                                                                        <i class="fi-rs-eye"></i></a>
                                                                    <a aria-label="Add To Wishlist" class="action-btn small hover-up"
                                                                        href="wishlist.php" tabindex="0"><i class="fi-rs-heart"></i></a>
                                                                    <a aria-label="Compare" class="action-btn small hover-up" href="compare.php"
                                                                        tabindex="0"><i class="fi-rs-shuffle"></i></a>
                                                                </div> --}}
                                                                <div class="product-badges product-badges-position product-badges-mrg">
                                                                    @if($prod['product_type'] == 'HOTSALEITEMS')
                                                                        <span class="badge hot">Hot</span>
                                                                    @elseif($prod['product_type'] == 'TOPSELLING')
                                                                        <span class="badge best-seller">Best Seller</span>
                                                                    @elseif($prod['product_type'] == 'TOPNEWITEMS')
                                                                        <span class="badge new">New</span>
                                                                    @endif

                                                                    {{-- Discount Badge Logic --}}
                                                                    @if($prod['is_discounted'])
                                                                        <span class="badge sale">
                                                                            @if($prod['discount_type'] == 'PERCENTAGE')
                                                                                {{-- Show percentage (e.g., 20% Off) --}}
                                                                                {{ number_format($prod['discount_value'], 0) }}% Off
                                                                            @elseif($prod['discount_type'] == 'FLAT')
                                                                                {{-- Show flat amount (e.g., $50 Off) --}}
                                                                                ৳{{ number_format($prod['discount_value'], 0) }} Off
                                                                            @endif
                                                                        </span>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                            <div class="product-content-wrap" style="text-align: left;">
                                                                <h2><a
                                                                        href="{{ route('Product_Details', [
                                    'product_name' => $prod->name,
                                    'category_name' => $prod->category->name,
                                    'auth_expired_key' => 'eyJhbGciOiJFZERTQSIsInR5cCI6IkpXVCJ9.eyJzdWIiOiIxMjM0NTY3ODkwIiwibmFtZSI6IkpvaG4gRG9lIiwiYWRtaW4iOnRydWUsImlhdCI6MTUxNjIzOTAyMn0.JkKWCY39IdWEQttmdqR7VdsvT-_QxheW_eb0S5wr_j83ltux_JDUIXs7a3Dtn3xuqzuhetiuJrWIvy5TzimeCg',
                                    'category_id' => $prod->category->id,
                                    'product_id' => $prod->id
                                ]) }}">{{$prod['name']}}</a>
                                                                </h2>
                                                                @php
                                                                    // Example: $rating = 4.5;
                                                                    $rating = $prod['reviews_avg_rating'] ?? 0;
                                                                @endphp

                                                                <div style="display: flex; gap: 8px;">

                                                                    <div>
                                                                        @for ($i = 1; $i <= 5; $i++) @if ($i <= $rating) {{-- Full Star --}} <i
                                                                                class="fa fa-star" style="color: #f15412;"></i>
                                                                            @elseif (($i - 0.5) <= $rating) {{-- Half Star --}} <i
                                                                                class="fa fa-star-half-empty" style="color: #f15412;"></i>
                                                                            @else
                                                                                {{-- Empty Star --}}
                                                                                <i class="fa fa-star-o" style="color: #f15412;"></i>
                                                                            @endif
                                                                        @endfor
                                                                    </div>
                                                                    <div style="color:#f15412; font-weight: bold; font-size: 15px;">
                                                                        ({{number_format($prod['reviews_avg_rating'], 1)}})
                                                                    </div>
                                                                </div>
                                                                <div class="price-row">
                                                                    <div class="product-price">
                                                                        <span>৳{{$prod['sale_price']}} </span>
                                                                        <span class="old-price">৳{{$prod['regular_price']}}</span>
                                                                    </div>

                                                                    <div class="product-action-1 show">
                                                                        <a aria-label="Add To Cart" class="action-btn hover-up" href="{{ route(
                                    'Product_Cart_Add',
                                    [
                                        'product_name' => $prod['name'],
                                        'auth_expired_key' => 'eyJhbGciOiJFZERTQSIsInR5cCI6IkpXVCJ9.eR67Hyabjda0wIiwibmFtZSI6IkpvaG4gRG9lIiwiYWRtaW4iOnRydWUsImlhdCI6MTUxNjIzOTAyMn0.JkKWCY39IdWEQttmdqR7VdsvT-_QxheW_eb0S5wr_j83ltux_JDUIXs7a3Dtn3xuqzuhetiuJrWIvy5TzimeCg',
                                        'product_id' => $prod['id']
                                    ]
                                ) }}"><i class="fi-rs-shopping-bag-add"></i></a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                            @endforeach





                        </div>
                        <!--pagination-->

                        <div class="pagination-wrapper">
                            {{ $featuredProducts->links() }}
                        </div>

                    </div>
                    <div class="col-lg-3 primary-sidebar sticky-sidebar">
                        <div class="row">
                            <div class="col-lg-12 col-mg-6"></div>
                            <div class="col-lg-12 col-mg-6"></div>
                        </div>


                        <!-- Product sidebar Widget -->
                        <div class="sidebar-widget product-sidebar  mb-30 p-30 bg-grey border-radius-10">
                            <div class="widget-header position-relative mb-20 pb-10">
                                <h5 class="widget-title mb-10">New products</h5>
                                <div class="bt-1 border-color-1"></div>
                            </div>
                            @foreach ($newProduct as $item)
                                                    <div class="single-post clearfix">
                                                        <div class="image">
                                                            @foreach ($item['media'] as $media)
                                                                @if ($media['position'] == 1)
                                                                                    <img src="{{ asset($media['file_path'] . $media['image_name'])}}" alt={{
                                                                    $media['image_name'] }}>

                                                                @endif

                                                            @endforeach
                                                        </div>
                                                        <div class="content pt-10">
                                                            <h5><a href="{{ route('Product_Details', [
                                    'product_name' => $item['name'],
                                    'category_name' => $item['category']['name'],
                                    'auth_expired_key' => 'eyJhbGciOiJFZERTQSIsInR5cCI6IkpXVCJ9.eyJzdWIiOiIxMjM0NTY3ODkwIiwibmFtZSI6IkpvaG4gRG9lIiwiYWRtaW4iOnRydWUsImlhdCI6MTUxNjIzOTAyMn0.JkKWCY39IdWEQttmdqR7VdsvT-_QxheW_eb0S5wr_j83ltux_JDUIXs7a3Dtn3xuqzuhetiuJrWIvy5TzimeCg',
                                    'category_id' => $item['category']['id'],
                                    'product_id' => $item['id']
                                ]) }}">{{
                                    $item['name'] }}</a></h5>
                                                            <p class="price mb-0 mt-5">৳{{ $item['sale_price'] }}</p>


                                                            @php
                                                                // Example: $rating = 4.5;
                                                                $rating = $item['reviews_avg_rating'] ?? 0;
                                                            @endphp

                                                            <div style="display: flex; gap: 8px;">

                                                                <div>
                                                                    @for ($i = 1; $i <= 5; $i++) @if ($i <= $rating) {{-- Full Star --}} <i
                                                                            class="fa fa-star" style="color: #f15412;"></i>
                                                                        @elseif (($i - 0.5) <= $rating) {{-- Half Star --}} <i
                                                                            class="fa fa-star-half-empty" style="color: #f15412;"></i>
                                                                        @else
                                                                            {{-- Empty Star --}}
                                                                            <i class="fa fa-star-o" style="color: #f15412;"></i>
                                                                        @endif
                                                                    @endfor
                                                                </div>
                                                                <div style="color:#f15412; font-weight: bold; font-size: 15px;">
                                                                    ({{number_format($item['reviews_avg_rating'], 1)}})
                                                                </div>
                                                            </div>



                                                        </div>
                                                    </div>
                            @endforeach
                        </div>
                        @include('partials.promo-banner')
                    </div>
                </div>
            </div>
        </section>
    </main>
    <!--main area-->


@endsection