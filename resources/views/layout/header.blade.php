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

                                                    @foreach ($cart['product']['media'] as $media)
                                                    @if ($media['position'] == 0)
                                                    <img src="{{ asset( $media['file_path']. $media['image_name'])}}"
                                                        alt={{ $media['image_name'] }}>
                                                    @endif
                                                    @endforeach

                                            </div>
                                            <div class="shopping-cart-title">
                                                <h4>
                                                    <a
                                                        href="{{ route('Product_Details', ['product_name' => $cart['product']['name'],'category_name' => $cart['product']['category']['name'],'auth_expired_key'=>'eyJhbGciOiJFZERTQSIsInR5cCI6IkpXVCJ9.eyJzdWIiOiIxMjM0NTY3ODkwIiwibmFtZSI6IkpvaG4gRG9lIiwiYWRtaW4iOnRydWUsImlhdCI6MTUxNjIzOTAyMn0.JkKWCY39IdWEQttmdqR7VdsvT-_QxheW_eb0S5wr_j83ltux_JDUIXs7a3Dtn3xuqzuhetiuJrWIvy5TzimeCg',
                                                            'category_id' => $cart['product']['category']['id'],'product_id'=>$cart['product']['id'] ]) }}">{{
                                                        $cart['product']['name'] }}
                                                    </a>
                                                </h4>
                                                <h4>৳{{ number_format($cart['price'],2) }}</h4>
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
                    <a href="{{ route('home.index') }}"><img src="assets/imgs/logo/logo.png" alt="logo"></a>
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

                                        </ul>
                                    </div>
                                    @else

                                    @endif

                                </li>

                                @endforeach
                            </ul>

                        </div>
                    </div>
                    <div class="main-menu main-menu-padding-1 main-menu-lh-2 d-none d-lg-block">
                        <nav>
                            <ul>
                                <li><a class="active" href="{{ route('home.index') }}"> <span class="fa fa-home"></span>
                                        Home </a>
                                </li>

                            </ul>
                        </nav>
                    </div>
                </div>
                <div class="hotline d-none d-lg-block">
                </div>

                <div class="header-action-right d-block d-lg-none">
                    <div class="header-action-2">
                        <div class="header-action-icon-2">

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


                                            @foreach ($cart['product']['media'] as $media)
                                            @if ($media['position'] == 0)
                                            <img src="{{ asset( $media['file_path']. $media['image_name'])}}" alt={{
                                                $media['image_name'] }}>
                                            @endif
                                            @endforeach

                                        </div>
                                        <div class="shopping-cart-title">
                                            <h4>{{ $cart['product']['name'] }}</h4>
                                            <h4>৳{{ number_format($cart['price'],2) }}</h4>
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
