<div class="mobile-header-active mobile-header-wrapper-style">
    <div class="mobile-header-wrapper-inner">
        <div class="mobile-header-top">
            <div class="mobile-header-logo">
                <a href="{{ route('home.index') }}"><img src="{{ asset('assets/imgs/logo/logo.png') }}" alt="logo"></a>
            </div>
            <div class="mobile-menu-close close-style-wrap close-style-position-inherit">
                <button class="close-style search-close">
                    <i class="icon-top"></i>
                    <i class="icon-bottom"></i>
                </button>
            </div>
        </div>
        <div class="mobile-header-content-area">
            {{-- <div class="mobile-search search-style-3 mobile-header-border">
                <form action="#">
                    <input type="text" placeholder="Search for items…">
                    <button type="submit"><i class="fi-rs-search"></i></button>
                </form>
            </div> --}}
            <div class="mobile-menu-wrap mobile-header-border">
                <div class="main-categori-wrap mobile-header-border">
                    <a class="categori-button-active-2" href="#">
                        <span class="fi-rs-apps"></span> Browse Categories
                    </a>
                    <div class="categori-dropdown-wrap categori-dropdown-active-small">
                        <ul>
                            @foreach($menuItems as $item)
                                                        <li class="has-children">
                                                            <a href="{{ route('Product_By_Category', [
                                    'category_name' => $item->name,
                                    'auth_expired_key' => 'eyJhbGciOiJFZERTQSIsInR5cCI6IkpXVCJ9.eyJzdWIiOiIxMjM0NTY3ODkwIiwibmFtZSI6IkpvaG4gRG9lIiwiYWRtaW4iOnRydWUsImlhdCI6MTUxNjIzOTAyMn0.JkKWCY39IdWEQttmdqR7VdsvT-_QxheW_eb0S5wr_j83ltux_JDUIXs7a3Dtn3xuqzuhetiuJrWIvy5TzimeCg',
                                    'category_id' => $item->id,
                                ]) }}"><i class="surfsidemedia-font-dress"></i>{{
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
                                                                                                                                                href="{{ route('Product_By_Category', [
                                                                                                'category_name' => $item->name,
                                                                                                'sub_category_name' => $child->name,
                                                                                                'auth_expired_key' => 'eyJhbGciOiJFZERTQSIsInR5cCI6IkpXVCJ9.eyJzdWIiOiIxMjM0NTY3ODkwIiwibmFtZSI6IkpvaG4gRG9lIiwiYWRtaW4iOnRydWUsImlhdCI6MTUxNjIzOTAyMn0.JkKWCY39IdWEQttmdqR7VdsvT-_QxheW_eb0S5wr_j83ltux_JDUIXs7a3Dtn3xuqzuhetiuJrWIvy5TzimeCg',
                                                                                                'sub_category_id' => $child->id,
                                                                                                'category_id' => $item->id,
                                                                                            ]) }}">{{
                                                                                                $child->name }}</a>
                                                                                                                                        </li>
                                                                                        @endforeach

                                                                                    </ul>
                                                                                </li>

                                                                            </ul>
                                                                        </li>
                                                                        <li class="mega-menu-col col-lg-5">
                                                                            <div class="header-banner2">
                                                                                <img src="{{ asset('assets/uploads/Right Banner/Right banner_Apon Plastic-1-min.png')}}"
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
                                                                        </li>
                                                                    </ul>
                                                                </div>
                                                            @else
                                                                {{-- <p>No sub-categories found.</p> --}}
                                                            @endif

                                                        </li>

                            @endforeach
                        </ul>
                    </div>
                </div>
                <!-- mobile menu start -->
                <nav>
                    <ul class="mobile-menu">
                        <li class="menu-item-has-children"><span class="menu-expand"></span><a
                                href="{{ route('home.index') }}">Home</a></li>
                        <li class="menu-item-has-children"><span class="menu-expand"></span><a
                                href="{{ route('shop') }}">Shop</a></li>
                        {{-- <li class="menu-item-has-children"><span class="menu-expand"></span><a
                                href="shop.html">shop</a></li>
                        <li class="menu-item-has-children"><span class="menu-expand"></span><a href="#">Our
                                Collections</a>
                            <ul class="dropdown">
                                <li class="menu-item-has-children"><span class="menu-expand"></span><a href="#">Women's
                                        Fashion</a>
                                    <ul class="dropdown">
                                        <li><a href="product-details.html">Dresses</a></li>
                                        <li><a href="product-details.html">Blouses & Shirts</a></li>
                                        <li><a href="product-details.html">Hoodies & Sweatshirts</a></li>
                                        <li><a href="product-details.html">Women's Sets</a></li>
                                    </ul>
                                </li>
                                <li class="menu-item-has-children"><span class="menu-expand"></span><a href="#">Men's
                                        Fashion</a>
                                    <ul class="dropdown">
                                        <li><a href="product-details.html">Jackets</a></li>
                                        <li><a href="product-details.html">Casual Faux Leather</a></li>
                                        <li><a href="product-details.html">Genuine Leather</a></li>
                                    </ul>
                                </li>
                                <li class="menu-item-has-children"><span class="menu-expand"></span><a
                                        href="#">Technology</a>
                                    <ul class="dropdown">
                                        <li><a href="product-details.html">Gaming Laptops</a></li>
                                        <li><a href="product-details.html">Ultraslim Laptops</a></li>
                                        <li><a href="product-details.html">Tablets</a></li>
                                        <li><a href="product-details.html">Laptop Accessories</a></li>
                                        <li><a href="product-details.html">Tablet Accessories</a></li>
                                    </ul>
                                </li>
                            </ul>
                        </li> --}}
                        {{-- <li class="menu-item-has-children"><span class="menu-expand"></span><a
                                href="blog.html">Blog</a></li> --}}
                        {{-- <li class="menu-item-has-children"><span class="menu-expand"></span><a
                                href="#">Language</a>
                            <ul class="dropdown">
                                <li><a href="#">English</a></li>
                                <li><a href="#">French</a></li>
                                <li><a href="#">German</a></li>
                                <li><a href="#">Spanish</a></li>
                            </ul>
                        </li> --}}
                    </ul>
                </nav>
                <!-- mobile menu end -->
            </div>
            <div class="mobile-header-info-wrap mobile-header-border">
                {{-- <div class="single-mobile-header-info mt-30">
                    <a href="contact.html"> Our location </a>
                </div> --}}
                <div class="single-mobile-header-info">

                    @if(session()->has('user_id'))

                        @if(
                                session('user_role') == 'admin' ||
                                session('user_role') == 'vendor' ||
                                session('user_role') == 'cashier'
                            )

                            <a href="{{ session('user_role') === 'cashier' ? route('admin.orders.new.page') : url('/admin/dashboard') }}">
                                Dashboard
                            </a>

                        @endif

                        <a href="{{ route('customer.profile') }}" style="display:block; margin-top:10px;">My Account</a>

                        <form action="{{ route('logout') }}" method="POST" style="margin-top:10px;">
                            @csrf

                            <button type="submit"
                                style="background:none;border:none;padding:0;color:inherit;cursor:pointer;">
                                Logout
                            </button>
                        </form>

                    @else

                        <a href="{{ url('/login') }}">
                            Log In
                        </a>

                    @endif
                </div>
                <div class="single-mobile-header-info">
                    {{-- <a href="{{ url('/register') }}">Sign Up</a> --}}

                </div>
                <div class="single-mobile-header-info">
                    {{-- <a href="#">(+1) 0000-000-000 </a> --}}
                </div>
            </div>
            <div class="mobile-social-icon">
                <h5 class="mb-15 text-grey-4">Follow Us</h5>
                <a href="#"><img src="{{ asset('assets/imgs/theme/icons/icon-facebook.svg') }}" alt=""></a>
                <a href="#" title="X" style="display:inline-flex;align-items:center;">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="22" height="22" fill="#333033"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-4.714-6.231-5.401 6.231H2.746l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>
                </a>
                <a href="#"><img src="{{ asset('assets/imgs/theme/icons/icon-instagram.svg') }}" alt=""></a>
                <a href="#"><img src="{{ asset('assets/imgs/theme/icons/icon-pinterest.svg') }}" alt=""></a>
                <a href="#"><img src="{{ asset('assets/imgs/theme/icons/icon-youtube.svg') }}" alt=""></a>
            </div>
        </div>
    </div>
</div>