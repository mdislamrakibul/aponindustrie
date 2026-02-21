@extends('layout.master')

@section('title', 'E-Commerce')


@section('content')

<main class="main">
    <div class="page-header breadcrumb-wrap">
        <div class="container">
            <div class="breadcrumb">
                <a href="index.html" rel="nofollow">Home</a>
                @if ($category_name) <span></span> {{$category_name}}@endif
                @if ($sub_category_name) <span></span> {{$sub_category_name}}@endif

                {{-- <span></span> Fashion
                <span></span> Abstract Print Patchwork Dress --}}
            </div>
        </div>
    </div>
    <section class="mt-50 mb-50">
        <div class="container">
            <div class="row">
                <div class="col-lg-9">
                    <div class="product-detail accordion-detail">
                        <div class="row mb-50">
                            <div class="col-md-6 col-sm-12 col-xs-12">
                                <div class="detail-gallery">
                                    <span class="zoom-icon"><i class="fi-rs-search"></i></span>
                                    <!-- MAIN SLIDES -->
                                    <div class="product-image-slider">
                                        @foreach ($product->media as $media)
                                        <figure class="border-radius-10">
                                            <img src="{{ asset( $media['file_path']. $media['image_name'])}}" alt={{
                                                $media['image_name'] }}>
                                        </figure>

                                        @endforeach
                                        {{-- <figure class="border-radius-10">
                                            <img src="assets/imgs/shop/product-16-2.jpg" alt="product image">
                                        </figure>
                                        <figure class="border-radius-10">
                                            <img src="assets/imgs/shop/product-16-1.jpg" alt="product image">
                                        </figure>
                                        <figure class="border-radius-10">
                                            <img src="assets/imgs/shop/product-16-3.jpg" alt="product image">
                                        </figure>
                                        <figure class="border-radius-10">
                                            <img src="assets/imgs/shop/product-16-4.jpg" alt="product image">
                                        </figure>
                                        <figure class="border-radius-10">
                                            <img src="assets/imgs/shop/product-16-5.jpg" alt="product image">
                                        </figure>
                                        <figure class="border-radius-10">
                                            <img src="assets/imgs/shop/product-16-6.jpg" alt="product image">
                                        </figure>
                                        <figure class="border-radius-10">
                                            <img src="assets/imgs/shop/product-16-7.jpg" alt="product image">
                                        </figure> --}}
                                    </div>
                                    <!-- THUMBNAILS -->
                                    <div class="slider-nav-thumbnails pl-15 pr-15">
                                        @foreach ($product->media as $media)
                                        <div>
                                            <img src="{{ asset( $media['file_path']. $media['image_name'])}}" alt={{
                                                $media['image_name'] }}>
                                        </div>

                                        @endforeach
                                        {{-- <div><img src="assets/imgs/shop/thumbnail-3.jpg" alt="product image"></div>
                                        <div><img src="assets/imgs/shop/thumbnail-4.jpg" alt="product image"></div>
                                        <div><img src="assets/imgs/shop/thumbnail-5.jpg" alt="product image"></div>
                                        <div><img src="assets/imgs/shop/thumbnail-6.jpg" alt="product image"></div>
                                        <div><img src="assets/imgs/shop/thumbnail-7.jpg" alt="product image"></div>
                                        <div><img src="assets/imgs/shop/thumbnail-8.jpg" alt="product image"></div>
                                        <div><img src="assets/imgs/shop/thumbnail-9.jpg" alt="product image"></div> --}}
                                    </div>
                                </div>
                                <!-- End Gallery -->
                                <div class="social-icons single-share">
                                    <ul class="text-grey-5 d-inline-block">
                                        <li><strong class="mr-10">Share this:</strong></li>
                                        <li class="social-facebook"><a href="#"><img
                                                    src="assets/imgs/theme/icons/icon-facebook.svg" alt=""></a></li>
                                        <li class="social-twitter"> <a href="#"><img
                                                    src="assets/imgs/theme/icons/icon-twitter.svg" alt=""></a></li>
                                        <li class="social-instagram"><a href="#"><img
                                                    src="assets/imgs/theme/icons/icon-instagram.svg" alt=""></a>
                                        </li>
                                        <li class="social-linkedin"><a href="#"><img
                                                    src="assets/imgs/theme/icons/icon-pinterest.svg" alt=""></a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-12 col-xs-12">
                                <div class="detail-info">
                                    <h2 class="title-detail">{{ $product->name }}</h2>
                                    <div class="product-detail-rating">

                                        @if($product->brand)
                                        <div class="pro-details-brand">
                                            <span style="font-weight: bolder;"> Brands: <span style="color: #f15412;">{{
                                                    $product->brand->name }}</span></span>
                                        </div>
                                        @endif

                                        @if($product->category)
                                        <div class="pro-details-brand">
                                            <span style="font-weight: bolder;"> Category: <span style="color: #f15412;">{{
                                                    $product->category->name }}</span></span>
                                        </div>
                                        @endif

                                        @php
                                        // Example: $rating = 4.5;
                                        $rating = $product->reviews_avg_rating ?? 0;
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
                                                ({{number_format($rating, 1)}})
                                            </div>


                                            <span class="font-small ml-5 text-muted" style="font-weight: bolder;">

                                                @if ($product->review)
                                                 <span style="color: #f15412;">count($product->review) {{ count($product->review) > 9 ? "Reviews":
                                                "Review" }}</span>
                                                @else
                                                <span style="color: #f15412;">0 Review</span>
                                                @endif

                                            </span>
                                        </div>
                                    </div>
                                    <div class="clearfix product-price-cover">
                                        <div class="product-price primary-color float-left">
                                            <ins><span class="text-brand">৳{{ $product->sale_price }}</span></ins>
                                            <ins><span class="old-price font-md ml-15">৳{{ $product->regular_price
                                                    }}</span></ins>

                                            @if($product->is_discounted)
                                            <span class="save-price  font-md color3 ml-15" style="font-weight: bold">
                                                @if($product->discount_type == 'PERCENTAGE')
                                                {{-- Show percentage (e.g., 20% Off) --}}
                                                {{ number_format($product->discount_value, 0) }}% Off
                                                @elseif($product->discount_type == 'FLAT')
                                                {{-- Show flat amount (e.g., $50 Off) --}}
                                                ${{ number_format($product->discount_value, 0) }} Off
                                                @endif
                                            </span>
                                            @endif
                                            {{-- <span class="save-price  font-md color3 ml-15"
                                                style="font-weight: bold">25%
                                                Off/ $20 off</span> --}}
                                        </div>
                                    </div>
                                    <div class="bt-1 border-color-1 mt-15 mb-15"></div>
                                    <div class="short-desc mb-30">
                                        <p>{{$product->short_description}}</p>
                                    </div>
                                    <div class="product_sort_info font-xs mb-30">
                                        <ul>
                                            <li class=""><i class="fi-rs-crown mr-5"></i> 1 Year Brand Warranty</li>
                                            <li class=""><i class="fi-rs-refresh mr-5"></i> 30 Day Return Policy</li>
                                            <li><i class="fi-rs-credit-card mr-5"></i> Cash on Delivery available
                                            </li>
                                        </ul>

                                    </div>

                                    <div class="bt-1 border-color-1 mt-30 mb-30"></div>
                                    <div class="detail-extralink">
                                        <div class="detail-qty border radius">
                                            <a href="#" class="qty-down"><i class="fi-rs-angle-small-down"></i></a>
                                            <span class="qty-val">1</span>
                                            <a href="#" class="qty-up"><i class="fi-rs-angle-small-up"></i></a>
                                        </div>
                                        <div class="product-extra-link2">
                                            <a aria-label="Add To Cart" class="button button-add-to-cart" href="{{ route('Product_Cart_Add',
                                            ['product_name' =>$product->name,'auth_expired_key'=>'eyJhbGciOiJFZERTQSIsInR5cCI6IkpXVCJ9.eR67Hyabjda0wIiwibmFtZSI6IkpvaG4gRG9lIiwiYWRtaW4iOnRydWUsImlhdCI6MTUxNjIzOTAyMn0.JkKWCY39IdWEQttmdqR7VdsvT-_QxheW_eb0S5wr_j83ltux_JDUIXs7a3Dtn3xuqzuhetiuJrWIvy5TzimeCg',
                                        'product_id'=>$product->id ]) }}">
                                                Add to cart</a>

                                        </div>
                                    </div>
                                    <ul class="product-meta font-xs color-grey mt-50" style="font-weight: bold">
                                        <li class="mb-5">SKU: <a href="#">{{ $product->sku }}</a></li>
                                        @if (count(json_decode($product->tags))>0)
                                        <li class="mb-5">Tags:

                                            <a href="#" rel="tag">{{implode(', ', json_decode($product->tags))}}</a>

                                        </li>
                                        @endif

                                        <li>Availability:<span class="in-stock text-success ml-5">
                                                <span class="font-weight: bold">{{ $product->stock_quantity }}</span>
                                                Items In
                                                Stock</span></li>
                                    </ul>
                                </div>
                                <!-- Detail Info -->
                            </div>
                        </div>
                        <div class="tab-style3">
                            <ul class="nav nav-tabs text-uppercase">
                                <li class="nav-item">
                                    <a class="nav-link active" id="Description-tab" data-bs-toggle="tab"
                                        href="#Description">Description</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="Additional-info-tab" data-bs-toggle="tab"
                                        href="#Additional-info">Additional info</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="Reviews-tab" data-bs-toggle="tab" href="#Reviews">Reviews
                                        ({{ count($product->reviews) }})</a>
                                </li>
                            </ul>
                            <div class="tab-content shop_info_tab entry-main-content">
                                <div class="tab-pane fade show active" id="Description">
                                    <div class="">
                                        <p>Uninhibited carnally hired played in whimpered dear gorilla koala
                                            depending and much yikes off far quetzal goodness and from for grimaced
                                            goodness unaccountably and meadowlark near unblushingly crucial scallop
                                            tightly neurotic hungrily some and dear furiously this apart.</p>
                                        <p>Spluttered narrowly yikes left moth in yikes bowed this that grizzly much
                                            hello on spoon-fed that alas rethought much decently richly and wow
                                            against the frequent fluidly at formidable acceptably flapped
                                            besides and much circa far over the bucolically hey precarious goldfinch
                                            mastodon goodness gnashed a jellyfish and one however because.
                                        </p>
                                        <ul class="product-more-infor mt-30">
                                            <li><span>Type Of Packing</span> Bottle</li>
                                            <li><span>Color</span> Green, Pink, Powder Blue, Purple</li>
                                            <li><span>Quantity Per Case</span> 100ml</li>
                                            <li><span>Ethyl Alcohol</span> 70%</li>
                                            <li><span>Piece In One</span> Carton</li>
                                        </ul>
                                        <hr class="wp-block-separator is-style-dots">
                                        <p>Laconic overheard dear woodchuck wow this outrageously taut beaver hey
                                            hello far meadowlark imitatively egregiously hugged that yikes minimally
                                            unanimous pouted flirtatiously as beaver beheld above forward
                                            energetic across this jeepers beneficently cockily less a the raucously
                                            that magic upheld far so the this where crud then below after jeez
                                            enchanting drunkenly more much wow callously irrespective limpet.</p>
                                        <h4 class="mt-30">Packaging & Delivery</h4>
                                        <hr class="wp-block-separator is-style-wide">
                                        <p>Less lion goodness that euphemistically robin expeditiously bluebird
                                            smugly scratched far while thus cackled sheepishly rigid after due one
                                            assenting regarding censorious while occasional or this more crane
                                            went more as this less much amid overhung anathematic because much held
                                            one exuberantly sheep goodness so where rat wry well concomitantly.
                                        </p>
                                        <p>Scallop or far crud plain remarkably far by thus far iguana lewd
                                            precociously and and less rattlesnake contrary caustic wow this near
                                            alas and next and pled the yikes articulate about as less cackled
                                            dalmatian
                                            in much less well jeering for the thanks blindly sentimental whimpered
                                            less across objectively fanciful grimaced wildly some wow and rose
                                            jeepers outgrew lugubrious luridly irrationally attractively
                                            dachshund.
                                        </p>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="Additional-info">
                                    <table class="font-md">
                                        <tbody>
                                            <tr class="stand-up">
                                                <th>Stand Up</th>
                                                <td>
                                                    <p>35″L x 24″W x 37-45″H(front to back wheel)</p>
                                                </td>
                                            </tr>
                                            <tr class="folded-wo-wheels">
                                                <th>Folded (w/o wheels)</th>
                                                <td>
                                                    <p>32.5″L x 18.5″W x 16.5″H</p>
                                                </td>
                                            </tr>
                                            <tr class="folded-w-wheels">
                                                <th>Folded (w/ wheels)</th>
                                                <td>
                                                    <p>32.5″L x 24″W x 18.5″H</p>
                                                </td>
                                            </tr>
                                            <tr class="door-pass-through">
                                                <th>Door Pass Through</th>
                                                <td>
                                                    <p>24</p>
                                                </td>
                                            </tr>
                                            <tr class="frame">
                                                <th>Frame</th>
                                                <td>
                                                    <p>Aluminum</p>
                                                </td>
                                            </tr>
                                            <tr class="weight-wo-wheels">
                                                <th>Weight (w/o wheels)</th>
                                                <td>
                                                    <p>20 LBS</p>
                                                </td>
                                            </tr>
                                            <tr class="weight-capacity">
                                                <th>Weight Capacity</th>
                                                <td>
                                                    <p>60 LBS</p>
                                                </td>
                                            </tr>
                                            <tr class="width">
                                                <th>Width</th>
                                                <td>
                                                    <p>24″</p>
                                                </td>
                                            </tr>
                                            <tr class="handle-height-ground-to-handle">
                                                <th>Handle height (ground to handle)</th>
                                                <td>
                                                    <p>37-45″</p>
                                                </td>
                                            </tr>
                                            <tr class="wheels">
                                                <th>Wheels</th>
                                                <td>
                                                    <p>12″ air / wide track slick tread</p>
                                                </td>
                                            </tr>
                                            <tr class="seat-back-height">
                                                <th>Seat back height</th>
                                                <td>
                                                    <p>21.5″</p>
                                                </td>
                                            </tr>
                                            <tr class="head-room-inside-canopy">
                                                <th>Head room (inside canopy)</th>
                                                <td>
                                                    <p>25″</p>
                                                </td>
                                            </tr>
                                            <tr class="pa_color">
                                                <th>Color</th>
                                                <td>
                                                    <p>Black, Blue, Red, White</p>
                                                </td>
                                            </tr>
                                            <tr class="pa_size">
                                                <th>Size</th>
                                                <td>
                                                    <p>M, S</p>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="tab-pane fade" id="Reviews">
                                    <!--Comments-->
                                    <div class="comments-area">
                                        <div class="row">
                                            <div class="col-lg-8">
                                                <h4 class="mb-30">Customer questions & answers</h4>
                                                <div class="comment-list">


                                                    @foreach ( $product->reviews as $review)
                                                    <div class="single-comment justify-content-between d-flex">
                                                        <div class="user justify-content-between d-flex">
                                                            <div class="thumb text-center">
                                                                <img src="assets/imgs/page/anonymous-user.png" alt="">
                                                                <h6><a href="#">{{ $product->reviews[0]['user']['name']
                                                                        }}</a></h6>
                                                                <p class="font-xxs">Since {{
                                                                    \Carbon\Carbon::parse($product->reviews[0]['user']['created_at'])->format('Y')
                                                                    }}</p>
                                                            </div>
                                                            <div class="desc">


                                                                @php
                                                                // Example: $rating = 4.5;
                                                                $rating = $review['rating'] ?? 0;
                                                                @endphp

                                                                <div style="display: flex; gap: 8px;">

                                                                    <div>
                                                                        @for ($i = 1; $i <= 5; $i++) @if ($i <=$rating)
                                                                            {{-- Full Star --}} <i class="fa fa-star"
                                                                            style="color: #f15412;"></i>
                                                                            @elseif (($i - 0.5) <= $rating) {{-- Half
                                                                                Star --}} <i
                                                                                class="fa fa-star-half-empty"
                                                                                style="color: #f15412;"></i>
                                                                                @else
                                                                                {{-- Empty Star --}}
                                                                                <i class="fa fa-star-o"
                                                                                    style="color: #f15412;"></i>
                                                                                @endif
                                                                                @endfor
                                                                    </div>
                                                                    <div
                                                                        style="color:#f15412; font-weight: bold; font-size: 15px;">
                                                                        ({{number_format($rating, 1)}})
                                                                    </div>



                                                                </div>

                                                                <p>{{$review['comment']}}</p>
                                                                <div class="d-flex justify-content-between">
                                                                    <div class="d-flex align-items-center">
                                                                        <p class="font-xs mr-30">{{
                                                                            \Carbon\Carbon::parse($review['created_at'])->format('F
                                                                            j, Y \a\t g:i a')}} </p>
                                                                        {{-- <a href="#"
                                                                            class="text-brand btn-reply">Reply
                                                                            <i class="fi-rs-arrow-right"></i> </a> --}}
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!--single-comment -->
                                                    @endforeach



                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <h4 class="mb-30">Customer reviews</h4>
                                                <div class="d-flex mb-30" style="align-items: center; gap: 30px;">
                                                    @php
                                                    // Example: $rating = 4.5;
                                                    $rating = $review['rating'] ?? 0;
                                                    @endphp

                                                    <div>

                                                        <div>
                                                            @for ($i = 1; $i <= 5; $i++) @if ($i <=$rating) {{-- Full
                                                                Star --}} <i class="fa fa-star" style="color: #f15412;">
                                                                </i>
                                                                @elseif (($i - 0.5) <= $rating) {{-- Half Star --}} <i
                                                                    class="fa fa-star-half-empty"
                                                                    style="color: #f15412;"></i>
                                                                    @else
                                                                    {{-- Empty Star --}}
                                                                    <i class="fa fa-star-o" style="color: #f15412;"></i>
                                                                    @endif
                                                                    @endfor
                                                        </div>




                                                    </div>
                                                    <h6>{{ number_format($product->reviews_avg_rating, 1) }} out of 5
                                                    </h6>
                                                </div>

                                                @php
                                                    // 1. Get only approved reviews once to save memory
                                                    $approvedReviews = $product->reviews->where('status', 'approved');

                                                    // 2. Count total approved reviews
                                                    $totalReviewsCount = $approvedReviews->count();
                                                @endphp
                                                @for ($i = 5; $i >= 1; $i--)
                                                    @php
                                                        // 3. Count how many reviews have exactly $i stars
                                                        $specificStarCount = $approvedReviews->where('rating', $i)->count();

                                                        // 4. Calculate percentage safely
                                                        $percent = $totalReviewsCount > 0 ? ($specificStarCount / $totalReviewsCount) * 100 : 0;
                                                    @endphp

                                                    <div class="progress mb-2" style="height: 20px;">
                                                        <span style="width: 60px;">{{ $i }} star</span>
                                                        <div class="progress-bar"
                                                            role="progressbar"
                                                            style="width: {{ $percent }}%; background-color: #ffb300;"
                                                            aria-valuenow="{{ $percent }}"
                                                            aria-valuemin="0"
                                                            aria-valuemax="100">
                                                            {{ number_format($percent, 0) }}%
                                                        </div>
                                                    </div>
                                                @endfor

                                            </div>
                                        </div>
                                    </div>
                                    <!--comment form-->
                                    {{-- <div class="comment-form">
                                        <h4 class="mb-15">Add a review</h4>
                                        <div class="product-rate d-inline-block mb-30">
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-8 col-md-12">
                                                <form class="form-contact comment_form" action="#" id="commentForm">
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <div class="form-group">
                                                                <textarea class="form-control w-100" name="comment"
                                                                    id="comment" cols="30" rows="9"
                                                                    placeholder="Write Comment"></textarea>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <div class="form-group">
                                                                <input class="form-control" name="name" id="name"
                                                                    type="text" placeholder="Name">
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <div class="form-group">
                                                                <input class="form-control" name="email" id="email"
                                                                    type="email" placeholder="Email">
                                                            </div>
                                                        </div>
                                                        <div class="col-12">
                                                            <div class="form-group">
                                                                <input class="form-control" name="website" id="website"
                                                                    type="text" placeholder="Website">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <button type="submit" class="button button-contactForm">Submit
                                                            Review</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div> --}}
                                </div>
                            </div>
                        </div>
                        <div class="row mt-60">
                            <div class="col-12">
                                <h3 class="section-title style-1 mb-30">Related products</h3>
                            </div>
                            <div class="col-12">
                                <div class="carausel-6-columns-cover position-relative">
                                    <div class="slider-arrow slider-arrow-2 carausel-6-columns-arrow"
                                        id="carausel-6-columns-2-arrows">
                                    </div>
                                    <div class="carausel-6-columns carausel-arrow-center" id="carausel-6-columns-2">
                                        @foreach ($relatedProducts as $prod)
                                        <div class="product-cart-wrap small hover-up">
                                            <div class="product-img-action-wrap">
                                                <div class="product-img product-img-zoom">

                                                    <a href="{{ route('Product_Details',
                                                        [
                                                        'category_name' => $category_name,
                                                        'auth_expired_key'=>'eyJhbGciOiJFZERTQSIsInR5cCI6IkpXVCJ9.eyJzdWIiOiIxMjM0NTY3ODkwIiwibmFtZSI6IkpvaG4gRG9lIiwiYWRtaW4iOnRydWUsImlhdCI6MTUxNjIzOTAyMn0.JkKWCY39IdWEQttmdqR7VdsvT-_QxheW_eb0S5wr_j83ltux_JDUIXs7a3Dtn3xuqzuhetiuJrWIvy5TzimeCg',
                                                        'product_id'=>$product->id,
                                                        'category_id' => $product->category->id
                                                         ]) }}">
                                                        @foreach ($prod['media'] as $media)
                                                        @if ($media['position'] == 0)
                                                        <img class="default-img"
                                                            src="{{ asset( $media['file_path']. $media['image_name'])}}"
                                                            alt={{ $media['image_name'] }}>
                                                        @elseif($media['position'] == 1)
                                                        <img class="hover-img"
                                                            src="{{ asset( $media['file_path']. $media['image_name'])}}"
                                                            alt={{ $media['image_name'] }}>
                                                        @endif

                                                        @endforeach

                                                    </a>
                                                </div>

                                                <div
                                                    class="badge product-badges product-badges-position product-badges-mrg">
                                                    <span class="hot">Hot</span>
                                                </div>
                                            </div>
                                            <div class="product-content-wrap">
                                                <h2><a href="{{ route('Product_Details', ['product_name' =>$prod['name'],'category_name' => $prod['category']['name'],'auth_expired_key'=>'eyJhbGciOiJFZERTQSIsInR5cCI6IkpXVCJ9.eyJzdWIiOiIxMjM0NTY3ODkwIiwibmFtZSI6IkpvaG4gRG9lIiwiYWRtaW4iOnRydWUsImlhdCI6MTUxNjIzOTAyMn0.JkKWCY39IdWEQttmdqR7VdsvT-_QxheW_eb0S5wr_j83ltux_JDUIXs7a3Dtn3xuqzuhetiuJrWIvy5TzimeCg',
                                        'category_id' => $prod['category']['id'],'product_id'=>$prod['id'] ]) }}">{{
                                                        $prod['name'] }}</a></h2>
                                                @php
                                                // Example: $rating = 4.5;
                                                $rating = $prod['reviews_avg_rating'] ?? 0;
                                                @endphp

                                                <div style="display: flex; gap: 8px;">

                                                    <div>
                                                        @for ($i = 1; $i <= 5; $i++) @if ($i <=$rating) {{-- Full Star
                                                            --}} <i class="fa fa-star" style="color: #f15412;"></i>
                                                            @elseif (($i - 0.5) <= $rating) {{-- Half Star --}} <i
                                                                class="fa fa-star-half-empty" style="color: #f15412;">
                                                                </i>
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
                                                    <span>৳{{ $product->sale_price}}</span>
                                                    <span class="old-price">৳{{ $product->regular_price}}</span>
                                                </div>
                                            </div>
                                        </div>
                                        <!--End product-cart-wrap-2-->
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="col-lg-3 primary-sidebar sticky-sidebar">

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
                                @if ($media['position'] == 0)
                                <img src="{{ asset( $media['file_path']. $media['image_name'])}}" alt={{
                                    $media['image_name'] }}>

                                @endif

                                @endforeach
                            </div>
                            <div class="content pt-10">
                                <h5><a href="{{ route('Product_Details', ['product_name' => $item['name'],'category_name' => $item['category']['name'],'auth_expired_key'=>'eyJhbGciOiJFZERTQSIsInR5cCI6IkpXVCJ9.eyJzdWIiOiIxMjM0NTY3ODkwIiwibmFtZSI6IkpvaG4gRG9lIiwiYWRtaW4iOnRydWUsImlhdCI6MTUxNjIzOTAyMn0.JkKWCY39IdWEQttmdqR7VdsvT-_QxheW_eb0S5wr_j83ltux_JDUIXs7a3Dtn3xuqzuhetiuJrWIvy5TzimeCg',
                                        'category_id' => $item['category']['id'],'product_id'=>$item['id'] ]) }}">{{
                                        $item['name'] }}</a></h5>
                                <p class="price mb-0 mt-5">৳{{ $item['sale_price'] }}</p>
                                @php
                                // Example: $rating = 4.5;
                                $rating = $item['reviews_avg_rating'] ?? 0;
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
                                        ({{number_format($item['reviews_avg_rating'], 1)}})
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach


                    </div>




                </div>
            </div>
        </div>
    </section>
</main>

@endsection



