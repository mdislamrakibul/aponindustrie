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

    /* Badges */
    .badges {
        position: absolute;
        top: 10px;
        left: 10px;
        z-index: 10;
    }

    .badge {
        padding: 2px 5px;
        border-radius: 20px 0 20px 0;
        color: #fff;
        font-size: 11px;
        display: block;
        margin-bottom: 4px;
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
        background: #3b3b3b !important;
    }
</style>

<header class="header-area header-style-1 header-height-2">

    <div class="header-top header-top-ptb-1 d-none d-lg-block" style="padding: 1px 0 !important">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-xl-2 col-lg-4">
                    <div class="header-info">
                        <ul>
                            <li>
                                <a title="Hotline: (+880)1330-473873" href="tel:+8801330473873"
                                    style="color: #ed4943 !important"><span
                                        class="icon label-before fa fa-phone"></span>Hotline: (+880)1330-473873</a>

                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-xl-8 col-lg-4">
                    <div class="text-center">
                        <div class="news-ticker-wrapper">
                            <div class="marquee-viewport">
                                <div class="marquee-content">
                                    <div class="news-list">
                                        <span class="news-item">🔥 Get great devices up to 50% off
                                            {{-- <a href="#">View details</a> --}}
                                        </span>
                                        <span class="news-item">📈 Super Value Deals - Save more with
                                            coupons.</span>
                                        <span class="news-item">🌍 Trendy silver jewelry, save up 35% off today
                                            {{-- <a href="#">Shop now</a> --}}
                                        </span>
                                    </div>
                                    <div class="news-list">
                                        <span class="news-item">🔥 Get great devices up to 50% off
                                            {{-- <a href="#">View details</a> --}}
                                        </span>
                                        <span class="news-item">📈 Super Value Deals - Save more with
                                            coupons.</span>
                                        <span class="news-item">🌍 Trendy silver jewelry, save up 35% off today
                                            {{-- <a href="#">Shop now</a> --}}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-2 col-lg-4">
                    <div class="header-info header-info-right">
                        <ul>
                            <li><i class="fa fa-unlock"></i><a href="#" style="    padding: 0px !important;">Log In </a>
                                / <i class="fa fa-lock" style="padding-left: 5px !important;"></i><a href="#"
                                    style="    padding: 0px !important;">Sign
                                    Up</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>




    <div class="header-middle header-middle-ptb-1 d-none d-lg-block" style="padding: 10px 0 0 0 !important">
        <div class="container">
            <div class="header-wrap">
                <div class="logo logo-width-1">
                    <a href="{{ route('home.index') }}"><img src="{{ asset('assets/imgs/logo/logo.png') }}"
                            alt="logo"></a>
                </div>
                <div class="header-right">
                    <div class="search-style-1">
                        <form action="#">
                            <input type="text" placeholder="Search for items...">
                        </form>
                    </div>
                    <div class="header-action-right">

                        <style>
                            .wrap-icon-section {
                                display: inline-block;
                                /* width: 50%; */
                                float: left;
                            }

                            .wrap-icon-section .left-info {
                                display: block;
                                float: left;
                            }

                            .wrap-icon-section .link-direction>i {
                                display: block;
                                float: left;
                                font-size: 25px;
                                color: #aaa;
                                margin: 7px 8px 0 0;
                            }

                            .wrap-icon-section .index {
                                color: #fff;
                                font-size: 12px;
                                line-height: 12px;
                                display: block;
                                background: #888;
                                padding: 1.5px 7px;
                                border-radius: 2px;
                            }

                            .wrap-icon-section .title {
                                font-size: 12px;
                                color: #333333;
                                text-transform: uppercase;
                                font-weight: 600;
                                display: block;
                            }

                            .wrap-icon-section.minicart .index {
                                background: #ff2832;
                            }

                            .force_active {
                                color: #f15412;
                            }
                        </style>


                        <div class="header-action-2 wrap-icon right-section">

                            <div class="header-action-icon-2 wrap-icon-section minicart">
                                <a href="#" class="link-direction">
                                    <i class="fa fa-shopping-basket" aria-hidden="true"></i>
                                    <div class="left-info">
                                        <span class="index">
                                            @if(session('cart') && count(session('cart')) > 0)
                                            {{ count(session('cart')) }}
                                            @else
                                            0
                                            @endif item</span>
                                        <span class="title">CART</span>
                                    </div>

                                </a>

                                <div class="cart-dropdown-wrap cart-dropdown-hm2">


                                    @if (session('cart') && count(session('cart')) > 0)
                                    <ul>
                                        @foreach ( session('cart') as $cart)
                                        <li>
                                            <div class="shopping-cart-img">
                                                <a href="product-details.html">

                                                    @foreach ($cart['product']['media'] as $media)
                                                    @if ($media['position'] == 0)
                                                    <img src="{{ asset( $media['file_path']. $media['image_name'])}}"
                                                        alt={{ $media['image_name'] }}>
                                                    @endif
                                                    @endforeach

                                            </div>
                                            <div class="shopping-cart-title">
                                                <h4><a href="product-details.html">{{ $cart['product']['name'] }}</a>
                                                </h4>
                                                <h4><span>{{ $cart['quantity'] }} × </span>৳{{
                                                    number_format($cart['price'],2) }}</h4>
                                            </div>
                                            <div class="shopping-cart-delete">
                                                <a href="#"><i class="fi-rs-cross-small"></i></a>
                                            </div>
                                        </li>
                                        @endforeach


                                    </ul>
                                    <div class="shopping-cart-footer">
                                        <div class="shopping-cart-total">
                                            <h4>Total <span>৳
                                                    @php
                                                    $subtotal = collect(session('cart'))->sum(function ($item) {
                                                    return $item['price'] * $item['quantity'];
                                                    });

                                                    @endphp
                                                    {{ number_format($subtotal,2) }}
                                                </span></h4>
                                        </div>
                                        <div class="shopping-cart-button">
                                            <a href="{{ route('Product_Cart') }}" class="outline">View cart</a>
                                            <a href="{{ route('Product_Checkout') }}">Checkout</a>
                                        </div>
                                    </div>
                                    @else
                                    No Items
                                    @endif

                                </div>
                            </div>

                            <div class="wrap-icon-section show-up-after-1024">
                                <a href="#" class="mobile-navigation">
                                    <span></span>
                                    <span></span>
                                    <span></span>
                                </a>
                            </div>
                        </div>

                        {{-- <div class="header-action-2 wrap-icon right-section">
                            <div class="header-action-icon-2 wrap-icon-section wishlist">
                                <a href="shop-wishlist.php" class="link-direction">

                                    <i class="fa fa-heart" aria-hidden="true"></i>
                                    <div class="left-info">
                                        <span class="index">0 item</span>
                                        <span class="title">Wishlist</span>
                                    </div>
                                </a>
                            </div>
                            <div class="header-action-icon-2 wrap-icon-section minicart">
                                <a class="mini-cart-icon link-direction" href="cart.html">

                                    <i class="fa fa-shopping-basket" aria-hidden="true"></i>
                                    <div class="left-info">
                                        <span class="index">4 items</span>
                                        <span class="title">CART</span>
                                    </div>
                                </a>
                                <div class="cart-dropdown-wrap cart-dropdown-hm2">
                                    <ul>
                                        <li>
                                            <div class="shopping-cart-img">
                                                <a href="product-details.html"><img alt="Surfside Media"
                                                        src="assets/imgs/shop/thumbnail-3.jpg"></a>
                                            </div>
                                            <div class="shopping-cart-title">
                                                <h4><a href="product-details.html">Daisy Casual Bag</a></h4>
                                                <h4><span>1 × </span>৳800.00</h4>
                                            </div>
                                            <div class="shopping-cart-delete">
                                                <a href="#"><i class="fi-rs-cross-small"></i></a>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="shopping-cart-img">
                                                <a href="product-details.html"><img alt="Surfside Media"
                                                        src="assets/imgs/shop/thumbnail-2.jpg"></a>
                                            </div>
                                            <div class="shopping-cart-title">
                                                <h4><a href="product-details.html">Corduroy Shirts</a></h4>
                                                <h4><span>1 × </span>৳3200.00</h4>
                                            </div>
                                            <div class="shopping-cart-delete">
                                                <a href="#"><i class="fi-rs-cross-small"></i></a>
                                            </div>
                                        </li>
                                    </ul>
                                    <div class="shopping-cart-footer">
                                        <div class="shopping-cart-total">
                                            <h4>Total <span>৳4000.00</span></h4>
                                        </div>
                                        <div class="shopping-cart-button">
                                            <a href="cart.html" class="outline">View cart</a>
                                            <a href="checkout.html">Checkout</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div> --}}
                    </div>
                </div>
            </div>
        </div>
    </div>



    <nav class="featured-menu">
        <div class="menu-container">
            <a href="{{ route('Weekly_Featured') }}"
                class="{{ Route::is('Weekly_Featured') ? 'force_active menu-item' : 'menu-item' }}">
                WEEKLY FEATURED <span class="badge">HOT</span>
            </a>
            <a href="{{ route('Hot_Sale_Item') }}"
                class="{{ Route::is('Hot_Sale_Item') ? 'force_active menu-item' : 'menu-item' }}">
                HOT SALE ITEMS <span class="badge">HOT</span>
            </a>
            <a href="{{ route('Top_New_Items') }}"
                class="{{ Route::is('Top_New_Items') ? 'force_active menu-item' : 'menu-item' }}">
                TOP NEW ITEMS <span class="badge">HOT</span>
            </a>
            <a href="{{ route('Top_Selling') }}"
                class="{{ Route::is('Top_Selling') ? 'force_active menu-item' : 'menu-item' }}">
                TOP SELLING <span class="badge">HOT</span>
            </a>
            <a href="{{ route('Top_Rated_Item') }}"
                class="{{ Route::is('Top_Rated_Item') ? 'force_active menu-item' : 'menu-item' }}">
                TOP RATED ITEMS <span class="badge">HOT</span>
            </a>
        </div>
    </nav>

    <div class="header-bottom header-bottom-bg-color sticky-bar">
        <div class="container">
            <div class="header-wrap header-space-between position-relative">
                <div class="logo logo-width-1 d-block d-lg-none">
                    <a href="index.html"><img src="assets/imgs/logo/logo.png" alt="logo"></a>
                </div>
                <div class="header-nav d-none d-lg-flex">
                    <div class="main-categori-wrap d-none d-lg-block">
                        <a class="categori-button-active" href="#">
                            <span class="fi-rs-apps"></span> Browse Categories
                        </a>
                        <div class="categori-dropdown-wrap categori-dropdown-active-large">

                            <ul>

                                @foreach( $menuItems as $item)
                                <li class="has-children">
                                    <a href="{{ route('Product_By_Category', ['category_name' => $item->name,'auth_expired_key'=>'eyJhbGciOiJFZERTQSIsInR5cCI6IkpXVCJ9.eyJzdWIiOiIxMjM0NTY3ODkwIiwibmFtZSI6IkpvaG4gRG9lIiwiYWRtaW4iOnRydWUsImlhdCI6MTUxNjIzOTAyMn0.JkKWCY39IdWEQttmdqR7VdsvT-_QxheW_eb0S5wr_j83ltux_JDUIXs7a3Dtn3xuqzuhetiuJrWIvy5TzimeCg',
                                        'category_id' => $item->id, ]) }}"><i class="surfsidemedia-font-dress"></i>{{
                                        $item->name }}</a>
                                    @if($item->childrenRecursive && $item->childrenRecursive->isNotEmpty())
                                    <div class="dropdown-menu">
                                        <ul class="mega-menu d-lg-flex">
                                            <li class="mega-menu-col col-lg-7">
                                                <ul class="d-lg-flex">
                                                    <li class="mega-menu-col col-lg-6">
                                                        <ul>
                                                            <li><span class="submenu-title">Types</span> </li>
                                                            @foreach($item->childrenRecursive as $child)
                                                            <li>
                                                                <a class="dropdown-item nav-link nav_item"
                                                                    href="{{ route('Product_By_Category', ['category_name' => $item->name,'sub_category_name' => $child->name,'auth_expired_key'=>'eyJhbGciOiJFZERTQSIsInR5cCI6IkpXVCJ9.eyJzdWIiOiIxMjM0NTY3ODkwIiwibmFtZSI6IkpvaG4gRG9lIiwiYWRtaW4iOnRydWUsImlhdCI6MTUxNjIzOTAyMn0.JkKWCY39IdWEQttmdqR7VdsvT-_QxheW_eb0S5wr_j83ltux_JDUIXs7a3Dtn3xuqzuhetiuJrWIvy5TzimeCg',
                                                            'sub_category_id' => $child->id,'category_id' => $item->id,]) }}">{{
                                                                    $child->name }}</a>
                                                            </li>
                                                            @endforeach

                                                        </ul>
                                                    </li>

                                                </ul>
                                            </li>
                                            {{-- <li class="mega-menu-col col-lg-5">
                                                <div class="header-banner2">
                                                    <img
                                                    src="{{ asset('assets/uploads/Right Banner/Right banner_Apon Plastic-1-min.png')}}"
                                                        alt="menu_banner1">
                                                    <div class="banne_info">
                                                        <h6>10% Off</h6>
                                                        <h4>New Arrival</h4>
                                                        <a href="#">Shop now</a>
                                                    </div>
                                                </div>
                                                <div class="header-banner2">
                                                    <img src="{{ asset('assets/uploads/Right Banner/Right banner_Apon Plastic-min.png')}}"
                                                        alt="menu_banner2">
                                                    <div class="banne_info">
                                                        <h6>15% Off</h6>
                                                        <h4>Hot Deals</h4>
                                                        <a href="#">Shop now</a>
                                                    </div>
                                                </div>
                                            </li> --}}
                                        </ul>
                                    </div>
                                    @else
                                    {{-- <p>No sub-categories found.</p> --}}
                                    @endif

                                </li>

                                @endforeach
                            </ul>
                            {{-- <ul>

                                <li class="has-children">
                                    <a href="shop.html"><i class="surfsidemedia-font-tshirt"></i>Thinwall Container</a>
                                    <div class="dropdown-menu">
                                        <ul class="mega-menu d-lg-flex">
                                            <li class="mega-menu-col col-lg-7">
                                                <ul class="d-lg-flex">
                                                    <li class="mega-menu-col col-lg-6">
                                                        <ul>
                                                            <li><span class="submenu-title">Types</span>
                                                            </li>
                                                            <li><a class="dropdown-item nav-link nav_item"
                                                                    href="#">Natural/Transparent</a></li>
                                                            <li><a class="dropdown-item nav-link nav_item"
                                                                    href="#">White</a></li>

                                                        </ul>
                                                    </li>

                                                </ul>
                                            </li>
                                            <li class="mega-menu-col col-lg-5">
                                                <div class="header-banner2">
                                                    <img src="{{ asset('assets/uploads/Left Side Adv Banner/Apon Plastic Left Side Adv Banner_Apon Plastic.png') }}"
                                                        alt="menu_banner1">
                                                    <div class="banne_info">
                                                        <h6>10% Off</h6>
                                                        <h4>New Arrival</h4>
                                                        <a href="#">Shop now</a>
                                                    </div>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                </li>

                                <li class="has-children">
                                    <a href="shop.html"><i class="surfsidemedia-font-tshirt"></i>Sauce Cup</a>
                                    <div class="dropdown-menu">
                                        <ul class="mega-menu d-lg-flex">
                                            <li class="mega-menu-col col-lg-7">
                                                <ul class="d-lg-flex">
                                                    <li class="mega-menu-col col-lg-6">
                                                        <ul>
                                                            <li><span class="submenu-title">Types</span>
                                                            </li>
                                                            <li><a class="dropdown-item nav-link nav_item"
                                                                    href="#">Natural/Transparent</a></li>


                                                        </ul>
                                                    </li>

                                                </ul>
                                            </li>
                                            <li class="mega-menu-col col-lg-5">
                                                <div class="header-banner2">
                                                    <img src="{{ asset('assets/uploads/Left Side Adv Banner/Apon Plastic Left Side Adv Banner_Apon Plastic.png') }}"
                                                        alt="menu_banner1">
                                                    <div class="banne_info">
                                                        <h6>10% Off</h6>
                                                        <h4>New Arrival</h4>
                                                        <a href="#">Shop now</a>
                                                    </div>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                </li>
                                <li><a href="shop.html"><i class="surfsidemedia-font-cpu"></i>Bucket</a></li>
                                <li><a href="shop.html"><i class="surfsidemedia-font-diamond"></i>Spoon</a></li>
                                <li><a href="shop.html"><i class="surfsidemedia-font-home"></i>Crusher</a>
                                </li>
                                <li><a href="shop.html"><i class="surfsidemedia-font-high-heels"></i>Hanger</a></li>
                                <li><a href="shop.html"><i class="surfsidemedia-font-teddy-bear"></i>Roll Box</a></li>
                                <li><a href="shop.html"><i class="surfsidemedia-font-kite"></i>Box</a></li>

                            </ul> --}}
                            {{-- <div class="more_categories">Show more...</div> --}}
                        </div>
                    </div>
                    <div class="main-menu main-menu-padding-1 main-menu-lh-2 d-none d-lg-block">
                        <nav>
                            <ul>
                                <li><a class="active" href="{{ route('home.index') }}"> <span class="fa fa-home"></span>
                                        Home </a>
                                </li>
                                {{-- <li><a href="{{ route('about_us.index') }}">About</a></li> --}}
                                {{-- <li><a href="shop.html">Shop</a></li> --}}
                                {{-- <li class="position-static"><a href="#">Our Collections <i
                                            class="fi-rs-angle-down"></i></a>
                                    <ul class="mega-menu">
                                        <li class="sub-mega-menu sub-mega-menu-width-22">
                                            <a class="menu-title" href="#">Women's Fashion</a>
                                            <ul>
                                                <li><a href="product-details.html">Dresses</a></li>
                                                <li><a href="product-details.html">Blouses & Shirts</a></li>
                                                <li><a href="product-details.html">Hoodies & Sweatshirts</a></li>
                                                <li><a href="product-details.html">Wedding Dresses</a></li>
                                                <li><a href="product-details.html">Prom Dresses</a></li>
                                                <li><a href="product-details.html">Cosplay Costumes</a></li>
                                            </ul>
                                        </li>
                                        <li class="sub-mega-menu sub-mega-menu-width-22">
                                            <a class="menu-title" href="#">Men's Fashion</a>
                                            <ul>
                                                <li><a href="product-details.html">Jackets</a></li>
                                                <li><a href="product-details.html">Casual Faux Leather</a></li>
                                                <li><a href="product-details.html">Genuine Leather</a></li>
                                                <li><a href="product-details.html">Casual Pants</a></li>
                                                <li><a href="product-details.html">Sweatpants</a></li>
                                                <li><a href="product-details.html">Harem Pants</a></li>
                                            </ul>
                                        </li>
                                        <li class="sub-mega-menu sub-mega-menu-width-22">
                                            <a class="menu-title" href="#">Technology</a>
                                            <ul>
                                                <li><a href="product-details.html">Gaming Laptops</a></li>
                                                <li><a href="product-details.html">Ultraslim Laptops</a></li>
                                                <li><a href="product-details.html">Tablets</a></li>
                                                <li><a href="product-details.html">Laptop Accessories</a></li>
                                                <li><a href="product-details.html">Tablet Accessories</a></li>
                                            </ul>
                                        </li>
                                        <li class="sub-mega-menu sub-mega-menu-width-34">
                                            <div class="menu-banner-wrap">
                                                <a href="product-details.html"><img
                                                        src="assets/imgs/banner/menu-banner.jpg"
                                                        alt="Surfside Media"></a>
                                                <div class="menu-banner-content">
                                                    <h4>Hot deals</h4>
                                                    <h3>Don't miss<br> Trending</h3>
                                                    <div class="menu-banner-price">
                                                        <span class="new-price text-success">Save to 50%</span>
                                                    </div>
                                                    <div class="menu-banner-btn">
                                                        <a href="product-details.html">Shop now</a>
                                                    </div>
                                                </div>
                                                <div class="menu-banner-discount">
                                                    <h3>
                                                        <span>35%</span>
                                                        off
                                                    </h3>
                                                </div>
                                            </div>
                                        </li>
                                    </ul>
                                </li> --}}
                                {{-- <li><a href="blog.html">Blog </a></li>
                                <li><a href="contact.html">Contact</a></li>
                                <li><a href="#">My Account<i class="fi-rs-angle-down"></i></a>
                                    <ul class="sub-menu">
                                        <li><a href="#">Dashboard</a></li>
                                        <li><a href="#">Products</a></li>
                                        <li><a href="#">Categories</a></li>
                                        <li><a href="#">Coupons</a></li>
                                        <li><a href="#">Orders</a></li>
                                        <li><a href="#">Customers</a></li>
                                        <li><a href="#">Logout</a></li>
                                    </ul>
                                </li> --}}
                            </ul>
                        </nav>
                    </div>
                </div>
                <div class="hotline d-none d-lg-block">
                    {{-- <p><i class="fi-rs-smartphone"></i><span>Toll Free</span> (+1) 0000-000-000 </p> --}}
                </div>
                {{-- <p class="mobile-promotion">Happy <span class="text-brand">Mother's Day</span>. Big Sale Up to 40%
                </p> --}}
                <div class="header-action-right d-block d-lg-none">
                    <div class="header-action-2">
                        <div class="header-action-icon-2">
                            {{-- <a href="shop-wishlist.php">
                                <img alt="Surfside Media" src="assets/imgs/theme/icons/icon-heart.svg">
                                <span class="pro-count white">4</span>
                            </a> --}}
                        </div>
                        <div class="header-action-icon-2">
                            <a class="mini-cart-icon" href="{{ route('Product_Cart') }}">
                                <img alt="Surfside Media" src="assets/imgs/theme/icons/icon-cart.svg">
                                <span class="pro-count white">
                                     @if(session('cart') && count(session('cart')) > 0)
                                            {{ count(session('cart')) }}
                                            @else
                                            0
                                            @endif
                                </span>
                            </a>
                            <div class="cart-dropdown-wrap cart-dropdown-hm2">
                                @if (session('cart') && count(session('cart')) > 0)
                                    <ul>
                                        @foreach ( session('cart') as $cart)
                                        <li>
                                            <div class="shopping-cart-img">
                                                <a href="product-details.html">

                                                    @foreach ($cart['product']['media'] as $media)
                                                    @if ($media['position'] == 0)
                                                    <img src="{{ asset( $media['file_path']. $media['image_name'])}}"
                                                        alt={{ $media['image_name'] }}>
                                                    @endif
                                                    @endforeach

                                            </div>
                                            <div class="shopping-cart-title">
                                                <h4><a href="product-details.html">{{ $cart['product']['name'] }}</a>
                                                </h4>
                                                <h4><span>{{ $cart['quantity'] }} × </span>৳{{
                                                    number_format($cart['price'],2) }}</h4>
                                            </div>
                                            <div class="shopping-cart-delete">
                                                <a href="#"><i class="fi-rs-cross-small"></i></a>
                                            </div>
                                        </li>
                                        @endforeach


                                    </ul>
                                    <div class="shopping-cart-footer">
                                        <div class="shopping-cart-total">
                                            <h4>Total <span>৳
                                                    @php
                                                    $subtotal = collect(session('cart'))->sum(function ($item) {
                                                    return $item['price'] * $item['quantity'];
                                                    });

                                                    @endphp
                                                    {{ number_format($subtotal,2) }}
                                                </span></h4>
                                        </div>
                                        <div class="shopping-cart-button">
                                            <a href="{{ route('Product_Cart') }}" class="outline">View cart</a>
                                            <a href="{{ route('Product_Checkout') }}">Checkout</a>
                                        </div>
                                    </div>
                                    @else
                                    No Items
                                    @endif
                            </div>
                        </div>
                        <div class="header-action-icon-2 d-block d-lg-none">
                            <div class="burger-icon burger-icon-white">
                                <span class="burger-icon-top"></span>
                                <span class="burger-icon-mid"></span>
                                <span class="burger-icon-bottom"></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
