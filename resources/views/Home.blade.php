@extends('layout.master')

@section('title', 'E-Commerce')


@section('content')
<style>
    :root {
        --brand-color: #3BB77E;
        --hover-bg: #f2f3f8;
        --text-main: #253D4E;
        --transition-smooth: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);

        --primary: #3BB77E;
        --secondary: #FDC040;
        --danger: #fd6282;
        --info: #67bcee;
        --text-dark: #253D4E;
        --text-muted: #7E7E7E;
        --bg-light: #f7f8f9;

    }

    .product-card {
        background: #fff;
        border-radius: 20px;
        border: 1px solid #f0f0f0;
        position: relative;
        overflow: hidden;
        transition: var(--transition-smooth);
        max-width: 300px;
    }

    .product-card:hover {
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
        transform: translateY(-8px);
        border-color: var(--brand-color);
    }

    /* Header & Image */
    .product-header {
        position: relative;
        overflow: hidden;
        background: #f8f9fa;
        height: 250px;
    }

    .image-box img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: var(--transition-smooth);
    }

    .secondary-img {
        position: absolute;
        top: 0;
        left: 0;
        opacity: 0;
        transform: scale(1.1);
    }

    .product-card:hover .secondary-img {
        opacity: 1;
        transform: scale(1);
    }

    .product-card:hover .primary-img {
        transform: scale(1.1);
    }

    /* Side Toolbar */
    .side-actions {
        position: absolute;
        right: -50px;
        top: 20px;
        display: flex;
        flex-direction: column;
        gap: 10px;
        transition: var(--transition-smooth);
    }

    .product-card:hover .side-actions {
        right: 15px;
    }

    .tool-btn {
        width: 40px;
        height: 40px;
        border-radius: 10px;
        border: none;
        background: rgba(255, 255, 255, 0.9);
        backdrop-filter: blur(5px);
        color: var(--text-main);
        cursor: pointer;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
        transition: 0.3s;
    }

    .tool-btn:hover {
        background: var(--brand-color);
        color: #fff;
    }

    /* Body Content */
    .product-body {
        padding: 20px;
    }

    .category-row {
        display: flex;
        justify-content: space-between;
        font-size: 12px;
        margin-bottom: 8px;
    }

    .category-tag {
        color: #ADADAD;
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    .product-title {
        font-size: 18px;
        margin-bottom: 12px;
        font-weight: 700;
    }

    .product-title a {
        text-decoration: none;
        color: var(--text-main);
        transition: 0.3s;
    }

    .product-title a:hover {
        color: var(--brand-color);
    }

    /* Interactive Swatches */
    .color-swatches {
        display: flex;
        gap: 8px;
        margin-bottom: 15px;
    }

    .swatch {
        width: 18px;
        height: 18px;
        border-radius: 50%;
        cursor: pointer;
        border: 2px solid transparent;
        transition: 0.2s;
    }

    .swatch:hover,
    .swatch.active {
        border-color: #fff;
        outline: 1px solid var(--text-main);
        transform: scale(1.2);
    }

    /* Price & Quick Add */
    .price-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .price-now {
        font-size: 20px;
        font-weight: 800;
        color: var(--brand-color);
    }

    .price-old {
        color: #ADADAD;
        text-decoration: line-through;
        font-size: 14px;
        margin-left: 5px;
    }

    .quick-add-btn {
        background: var(--brand-color);
        color: #fff;
        border: none;
        width: 45px;
        height: 45px;
        border-radius: 12px;
        cursor: pointer;
        transition: var(--transition-smooth);
    }

    .quick-add-btn:hover {
        background: var(--text-main);
        transform: rotate(90deg);
    }

    /* Badges */

    /* Badges */
    .badges {
        position: absolute;
        top: 10px;
        left: 10px;
        z-index: 10;
    }

    .badge {
        padding: 2px 5px;
        ;
        border-radius: 20px 0 20px 0;
        color: #fff;
        font-size: 11px;
        display: block;
        margin-bottom: 4px;
    }

    /* .hot {
                                    background: #fdc040;
                                } */

    .discount {
        background: #f74b81 !important;
    }



    .hot {
        background: #ff5a5f !important;
    }

    .save {
        background: #3bb77e !important;
    }

    .badge.hot {
        background: var(--danger);
    }

    .badge.trending {
        background: var(--info);
    }

    .badge.best-seller {
        background: var(--secondary);
    }

    .badge.new {
        background: var(--primary);
    }

    .badge.sale {
        background: #3b3b3b;
    }

    /* Container for the side banners */
    .side-banner {
        position: relative;
        margin-bottom: 20px;
        overflow: hidden;
        border-radius: 10px;
        /* Optional: adds a modern look */
    }

    /* Ensure images always fit the width */
    .side-banner img {
        width: 100%;
        height: auto;
        display: block;
        object-fit: cover;
    }

    /* Text info positioning */
    .side-banner .banne_info {
        position: absolute;
        top: 50%;
        right: 0;
        transform: translateY(-50%);
        padding: 20px;
        width: 60%;
        /* Limits text width to prevent overlap if image is small */
    }

    .side-banner .banne_info h4 {
        font-size: 1.2rem;
        margin-bottom: 5px;
    }

    /* RESPONSIVE FIXES */

    /* Medium screens (Tablets): Stack the side banners horizontally */
    @media (min-width: 768px) and (max-width: 991px) {
        .col-md-12 .side-banner {
            width: calc(50% - 10px);
            float: left;
            margin-right: 10px;
        }

        .col-md-12 .side-banner:last-child {
            margin-right: 0;
        }
    }

    /* Small screens (Phones): Ensure text doesn't vanish or overlap */
    @media (max-width: 576px) {
        .side-banner .banne_info h4 {
            font-size: 1rem;
        }

        .side-banner .banne_info h6 {
            font-size: 0.8rem;
        }

        .side-banner .banne_info {
            padding: 10px;
        }
    }

    /* Clearfix for the floated items on tablet */
    .col-lg-3::after {
        content: "";
        display: table;
        clear: both;
    }
</style>
<main class="main">

    {{-- Top Slider --}}
    <div class="bg-square-left"></div>



    <div class="container">
        <div class="row">
            <div class="col-lg-9 col-md-12">
                <section class="home-slider position-relative">
                    <div class="hero-slider-1 dot-style-1 dot-style-1-position-1">
                        <div class="single-hero-slider single-animation-wrap">
                            <div class="container">
                                <div class="row align-items-center slider-animated-1">
                                    <div class="col-lg-5 col-md-6">
                                        <div class="hero-slider-content-2">
                                            <h4 class="animated">Trade-in offer</h4>
                                            <h2 class="animated fw-900">Supper deals</h2>
                                            <h1 class="animated fw-900 text-brand">On all products</h1>
                                            <p class="animated">Save more with coupons & up to 70% off</p>
                                            {{-- <a class="animated btn btn-brush btn-brush-3"
                                                href="product-details.html">Shop Now</a> --}}
                                        </div>
                                    </div>
                                    <div class="col-lg-7 col-md-6">
                                        <div class="single-slider-img single-slider-img-1">
                                            <img class="animated slider-1-1"
                                                src="{{ asset('assets/uploads/Main Slider Design/Main Slider Design-2.png') }}"
                                                alt="">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="single-hero-slider single-animation-wrap">
                            <div class="container">
                                <div class="row align-items-center slider-animated-1">
                                    <div class="col-lg-5 col-md-6">
                                        <div class="hero-slider-content-2">
                                            <h4 class="animated">Trade-in offer</h4>
                                            <h2 class="animated fw-900">Supper deals</h2>
                                            <h1 class="animated fw-900 text-brand">On all products</h1>
                                            <p class="animated">Save more with coupons & up to 70% off</p>
                                            {{-- <a class="animated btn btn-brush btn-brush-3"
                                                href="product-details.html">Shop Now</a> --}}
                                        </div>
                                    </div>
                                    <div class="col-lg-7 col-md-6">
                                        <div class="single-slider-img single-slider-img-1">
                                            <img class="animated slider-1-1"
                                                src="{{ asset('assets/uploads/Main Slider Design/Main Slider Design-1.png') }}"
                                                alt="">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="single-hero-slider single-animation-wrap">
                            <div class="container">
                                <div class="row align-items-center slider-animated-1">
                                    <div class="col-lg-5 col-md-6">
                                        <div class="hero-slider-content-2">
                                            <h4 class="animated">Trade-in offer</h4>
                                            <h2 class="animated fw-900">Supper deals</h2>
                                            <h1 class="animated fw-900 text-brand">On all products</h1>
                                            <p class="animated">Save more with coupons & up to 70% off</p>
                                            {{-- <a class="animated btn btn-brush btn-brush-3"
                                                href="product-details.html">Shop Now</a> --}}
                                        </div>
                                    </div>
                                    <div class="col-lg-7 col-md-6">
                                        <div class="single-slider-img single-slider-img-1">
                                            <img class="animated slider-1-1"
                                                src="{{ asset('assets/uploads/Main Slider Design/Main Slider Design-1-Apon Plastic.png') }}"
                                                alt="">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="single-hero-slider single-animation-wrap">
                            <div class="container">
                                <div class="row align-items-center slider-animated-1">
                                    <div class="col-lg-5 col-md-6">
                                        <div class="hero-slider-content-2">
                                            <h4 class="animated">Trade-in offer</h4>
                                            <h2 class="animated fw-900">Supper deals</h2>
                                            <h1 class="animated fw-900 text-brand">On all products</h1>
                                            <p class="animated">Save more with coupons & up to 70% off</p>
                                            {{-- <a class="animated btn btn-brush btn-brush-3"
                                                href="product-details.html">Shop Now</a> --}}
                                        </div>
                                    </div>
                                    <div class="col-lg-7 col-md-6">
                                        <div class="single-slider-img single-slider-img-1">
                                            <img class="animated slider-1-1"
                                                src="{{ asset('assets/uploads/Main Slider Design/Main Slider Design-2-Apon Plastic.png') }}"
                                                alt="">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="single-hero-slider single-animation-wrap">
                            <div class="container">
                                <div class="row align-items-center slider-animated-1">
                                    <div class="col-lg-5 col-md-6">
                                        <div class="hero-slider-content-2">
                                            <h4 class="animated">Trade-in offer</h4>
                                            <h2 class="animated fw-900">Supper deals</h2>
                                            <h1 class="animated fw-900 text-brand">On all products</h1>
                                            <p class="animated">Save more with coupons & up to 70% off</p>
                                            {{-- <a class="animated btn btn-brush btn-brush-3"
                                                href="product-details.html">Shop Now</a> --}}
                                        </div>
                                    </div>
                                    <div class="col-lg-7 col-md-6">
                                        <div class="single-slider-img single-slider-img-1">
                                            <img class="animated slider-1-1"
                                                src="{{ asset('assets/uploads/Main Slider Design/Main Slider Design-3-Apon Plastic.png') }}"
                                                alt="">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="single-hero-slider single-animation-wrap">
                            <div class="container">
                                <div class="row align-items-center slider-animated-1">
                                    <div class="col-lg-5 col-md-6">
                                        <div class="hero-slider-content-2">
                                            <h4 class="animated">Trade-in offer</h4>
                                            <h2 class="animated fw-900">Supper deals</h2>
                                            <h1 class="animated fw-900 text-brand">On all products</h1>
                                            <p class="animated">Save more with coupons & up to 70% off</p>
                                            {{-- <a class="animated btn btn-brush btn-brush-3"
                                                href="product-details.html">Shop Now</a> --}}
                                        </div>
                                    </div>
                                    <div class="col-lg-7 col-md-6">
                                        <div class="single-slider-img single-slider-img-1">
                                            <img class="animated slider-1-1"
                                                src="{{ asset('assets/uploads/Main Slider Design/Main Slider Design-4-Apon Plastic.png') }}"
                                                alt="">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="single-hero-slider single-animation-wrap">
                            <div class="container">
                                <div class="row align-items-center slider-animated-1">
                                    <div class="col-lg-5 col-md-6">
                                        <div class="hero-slider-content-2">
                                            <h4 class="animated">Trade-in offer</h4>
                                            <h2 class="animated fw-900">Supper deals</h2>
                                            <h1 class="animated fw-900 text-brand">On all products</h1>
                                            <p class="animated">Save more with coupons & up to 70% off</p>
                                            {{-- <a class="animated btn btn-brush btn-brush-3"
                                                href="product-details.html">Shop Now</a> --}}
                                        </div>
                                    </div>
                                    <div class="col-lg-7 col-md-6">
                                        <div class="single-slider-img single-slider-img-1">
                                            <img class="animated slider-1-1"
                                                src="{{ asset('assets/uploads/Main Slider Design/Main Slider Design-5-Apon Plastic.png') }}"
                                                alt="">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>

            <div class="col-lg-3 col-md-12 pt-lg-5 pt-3">
                <div class="side-banner">
                    <img src="{{asset('assets/uploads/Right Banner/Pink and Blue Modern Aesthetic Fashion Facebook Cover.png')}}"
                        alt="menu_banner1">
                    {{-- <div class="banne_info">
                        <h6>10% Off</h6>
                        <h4>New Arrival</h4>
                        <a href="#">Shop now</a>
                    </div> --}}
                </div>
                <div class="side-banner">
                    <img src="{{asset('assets/uploads/Right Banner/Right banner_Apon Plastic.png')}}"
                        alt="menu_banner2">
                    {{-- <div class="banne_info">
                        <h6>15% Off</h6>
                        <h4>Hot Deals</h4>
                        <a href="#">Shop now</a>
                    </div> --}}
                </div>
            </div>
        </div>
    </div>




    {{-- Good Quality --}}
    <section class="featured section-padding position-relative">
        <div class="container">
            <div class="row">
                <div class="col-lg-2 col-md-4 mb-md-3 mb-lg-0">
                    <div class="banner-features wow fadeIn animated hover-up" style="background-color: #eaf6fb;">
                        <img src="assets/imgs/theme/icons/feature-2.png" alt="">
                        <h4 class="bg-3">Online Order</h4>
                    </div>
                </div>
                <div class="col-lg-2 col-md-4 mb-md-3 mb-lg-0">
                    <div class="banner-features wow fadeIn animated hover-up" style="background-color: #fef6f2;">
                        <img src="assets/imgs/theme/icons/feature-1.png" alt="">
                        <h4 class="bg-1">Quick Shipping</h4>
                    </div>
                </div>
                <div class="col-lg-2 col-md-4 mb-md-3 mb-lg-0">
                    <div class="banner-features wow fadeIn animated hover-up" style="background: #fffbd2">
                        <img src="assets/imgs/theme/icons/feature-3.png" alt="">
                        <h4 class="bg-2">Save Money</h4>
                    </div>
                </div>
                <div class="col-lg-2 col-md-4 mb-md-3 mb-lg-0">
                    <div class="banner-features wow fadeIn animated hover-up" style="background: #e4fae2 ">
                        <img src="assets/imgs/theme/icons/feature-4.png" alt="">
                        <h4 class="bg-4">Promotions</h4>
                    </div>
                </div>
                <div class="col-lg-2 col-md-4 mb-md-3 mb-lg-0">
                    <div class="banner-features wow fadeIn animated hover-up" style="background: #fffce0;">
                        <img src="assets/imgs/theme/icons/feature-5.png" alt="">
                        <h4 class="bg-5">Happy Sell</h4>
                    </div>
                </div>
                <div class="col-lg-2 col-md-4 mb-md-3 mb-lg-0">
                    <div class="banner-features wow fadeIn animated hover-up" style="background: #d8f7d7">
                        <img src="assets/imgs/theme/icons/feature-6.png" alt="">
                        <h4 class="bg-6">Online Support</h4>
                    </div>
                </div>
            </div>
        </div>
    </section>







    {{-- 3 small Banner Add --}}
    <section class="banners mb-15">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 col-md-6">
                    <div class="banner-img wow fadeIn animated">
                        <img src="{{asset('assets/uploads/Right Banner/Pink and Blue Modern Aesthetic Fashion Facebook Cover.png')}}"
                            alt="menu_banner1">

                        {{-- <div class="banner-text">
                            <span>Smart Offer</span>
                            <h4>Save 20% on <br>Woman Bag</h4>
                            <a href="shop.html">Shop Now <i class="fi-rs-arrow-right"></i></a>
                        </div> --}}
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="banner-img wow fadeIn animated">
                        <img src="{{asset('assets/uploads/Right Banner/Pink and Blue Modern Aesthetic Fashion Facebook Cover.png')}}"
                            alt="menu_banner1">

                        {{-- <div class="banner-text">
                            <span>Sale off</span>
                            <h4>Great Summer <br>Collection</h4>
                            <a href="shop.html">Shop Now <i class="fi-rs-arrow-right"></i></a>
                        </div> --}}
                    </div>
                </div>
                <div class="col-lg-4 d-md-none d-lg-flex">
                    <div class="banner-img wow fadeIn animated  mb-sm-0">
                        <img src="{{asset('assets/uploads/Right Banner/Right banner_Apon Plastic.png')}}"
                            alt="menu_banner1">

                        {{-- <div class="banner-text">
                            <span>New Arrivals</span>
                            <h4>Shop Today’s <br>Deals & Offers</h4>
                            <a href="shop.html">Shop Now <i class="fi-rs-arrow-right"></i></a>
                        </div> --}}
                    </div>
                </div>
            </div>
        </div>
    </section>





    {{-- Fetured / Popular/ New Added --}}
    <section class="product-tabs section-padding position-relative wow fadeIn animated">
        <div class="bg-square"></div>
        <div class="container">
            <div class="tab-header">
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="nav-tab-one" data-bs-toggle="tab" data-bs-target="#tab-one"
                            type="button" role="tab" aria-controls="tab-one" aria-selected="true">Featured</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="nav-tab-two" data-bs-toggle="tab" data-bs-target="#tab-two"
                            type="button" role="tab" aria-controls="tab-two" aria-selected="false">Popular</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="nav-tab-three" data-bs-toggle="tab" data-bs-target="#tab-three"
                            type="button" role="tab" aria-controls="tab-three" aria-selected="false">New
                            added</button>
                    </li>
                </ul>
                {{-- <a href="#" class="view-more d-none d-md-flex">View More<i
                        class="fi-rs-angle-double-small-right"></i></a> --}}
            </div>
            <!--End nav-tabs-->
            <div class="tab-content wow fadeIn animated" id="myTabContent">



                <!--En tab one (Featured)-->
                <div class="tab-pane fade show active" id="tab-one" role="tabpanel" aria-labelledby="tab-one">
                    <div class="row product-grid-4">

                        @foreach ($featuredProducts as $prods)
                        <div class="col-lg-3 col-md-4 col-sm-6 col-xs-6 col-6">

                            <div class="product-card mb-20">
                                <div class="product-header">

                                    <div class="badges">

                                        {{-- <span class="badge hot">Hot</span>
                                        <span class="badge trending">Trending</span>
                                        <span class="badge best-seller">Best Seller</span>
                                        <span class="badge new">New</span>
                                        <span class="badge sale">20% Off</span> --}}

                                        @if($prods['product_type'] == 'HOTSALEITEMS')
                                        <span class="badge hot">Hot</span>
                                        @elseif($prods['product_type'] == 'TOPSELLING')
                                        <span class="badge best-seller">Best Seller</span>
                                        @elseif($prods['product_type'] == 'TOPNEWITEMS')
                                        <span class="badge new">New</span>
                                        @endif

                                        {{-- Discount Badge Logic --}}
                                        @if($prods['is_discounted'])
                                        <span class="badge sale">
                                            @if($prods['discount_type'] == 'PERCENTAGE')
                                            {{-- Show percentage (e.g., 20% Off) --}}
                                            {{ number_format($prods['discount_value'], 0) }}% Off
                                            @elseif($prods['discount_type'] == 'FLAT')
                                            {{-- Show flat amount (e.g., $50 Off) --}}
                                            ${{ number_format($prods['discount_value'], 0) }} Off
                                            @endif
                                        </span>
                                        @endif
                                    </div>

                                    <a href="{{ route('Product_Details', ['product_name' => $prods['name'],'category_name' => $prods['category']['name'],'auth_expired_key'=>'eyJhbGciOiJFZERTQSIsInR5cCI6IkpXVCJ9.eyJzdWIiOiIxMjM0NTY3ODkwIiwibmFtZSI6IkpvaG4gRG9lIiwiYWRtaW4iOnRydWUsImlhdCI6MTUxNjIzOTAyMn0.JkKWCY39IdWEQttmdqR7VdsvT-_QxheW_eb0S5wr_j83ltux_JDUIXs7a3Dtn3xuqzuhetiuJrWIvy5TzimeCg',
                                        'category_id' => $prods['category']['id'],'product_id'=>$prods['id'] ]) }}">
                                        @foreach ($prods['media'] as $media)
                                        @if ($media['position'] == 0)
                                        <img class="primary-img" {{--
                                            src="{{asset('assets/uploads/Product Image/1000 ml Sq_Natural_Transparent Jar_Apon Plastic_Product Image.png')}}"
                                            --}} {{-- src="{{ asset( $product->media->first()->file_path) }}" --}}
                                            src="{{ asset( $media['file_path']. $media['image_name'])}}" alt={{
                                            $media['image_name'] }}>
                                        @else
                                        {{-- <img class="hover-img"
                                            src="{{asset('assets/uploads/Product Image/1000 ml Sq_Natural_Transparent Jar_Apon Plastic_Product Image.png')}}"
                                            alt=""> --}}
                                        <img class="secondary-img"
                                            src="{{ asset( $media['file_path']. $media['image_name'])}}" alt={{
                                            $media['image_name'] }}>
                                        @endif

                                        @endforeach

                                        {{-- --}}
                                    </a>


                                    <div class="side-actions">
                                        <button class="tool-btn" data-tooltip="Quick View"><i
                                                class="fi-rs-eye"></i></button>
                                        <button class="tool-btn" data-tooltip="Wishlist"><i
                                                class="fi-rs-heart"></i></button>
                                        <button class="tool-btn" data-tooltip="Compare"><i
                                                class="fi-rs-shuffle"></i></button>
                                    </div>
                                </div>

                                <div class="product-body product-cart-wrap">
                                    <div class="category-row">
                                        <span class="category-tag">{{ $prods['category']['name'] }}</span>
                                        <div class="rating-mini"><i class="fi-rs-star"></i> 4.8</div>
                                    </div>

                                    <h3 class="product-title"> <a href="{{ route('Product_Details', ['product_name' => $prods['name'],'category_name' => $prods['category']['name'],'auth_expired_key'=>'eyJhbGciOiJFZERTQSIsInR5cCI6IkpXVCJ9.eyJzdWIiOiIxMjM0NTY3ODkwIiwibmFtZSI6IkpvaG4gRG9lIiwiYWRtaW4iOnRydWUsImlhdCI6MTUxNjIzOTAyMn0.JkKWCY39IdWEQttmdqR7VdsvT-_QxheW_eb0S5wr_j83ltux_JDUIXs7a3Dtn3xuqzuhetiuJrWIvy5TzimeCg',
                                        'category_id' => $prods['category']['id'],'product_id'=>$prods['id'] ]) }}">{{
                                            $prods['name'] }}</a></h3>

                                    <div class="price-row">
                                        <div class="prices">
                                            <span class="price-now">৳{{ $prods['sale_price'] }}</span>
                                            <span class="price-old">৳{{ $prods['regular_price'] }}</span>
                                        </div>

                                        <div class="product-action-1 show">
                                            <a aria-label="Add To Cart" class="action-btn hover-up" href="{{ route('Product_Cart_Add',
                                            ['product_name' => $prods['name'],'auth_expired_key'=>'eyJhbGciOiJFZERTQSIsInR5cCI6IkpXVCJ9.eR67Hyabjda0wIiwibmFtZSI6IkpvaG4gRG9lIiwiYWRtaW4iOnRydWUsImlhdCI6MTUxNjIzOTAyMn0.JkKWCY39IdWEQttmdqR7VdsvT-_QxheW_eb0S5wr_j83ltux_JDUIXs7a3Dtn3xuqzuhetiuJrWIvy5TzimeCg',
                                        'product_id'=>$prods['id'] ]) }}">

                                                <i class="fi-rs-shopping-bag-add"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                        @endforeach


                    </div>
                </div>
                <!--En tab one (Featured)-->




                <!--En tab two (Popular)-->
                <div class="tab-pane fade" id="tab-two" role="tabpanel" aria-labelledby="tab-two">
                    <div class="row product-grid-4">


                        @foreach ($popularProducts as $prods)
                        <div class="col-lg-3 col-md-4 col-sm-6 col-xs-6 col-6">

                            <div class="product-card mb-20">
                                <div class="product-header">

                                    <div class="badges">

                                        {{-- <span class="badge hot">Hot</span>
                                        <span class="badge trending">Trending</span>
                                        <span class="badge best-seller">Best Seller</span>
                                        <span class="badge new">New</span>
                                        <span class="badge sale">20% Off</span> --}}

                                        @if($prods['product_type'] == 'HOTSALEITEMS')
                                        <span class="badge hot">Hot</span>
                                        @elseif($prods['product_type'] == 'TOPSELLING')
                                        <span class="badge best-seller">Best Seller</span>
                                        @elseif($prods['product_type'] == 'TOPNEWITEMS')
                                        <span class="badge new">New</span>
                                        @endif

                                        {{-- Discount Badge Logic --}}
                                        @if($prods['is_discounted'])
                                        <span class="badge sale">
                                            @if($prods['discount_type'] == 'PERCENTAGE')
                                            {{-- Show percentage (e.g., 20% Off) --}}
                                            {{ number_format($prods['discount_value'], 0) }}% Off
                                            @elseif($prods['discount_type'] == 'FLAT')
                                            {{-- Show flat amount (e.g., $50 Off) --}}
                                            ${{ number_format($prods['discount_value'], 0) }} Off
                                            @endif
                                        </span>
                                        @endif
                                    </div>

                                    <a href="{{ route('Product_Details', ['product_name' => $prods['name'],'category_name' => $prods['category']['name'],'auth_expired_key'=>'eyJhbGciOiJFZERTQSIsInR5cCI6IkpXVCJ9.eyJzdWIiOiIxMjM0NTY3ODkwIiwibmFtZSI6IkpvaG4gRG9lIiwiYWRtaW4iOnRydWUsImlhdCI6MTUxNjIzOTAyMn0.JkKWCY39IdWEQttmdqR7VdsvT-_QxheW_eb0S5wr_j83ltux_JDUIXs7a3Dtn3xuqzuhetiuJrWIvy5TzimeCg',
                                        'category_id' => $prods['category']['id'],'product_id'=>$prods['id'] ]) }}">
                                        @foreach ($prods['media'] as $media)
                                        @if ($media['position'] == 0)
                                        <img class="primary-img" {{--
                                            src="{{asset('assets/uploads/Product Image/1000 ml Sq_Natural_Transparent Jar_Apon Plastic_Product Image.png')}}"
                                            --}} {{-- src="{{ asset( $product->media->first()->file_path) }}" --}}
                                            src="{{ asset( $media['file_path']. $media['image_name'])}}" alt={{
                                            $media['image_name'] }}>
                                        @else
                                        {{-- <img class="hover-img"
                                            src="{{asset('assets/uploads/Product Image/1000 ml Sq_Natural_Transparent Jar_Apon Plastic_Product Image.png')}}"
                                            alt=""> --}}
                                        <img class="secondary-img"
                                            src="{{ asset( $media['file_path']. $media['image_name'])}}" alt={{
                                            $media['image_name'] }}>
                                        @endif

                                        @endforeach

                                        {{-- --}}
                                    </a>


                                    <div class="side-actions">
                                        <button class="tool-btn" data-tooltip="Quick View"><i
                                                class="fi-rs-eye"></i></button>
                                        <button class="tool-btn" data-tooltip="Wishlist"><i
                                                class="fi-rs-heart"></i></button>
                                        <button class="tool-btn" data-tooltip="Compare"><i
                                                class="fi-rs-shuffle"></i></button>
                                    </div>
                                </div>

                                <div class="product-body product-cart-wrap">
                                    <div class="category-row">
                                        <span class="category-tag">{{ $prods['category']['name'] }}</span>
                                        <div class="rating-mini"><i class="fi-rs-star"></i> 4.8</div>
                                    </div>

                                    <h3 class="product-title"> <a href="{{ route('Product_Details', ['product_name' => $prods['name'],'category_name' => $prods['category']['name'],'auth_expired_key'=>'eyJhbGciOiJFZERTQSIsInR5cCI6IkpXVCJ9.eyJzdWIiOiIxMjM0NTY3ODkwIiwibmFtZSI6IkpvaG4gRG9lIiwiYWRtaW4iOnRydWUsImlhdCI6MTUxNjIzOTAyMn0.JkKWCY39IdWEQttmdqR7VdsvT-_QxheW_eb0S5wr_j83ltux_JDUIXs7a3Dtn3xuqzuhetiuJrWIvy5TzimeCg',
                                        'category_id' => $prods['category']['id'],'product_id'=>$prods['id'] ]) }}">{{
                                            $prods['name'] }}</a></h3>

                                    <div class="price-row">
                                        <div class="prices">
                                            <span class="price-now">৳{{ $prods['sale_price'] }}</span>
                                            <span class="price-old">৳{{ $prods['regular_price'] }}</span>
                                        </div>

                                        <div class="product-action-1 show">
                                            <a aria-label="Add To Cart" class="action-btn hover-up" href="{{ route('Product_Cart_Add',
                                            ['product_name' => $prods['name'],'auth_expired_key'=>'eyJhbGciOiJFZERTQSIsInR5cCI6IkpXVCJ9.eR67Hyabjda0wIiwibmFtZSI6IkpvaG4gRG9lIiwiYWRtaW4iOnRydWUsImlhdCI6MTUxNjIzOTAyMn0.JkKWCY39IdWEQttmdqR7VdsvT-_QxheW_eb0S5wr_j83ltux_JDUIXs7a3Dtn3xuqzuhetiuJrWIvy5TzimeCg',
                                        'product_id'=>$prods['id'] ]) }}">

                                                <i class="fi-rs-shopping-bag-add"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                        @endforeach

                    </div>
                </div>
                <!--En tab two (Popular)-->



                <!--En tab three (New added)-->
                <div class="tab-pane fade" id="tab-three" role="tabpanel" aria-labelledby="tab-three">
                    <div class="row product-grid-4">


                        @foreach ($newAddedProducts as $prods)
                        <div class="col-lg-3 col-md-4 col-sm-6 col-xs-6 col-6">

                            <div class="product-card mb-20">
                                <div class="product-header">

                                    <div class="badges">

                                        {{-- <span class="badge hot">Hot</span>
                                        <span class="badge trending">Trending</span>
                                        <span class="badge best-seller">Best Seller</span>
                                        <span class="badge new">New</span>
                                        <span class="badge sale">20% Off</span> --}}

                                        @if($prods['product_type'] == 'HOTSALEITEMS')
                                        <span class="badge hot">Hot</span>
                                        @elseif($prods['product_type'] == 'TOPSELLING')
                                        <span class="badge best-seller">Best Seller</span>
                                        @elseif($prods['product_type'] == 'TOPNEWITEMS')
                                        <span class="badge new">New</span>
                                        @endif

                                        {{-- Discount Badge Logic --}}
                                        @if($prods['is_discounted'])
                                        <span class="badge sale">
                                            @if($prods['discount_type'] == 'PERCENTAGE')
                                            {{-- Show percentage (e.g., 20% Off) --}}
                                            {{ number_format($prods['discount_value'], 0) }}% Off
                                            @elseif($prods['discount_type'] == 'FLAT')
                                            {{-- Show flat amount (e.g., $50 Off) --}}
                                            ${{ number_format($prods['discount_value'], 0) }} Off
                                            @endif
                                        </span>
                                        @endif
                                    </div>

                                    <a href="{{ route('Product_Details', ['product_name' => $prods['name'],'category_name' => $prods['category']['name'],'auth_expired_key'=>'eyJhbGciOiJFZERTQSIsInR5cCI6IkpXVCJ9.eyJzdWIiOiIxMjM0NTY3ODkwIiwibmFtZSI6IkpvaG4gRG9lIiwiYWRtaW4iOnRydWUsImlhdCI6MTUxNjIzOTAyMn0.JkKWCY39IdWEQttmdqR7VdsvT-_QxheW_eb0S5wr_j83ltux_JDUIXs7a3Dtn3xuqzuhetiuJrWIvy5TzimeCg',
                                        'category_id' => $prods['category']['id'],'product_id'=>$prods['id'] ]) }}">
                                        @foreach ($prods['media'] as $media)
                                        @if ($media['position'] == 0)
                                        <img class="primary-img" {{--
                                            src="{{asset('assets/uploads/Product Image/1000 ml Sq_Natural_Transparent Jar_Apon Plastic_Product Image.png')}}"
                                            --}} {{-- src="{{ asset( $product->media->first()->file_path) }}" --}}
                                            src="{{ asset( $media['file_path']. $media['image_name'])}}" alt={{
                                            $media['image_name'] }}>
                                        @else
                                        {{-- <img class="hover-img"
                                            src="{{asset('assets/uploads/Product Image/1000 ml Sq_Natural_Transparent Jar_Apon Plastic_Product Image.png')}}"
                                            alt=""> --}}
                                        <img class="secondary-img"
                                            src="{{ asset( $media['file_path']. $media['image_name'])}}" alt={{
                                            $media['image_name'] }}>
                                        @endif

                                        @endforeach

                                        {{-- --}}
                                    </a>


                                    <div class="side-actions">
                                        <button class="tool-btn" data-tooltip="Quick View"><i
                                                class="fi-rs-eye"></i></button>
                                        <button class="tool-btn" data-tooltip="Wishlist"><i
                                                class="fi-rs-heart"></i></button>
                                        <button class="tool-btn" data-tooltip="Compare"><i
                                                class="fi-rs-shuffle"></i></button>
                                    </div>
                                </div>

                                <div class="product-body product-cart-wrap">
                                    <div class="category-row">
                                        <span class="category-tag">{{ $prods['category']['name'] }}</span>
                                        <div class="rating-mini"><i class="fi-rs-star"></i> 4.8</div>
                                    </div>

                                    <h3 class="product-title"> <a href="{{ route('Product_Details', ['product_name' => $prods['name'],'category_name' => $prods['category']['name'],'auth_expired_key'=>'eyJhbGciOiJFZERTQSIsInR5cCI6IkpXVCJ9.eyJzdWIiOiIxMjM0NTY3ODkwIiwibmFtZSI6IkpvaG4gRG9lIiwiYWRtaW4iOnRydWUsImlhdCI6MTUxNjIzOTAyMn0.JkKWCY39IdWEQttmdqR7VdsvT-_QxheW_eb0S5wr_j83ltux_JDUIXs7a3Dtn3xuqzuhetiuJrWIvy5TzimeCg',
                                        'category_id' => $prods['category']['id'],'product_id'=>$prods['id'] ]) }}">{{
                                            $prods['name'] }}</a></h3>

                                    <div class="price-row">
                                        <div class="prices">
                                            <span class="price-now">৳{{ $prods['sale_price'] }}</span>
                                            <span class="price-old">৳{{ $prods['regular_price'] }}</span>
                                        </div>

                                        <div class="product-action-1 show">
                                            <a aria-label="Add To Cart" class="action-btn hover-up" href="{{ route('Product_Cart_Add',
                                            ['product_name' => $prods['name'],'auth_expired_key'=>'eyJhbGciOiJFZERTQSIsInR5cCI6IkpXVCJ9.eR67Hyabjda0wIiwibmFtZSI6IkpvaG4gRG9lIiwiYWRtaW4iOnRydWUsImlhdCI6MTUxNjIzOTAyMn0.JkKWCY39IdWEQttmdqR7VdsvT-_QxheW_eb0S5wr_j83ltux_JDUIXs7a3Dtn3xuqzuhetiuJrWIvy5TzimeCg',
                                        'product_id'=>$prods['id'] ]) }}">

                                                <i class="fi-rs-shopping-bag-add"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                        @endforeach


                    </div>

                </div>
                <!--En tab three (New added)-->
            </div>
            <!--End tab-content-->
        </div>
    </section>








    {{-- Big Banner Add --}}
    <section class="banner-2 section-padding pb-0">
        <div class="container">
            <div class="banner-img banner-big wow fadeIn animated f-none">
                <img src="{{ asset('assets/uploads/Large Adv/Large Adv_Apon Plastic-1.png') }}" alt="">
                {{-- <div class="banner-text d-md-block d-none">
                    <h4 class="mb-15 mt-40 text-brand">Repair Services</h4>
                    <h1 class="fw-600 mb-20">We're an Apple <br>Authorised Service Provider</h1>
                    <a href="shop.html" class="btn">Learn More <i class="fi-rs-arrow-right"></i></a>
                </div> --}}
            </div>
        </div>
    </section>




    {{-- New 4/8 Section --}}
    <style>
        /* Ensure the row children have equal height */
        .row {
            display: flex;
            flex-wrap: wrap;
        }

        .full-height-banner {
            position: relative;
            /* This calculates height based on the parent col-md-3 height */
            height: calc(100% - 60px);
            /* Adjust 60px based on your section-title style-1 height + margin */
            min-height: 400px;
            /* Safety for mobile */
            overflow: hidden;
            border-radius: 15px;
            /* Matches standard theme styling */
        }

        .full-height-banner img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            /* This is the key: it crops the image to fill space without stretching */
            display: block;
        }

        .full-height-banner .banne_info {
            position: absolute;
            /* top: 30px;
            left: 30px; */
            z-index: 2;
        }

        /* Responsive adjustment: on small screens, let height be auto */
        @media (max-width: 768px) {
            .full-height-banner {
                height: 300px;
                margin-bottom: 30px;
            }
        }
    </style>


    <section class="mt-20">
        <div class="container">
            <div class="row">
                <div class="col-md-3">
                    <h3 class="section-title style-1 mb-20"><span>See</span> Promotion</h3>
                    <div class="side-banner full-height-banner">
                        <img src="{{ asset('assets/uploads/Left Side Adv Banner/Apon Plastic Left Side Adv Banner_Apon Plastic.png') }}"
                            alt="promotion_banner">
                        <div class="banne_info">
                            <h6>Limited Offer</h6>
                            <h4>Special <br>Collection</h4>
                            <a href="#">Shop now</a>
                        </div>
                    </div>

                </div>
                <div class="col-md-9">
                    {{-- 2nd section top part 1 --}}
                    <h3 class="section-title style-1 mb-20"><span>New</span> Arrivals</h3>
                    <div class="carausel-6-columns-cover position-relative">
                        <div class="carausel-6-columns carausel-arrow-center" id="carausel-6-1-columns-2">


                            @foreach ($newArrivals1stRow as $prod)
                            <div class="product-cart-wrap small hover-up">
                                <div class="product-img-action-wrap">
                                    <div class="product-img product-img-zoom">
                                        <a href="{{ route('Product_Details', ['product_name' => $prod['name'],'category_name' => $prod['category']['name'],'auth_expired_key'=>'eyJhbGciOiJFZERTQSIsInR5cCI6IkpXVCJ9.eyJzdWIiOiIxMjM0NTY3ODkwIiwibmFtZSI6IkpvaG4gRG9lIiwiYWRtaW4iOnRydWUsImlhdCI6MTUxNjIzOTAyMn0.JkKWCY39IdWEQttmdqR7VdsvT-_QxheW_eb0S5wr_j83ltux_JDUIXs7a3Dtn3xuqzuhetiuJrWIvy5TzimeCg',
                                        'category_id' => $prod['category']['id'],'product_id'=>$prod['id'] ]) }}">
                                            @foreach ($prod['media'] as $media)
                                            @if ($media['position'] == 0)
                                            <img class="default-img"
                                                src="{{ asset( $media['file_path']. $media['image_name'])}}" alt={{
                                                $media['image_name'] }}>
                                            @else

                                            <img class="hover-img"
                                                src="{{ asset( $media['file_path']. $media['image_name'])}}" alt={{
                                                $media['image_name'] }}>
                                            @endif

                                            @endforeach
                                        </a>
                                    </div>
                                    {{-- <div class="product-action-1">
                                        <a aria-label="Quick view" class="action-btn small hover-up"
                                            data-bs-toggle="modal" data-bs-target="#quickViewModal">
                                            <i class="fi-rs-eye"></i></a>
                                        <a aria-label="Add To Cart" class="action-btn hover-up" href="cart.html"><i
                                                class="fi-rs-shopping-bag-add"></i>

                                    </div> --}}
                                    <div class="product-badges product-badges-position product-badges-mrg">
                                        <span class="hot">New</span>
                                    </div>
                                </div>
                                <div class="product-content-wrap">
                                    <h2><a href="{{ route('Product_Details', ['product_name' => $prod['name'],'category_name' => $prod['category']['name'],'auth_expired_key'=>'eyJhbGciOiJFZERTQSIsInR5cCI6IkpXVCJ9.eyJzdWIiOiIxMjM0NTY3ODkwIiwibmFtZSI6IkpvaG4gRG9lIiwiYWRtaW4iOnRydWUsImlhdCI6MTUxNjIzOTAyMn0.JkKWCY39IdWEQttmdqR7VdsvT-_QxheW_eb0S5wr_j83ltux_JDUIXs7a3Dtn3xuqzuhetiuJrWIvy5TzimeCg',
                                        'category_id' => $prod['category']['id'],'product_id'=>$prod['id'] ]) }}">{{
                                            $prod['name'] }}</a></h2>

                                    <div class="product-price">
                                        <span>৳ {{ $prod['sale_price'] }} </span>
                                        <span class="old-price">৳ {{ $prod['regular_price'] }}</span>
                                    </div>
                                </div>
                            </div>
                            @endforeach

                            <!--End product-cart-wrap-2-->

                        </div>
                    </div>
                    {{-- 2nd section bottom part 2 --}}



                    <div class="carausel-6-columns-cover position-relative">
                        <div class="carausel-6-columns carausel-arrow-center" id="carausel-6-2-columns-2">
                            @foreach ($newArrivals2ndRow as $prod)
                            <div class="product-cart-wrap small hover-up">
                                <div class="product-img-action-wrap">
                                    <div class="product-img product-img-zoom">
                                        <a href="{{ route('Product_Details', ['product_name' => $prod['name'],'category_name' => $prod['category']['name'],'auth_expired_key'=>'eyJhbGciOiJFZERTQSIsInR5cCI6IkpXVCJ9.eyJzdWIiOiIxMjM0NTY3ODkwIiwibmFtZSI6IkpvaG4gRG9lIiwiYWRtaW4iOnRydWUsImlhdCI6MTUxNjIzOTAyMn0.JkKWCY39IdWEQttmdqR7VdsvT-_QxheW_eb0S5wr_j83ltux_JDUIXs7a3Dtn3xuqzuhetiuJrWIvy5TzimeCg',
                                        'category_id' => $prod['category']['id'],'product_id'=>$prod['id'] ]) }}">
                                            @foreach ($prod['media'] as $media)
                                            @if ($media['position'] == 0)
                                            <img class="default-img"
                                                src="{{ asset( $media['file_path']. $media['image_name'])}}" alt={{
                                                $media['image_name'] }}>
                                            @else

                                            <img class="hover-img"
                                                src="{{ asset( $media['file_path']. $media['image_name'])}}" alt={{
                                                $media['image_name'] }}>
                                            @endif

                                            @endforeach
                                        </a>
                                    </div>
                                    {{-- <div class="product-action-1">
                                        <a aria-label="Quick view" class="action-btn small hover-up"
                                            data-bs-toggle="modal" data-bs-target="#quickViewModal">
                                            <i class="fi-rs-eye"></i></a>
                                        <a aria-label="Add To Cart" class="action-btn hover-up" href="cart.html"><i
                                                class="fi-rs-shopping-bag-add"></i>

                                    </div> --}}
                                    <div class="product-badges product-badges-position product-badges-mrg">
                                        <span class="hot">New</span>
                                    </div>
                                </div>
                                <div class="product-content-wrap">
                                    <h2><a href="{{ route('Product_Details', ['product_name' => $prod['name'],'category_name' => $prod['category']['name'],'auth_expired_key'=>'eyJhbGciOiJFZERTQSIsInR5cCI6IkpXVCJ9.eyJzdWIiOiIxMjM0NTY3ODkwIiwibmFtZSI6IkpvaG4gRG9lIiwiYWRtaW4iOnRydWUsImlhdCI6MTUxNjIzOTAyMn0.JkKWCY39IdWEQttmdqR7VdsvT-_QxheW_eb0S5wr_j83ltux_JDUIXs7a3Dtn3xuqzuhetiuJrWIvy5TzimeCg',
                                        'category_id' => $prod['category']['id'],'product_id'=>$prod['id'] ]) }}">{{
                                            $prod['name'] }}</a></h2>

                                    <div class="product-price">
                                        <span>৳ {{ $prod['sale_price'] }} </span>
                                        <span class="old-price">৳ {{ $prod['regular_price'] }}</span>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>




    {{-- New Arrivals Categories --}}
    <section class="popular-categories section-padding mt-15 mb-25">
        <div class="container wow fadeIn animated">
            <h3 class="section-title style-1 style-1 mb-20"><span>Most</span> Selling Product</h3>
            <div class="carausel-6-columns-cover position-relative">
                <div class="slider-arrow slider-arrow-2 carausel-6-columns-arrow" id="carausel-6-columns-arrows">
                </div>
                <div class="carausel-6-columns" id="carausel-6-columns">

                    @foreach ($mostSellingProducts as $prod)
                    <div class="card-1">
                        <figure class=" img-hover-scale overflow-hidden">
                            <a href="{{ route('Product_Details', ['product_name' => $prod['name'],'category_name' => $prod['category']['name'],'auth_expired_key'=>'eyJhbGciOiJFZERTQSIsInR5cCI6IkpXVCJ9.eyJzdWIiOiIxMjM0NTY3ODkwIiwibmFtZSI6IkpvaG4gRG9lIiwiYWRtaW4iOnRydWUsImlhdCI6MTUxNjIzOTAyMn0.JkKWCY39IdWEQttmdqR7VdsvT-_QxheW_eb0S5wr_j83ltux_JDUIXs7a3Dtn3xuqzuhetiuJrWIvy5TzimeCg',
                                        'category_id' => $prod['category']['id'],'product_id'=>$prod['id'] ]) }}">
                                @foreach ($prod['media'] as $media)
                                @if ($media['position'] == 0)
                                <img class="default-img" src="{{ asset( $media['file_path']. $media['image_name'])}}"
                                    alt={{ $media['image_name'] }}>

                                @endif

                                @endforeach
                            </a>
                        </figure>
                        <h5><a href="{{ route('Product_Details', ['product_name' => $prod['name'],'category_name' => $prod['category']['name'],'auth_expired_key'=>'eyJhbGciOiJFZERTQSIsInR5cCI6IkpXVCJ9.eyJzdWIiOiIxMjM0NTY3ODkwIiwibmFtZSI6IkpvaG4gRG9lIiwiYWRtaW4iOnRydWUsImlhdCI6MTUxNjIzOTAyMn0.JkKWCY39IdWEQttmdqR7VdsvT-_QxheW_eb0S5wr_j83ltux_JDUIXs7a3Dtn3xuqzuhetiuJrWIvy5TzimeCg',
                                        'category_id' => $prod['category']['id'],'product_id'=>$prod['id'] ]) }}">{{
                                $prod['name'] }}</a></h5>
                    </div>
                    @endforeach






                </div>
            </div>
        </div>
    </section>




    {{-- 3 small Banner Add --}}
    <section class="banners mb-15">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 col-md-6">
                    <div class="banner-img wow fadeIn animated">
                        <img src="{{asset('assets/uploads/Right Banner/Pink and Blue Modern Aesthetic Fashion Facebook Cover.png')}}"
                            alt="menu_banner1">

                        <div class="banner-text">
                            <span>Smart Offer</span>
                            <h4>Save 20% on <br>Woman Bag</h4>
                            <a href="shop.html">Shop Now <i class="fi-rs-arrow-right"></i></a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="banner-img wow fadeIn animated">
                        <img src="{{asset('assets/uploads/Right Banner/Pink and Blue Modern Aesthetic Fashion Facebook Cover.png')}}"
                            alt="menu_banner1">

                        <div class="banner-text">
                            <span>Sale off</span>
                            <h4>Great Summer <br>Collection</h4>
                            <a href="shop.html">Shop Now <i class="fi-rs-arrow-right"></i></a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 d-md-none d-lg-flex">
                    <div class="banner-img wow fadeIn animated  mb-sm-0">
                        <img src="{{asset('assets/uploads/Right Banner/Right banner_Apon Plastic.png')}}"
                            alt="menu_banner1">

                        <div class="banner-text">
                            <span>New Arrivals</span>
                            <h4>Shop Today’s <br>Deals & Offers</h4>
                            <a href="shop.html">Shop Now <i class="fi-rs-arrow-right"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>




    {{-- New Arrival Product --}}
    <section class="section-padding">
        <div class="container wow fadeIn animated">
            <h3 class="section-title style-1 mb-20"><span>Most</span> Popular Product</h3>
            <div class="carausel-6-columns-cover position-relative">
                <div class="slider-arrow slider-arrow-2 carausel-6-columns-arrow" id="carausel-6-columns-2-arrows">
                </div>
                <div class="carausel-6-columns carausel-arrow-center" id="carausel-6-columns-2">


                    @foreach ($mostPopularProducts as $prod)
                    <div class="product-cart-wrap small hover-up">
                        <div class="product-img-action-wrap">
                            <div class="product-img product-img-zoom">
                                <a href="{{ route('Product_Details', ['product_name' => $prod['name'],'category_name' => $prod['category']['name'],'auth_expired_key'=>'eyJhbGciOiJFZERTQSIsInR5cCI6IkpXVCJ9.eyJzdWIiOiIxMjM0NTY3ODkwIiwibmFtZSI6IkpvaG4gRG9lIiwiYWRtaW4iOnRydWUsImlhdCI6MTUxNjIzOTAyMn0.JkKWCY39IdWEQttmdqR7VdsvT-_QxheW_eb0S5wr_j83ltux_JDUIXs7a3Dtn3xuqzuhetiuJrWIvy5TzimeCg',
                                        'category_id' => $prod['category']['id'],'product_id'=>$prod['id'] ]) }}">
                                    @foreach ($prod['media'] as $media)
                                    @if ($media['position'] == 0)
                                    <img class="default-img"
                                        src="{{ asset( $media['file_path']. $media['image_name'])}}" alt={{
                                        $media['image_name'] }}>
                                    @else

                                    <img class="hover-img" src="{{ asset( $media['file_path']. $media['image_name'])}}"
                                        alt={{ $media['image_name'] }}>
                                    @endif

                                    @endforeach
                                </a>
                            </div>
                            {{-- <div class="product-action-1">
                                <a aria-label="Quick view" class="action-btn small hover-up" data-bs-toggle="modal"
                                    data-bs-target="#quickViewModal">
                                    <i class="fi-rs-eye"></i></a>
                                <a aria-label="Add To Wishlist" class="action-btn small hover-up" href="wishlist.php"
                                    tabindex="0"><i class="fi-rs-heart"></i></a>
                                <a aria-label="Compare" class="action-btn small hover-up" href="compare.php"
                                    tabindex="0"><i class="fi-rs-shuffle"></i></a>
                            </div> --}}
                            <div class="product-badges product-badges-position product-badges-mrg">
                                <span class="hot">Popular</span>
                            </div>
                        </div>
                        <div class="product-content-wrap">
                            <h2><a href="{{ route('Product_Details', ['product_name' => $prod['name'],'category_name' => $prod['category']['name'],'auth_expired_key'=>'eyJhbGciOiJFZERTQSIsInR5cCI6IkpXVCJ9.eyJzdWIiOiIxMjM0NTY3ODkwIiwibmFtZSI6IkpvaG4gRG9lIiwiYWRtaW4iOnRydWUsImlhdCI6MTUxNjIzOTAyMn0.JkKWCY39IdWEQttmdqR7VdsvT-_QxheW_eb0S5wr_j83ltux_JDUIXs7a3Dtn3xuqzuhetiuJrWIvy5TzimeCg',
                                        'category_id' => $prod['category']['id'],'product_id'=>$prod['id'] ]) }}">{{
                                    $prod['name'] }}</a></h2>
                            @php
                            // Example: $rating = 4.5;
                            $rating = $prod['reviews_avg_rating'] ?? 0;
                            @endphp

                            <div style="display: flex; gap: 8px;">

                                <div>
                                    @for ($i = 1; $i <= 5; $i++) @if ($i <=$rating) {{-- Full Star --}} <i
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
                            <div class="product-price">
                                <span>৳ {{ $prod['sale_price'] }} </span>
                                <span class="old-price">৳ {{ $prod['regular_price'] }}</span>
                            </div>
                        </div>
                    </div>
                    <!--End product-cart-wrap-2-->
                    @endforeach






                </div>
            </div>
        </div>
    </section>




    {{-- Featured Brands --}}
    {{-- <section class="section-padding">
        <div class="container">
            <h3 class="section-title style-1 mb-20 wow fadeIn animated"><span>Featured</span> Brands</h3>
            <div class="carausel-6-columns-cover position-relative wow fadeIn animated">
                <div class="slider-arrow slider-arrow-2 carausel-6-columns-arrow" id="carausel-6-columns-3-arrows">
                </div>
                <div class="carausel-6-columns text-center" id="carausel-6-columns-3">
                    <div class="brand-logo">
                        <img class="img-grey-hover" src="assets/imgs/banner/brand-1.png" alt="">
                    </div>
                    <div class="brand-logo">
                        <img class="img-grey-hover" src="assets/imgs/banner/brand-2.png" alt="">
                    </div>
                    <div class="brand-logo">
                        <img class="img-grey-hover" src="assets/imgs/banner/brand-3.png" alt="">
                    </div>
                    <div class="brand-logo">
                        <img class="img-grey-hover" src="assets/imgs/banner/brand-4.png" alt="">
                    </div>
                    <div class="brand-logo">
                        <img class="img-grey-hover" src="assets/imgs/banner/brand-5.png" alt="">
                    </div>
                    <div class="brand-logo">
                        <img class="img-grey-hover" src="assets/imgs/banner/brand-6.png" alt="">
                    </div>
                    <div class="brand-logo">
                        <img class="img-grey-hover" src="assets/imgs/banner/brand-3.png" alt="">
                    </div>
                </div>
            </div>
        </div>
    </section> --}}

</main>
@endsection
