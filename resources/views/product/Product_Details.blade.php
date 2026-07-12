@extends('layout.master')

@section('title', 'E-Commerce')


@section('content')

    <main class="main">
        <div class="page-header breadcrumb-wrap">
            <div class="container">
                <div class="breadcrumb">
                    <a href="{{ route('home.index') }}" rel="nofollow">Home</a>
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
                                                                                    <img src="{{ asset($media['file_path'] . $media['image_name'])}}" alt={{
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
                                                                                    <img src="{{ asset($media['file_path'] . $media['image_name'])}}" alt={{
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
                                    @php
                                        $productUrl = route('Product_Details', [
                                            'product_name'     => $product->name,
                                            'category_name'    => $product->category->name,
                                            'auth_expired_key' => 'eyJhbGciOiJFZERTQSIsInR5cCI6IkpXVCJ9.eyJzdWIiOiIxMjM0NTY3ODkwIiwibmFtZSI6IkpvaG4gRG9lIiwiYWRtaW4iOnRydWUsImlhdCI6MTUxNjIzOTAyMn0.JkKWCY39IdWEQttmdqR7VdsvT-_QxheW_eb0S5wr_j83ltux_JDUIXs7a3Dtn3xuqzuhetiuJrWIvy5TzimeCg',
                                            'category_id'      => $product->category->id,
                                            'product_id'       => $product->id,
                                        ]);
                                        $shareUrl    = urlencode($productUrl);
                                        $shareTitle  = urlencode($product->name);
                                        $fbShareUrl  = 'https://www.facebook.com/sharer/sharer.php?u=' . $shareUrl;
                                        $twShareUrl  = 'https://twitter.com/intent/tweet?url=' . $shareUrl . '&text=' . $shareTitle;
                                        $pinShareUrl = 'https://pinterest.com/pin/create/button/?url=' . $shareUrl . '&description=' . $shareTitle;
                                    @endphp
                                    <div class="social-icons single-share">
                                        <ul class="text-grey-5 d-inline-block">
                                            <li><strong class="mr-10">Share this:</strong></li>
                                            <li class="social-facebook">
                                                <a href="{{ $fbShareUrl }}" target="_blank" rel="noopener noreferrer" title="Share on Facebook">
                                                    <img src="{{ asset('assets/imgs/theme/icons/icon-facebook.svg') }}" alt="Facebook">
                                                </a>
                                            </li>
                                            <li class="social-twitter">
                                                <a href="{{ $twShareUrl }}" target="_blank" rel="noopener noreferrer" title="Share on X (Twitter)">
                                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="20" height="20" fill="currentColor" style="vertical-align:middle;"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-4.714-6.231-5.401 6.231H2.746l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>
                                                </a>
                                            </li>
                                            <li class="social-instagram">
                                                <a href="https://www.instagram.com/" target="_blank" rel="noopener noreferrer" title="Instagram">
                                                    <img src="{{ asset('assets/imgs/theme/icons/icon-instagram.svg') }}" alt="Instagram">
                                                </a>
                                            </li>
                                            <li class="social-linkedin">
                                                <a href="{{ $pinShareUrl }}" target="_blank" rel="noopener noreferrer" title="Share on Pinterest">
                                                    <img src="{{ asset('assets/imgs/theme/icons/icon-pinterest.svg') }}" alt="Pinterest">
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-12 col-xs-12">
                                    <div class="detail-info">
                                        <h2 class="title-detail" style="color: #222;">{{ $product->name }}</h2>
                                        <div class="product-detail-rating">

                                            @if($product->brand)
                                                                                <div class="pro-details-brand">
                                                                                    <span style="font-weight: bolder; color: #222;"> Brands: <span style="color: #222;">{{
                                                $product->brand->name }}</span></span>
                                                                                </div>
                                            @endif

                                            @if($product->category)
                                                                                <div class="pro-details-brand">
                                                                                    <span style="font-weight: bolder; color: #222;"> Category: <span
                                                                                            style="color: #222;">{{
                                                $product->category->name }}</span></span>
                                                                                </div>
                                            @endif

                                            @php
                                                // Example: $rating = 4.5;
                                                $rating = $product->reviews_avg_rating ?? 0;
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
                                                <div style="color:#222; font-weight: bold; font-size: 15px;">
                                                    ({{number_format($rating, 1)}})
                                                </div>


                                                <span class="font-small ml-5 text-muted" style="font-weight: bolder;">

                                                    @if ($product->reviews)
                                                        <span style="color: #222;">{{ count($product->reviews) }} {{
                                                        count($product->reviews) > 9 ? "Reviews" :
                                                        "Review" }}</span>
                                                    @else
                                                        <span style="color: #222;">0 Review</span>
                                                    @endif

                                                </span>
                                            </div>
                                        </div>
                                        <div class="clearfix product-price-cover">
                                            <div class="product-price primary-color float-left">
                                                <ins>
                                                    <span class="text-brand" style="color: #222 !important;">
                                                        Price ৳{{ $product->package_price }} (Package Price)
                                                    </span>
                                                </ins>
                                                @if($product->regular_price && $product->regular_price != $product->package_price)
                                                    <br>
                                                    <span style="text-decoration: line-through; color: #999; font-size: 15px; font-weight: 500;">
                                                        ৳{{ $product->regular_price }}
                                                    </span>
                                                @endif

                                                @if($product->is_discounted)
                                                    <span class="save-price font-md color3 ml-15" style="font-weight: bold">
                                                        {{ number_format($product->total_discount_percent, 0) }}% Off
                                                    </span>
                                                @endif

                                            </div>
                                        </div>
                                        <div class="bt-1 border-color-1 mt-15 mb-15"></div>
                                        <div class="short-desc mb-30">

                                            @if($product->short_description)
                                                <p class="mb-3" style="color:#555; font-size:14px; line-height:1.7;">
                                                    {{ $product->short_description }}
                                                </p>
                                            @endif
                                            <p style="font-weight: bold; color: #f15412 ">{{$product->minimum_order}} piece.
                                                Per piece price {{$product->sale_price}} BDT.</p>
                                        </div>
                                        <div class="product_sort_info font-xs mb-30">
                                            <ul>
                                                <li><i class="fi-rs-credit-card mr-5"></i> Cash on Delivery available
                                                </li>
                                            </ul>

                                        </div>

                                        <div class="bt-1 border-color-1 mt-30 mb-30"></div>
                                        <div class="detail-extralink">
                                            {{-- <div class="detail-qty border radius">
                                                <a href="#" class="qty-down"><i class="fi-rs-angle-small-down"></i></a>
                                                <span class="qty-val">1</span>
                                                <a href="#" class="qty-up"><i class="fi-rs-angle-small-up"></i></a>
                                            </div> --}}
                                            <div class="product-extra-link21">
                                                <a aria-label="Add To Cart" class="button button-add-to-cart" style="display: inline-block;
                                                                                    border: 1px solid transparent;
                                                                                    font-size: 14px;
                                                                                    height:40px;
                                                                                    font-weight: 700;
                                                                                    border-radius: 4px;
                                                                                    color: #fff;
                                                                                    border: 1px solid #f15412;
                                                                                    background-color: #f15412;
                                                                                    cursor: pointer;
                                                                                    -webkit-transition: all 300ms linear 0s;
                                                                                    transition: all 300ms linear 0s;
                                                                                    letter-spacing: 0.5px;" href="{{ route(
        'Product_Cart_Add',
        [
            'product_name' => $product->name,
            'auth_expired_key' => 'eyJhbGciOiJFZERTQSIsInR5cCI6IkpXVCJ9.eR67Hyabjda0wIiwibmFtZSI6IkpvaG4gRG9lIiwiYWRtaW4iOnRydWUsImlhdCI6MTUxNjIzOTAyMn0.JkKWCY39IdWEQttmdqR7VdsvT-_QxheW_eb0S5wr_j83ltux_JDUIXs7a3Dtn3xuqzuhetiuJrWIvy5TzimeCg',
            'product_id' => $product->id
        ]
    ) }}">
                                                    Add to cart</a>

                                            </div>
                                        </div>
                                        <ul class="product-meta font-xs mt-50" style="font-weight: bold; color: #222;">
                                            <li class="mb-5">SKU: <a href="#" style="color: #222;">{{ $product->sku }}</a></li>
                                            @php $productTags = is_string($product->tags) ? json_decode($product->tags, true) : null; @endphp
                                            @if(!empty($productTags))
                                                <li class="mb-5">Tags:
                                                    <a href="#" rel="tag" style="color: #222;">{{ implode(', ', $productTags) }}</a>
                                                </li>
                                            @endif

                                            <li>Availability: <span style="color: #222; font-weight: bold;">
                                                    {{ $product->stock_quantity }} Items In Stock
                                                </span>
                                            </li>
                                        </ul>
                                    </div>
                                    <!-- Detail Info -->
                                </div>
                            </div>
                            @php
                                $aiRows = [];
                                if ($product->additional_info_active && !empty($product->additional_info)) {
                                    $decoded = json_decode($product->additional_info, true);
                                    if (is_array($decoded)) {
                                        $aiRows = array_values(array_filter($decoded, fn($r) =>
                                            !empty(trim($r['label'] ?? '')) || !empty(trim($r['value'] ?? ''))
                                        ));
                                    }
                                }
                            @endphp
                            <div class="tab-style3">
                                <ul class="nav nav-tabs text-uppercase">
                                    <li class="nav-item">
                                        <a class="nav-link active" id="Description-tab" data-bs-toggle="tab"
                                            href="#Description">Description</a>
                                    </li>
                                    @if(count($aiRows) > 0)
                                    <li class="nav-item">
                                        <a class="nav-link" id="Additional-info-tab" data-bs-toggle="tab"
                                            href="#Additional-info">Additional info</a>
                                    </li>
                                    @endif
                                    <li class="nav-item">
                                        <a class="nav-link" id="Reviews-tab" data-bs-toggle="tab" href="#Reviews">Reviews
                                            ({{ count($product->reviews) }})</a>
                                    </li>
                                </ul>
                                <div class="tab-content shop_info_tab entry-main-content">

                                    <div class="tab-pane fade show active" id="Description">
                                        <div class="py-3">

                                            {{-- Short Description --}}
                                            @if($product->short_description)
                                                <div class="mb-4 p-3"
                                                    style="background:#f8fafc; border-left:4px solid #0d6efd; border-radius:4px;">
                                                    <p class="mb-0" style="font-size:15px; color:#444; line-height:1.7;">
                                                        {{ $product->short_description }}
                                                    </p>
                                                </div>
                                            @endif

                                            {{-- Full Description --}}
                                            @if($product->description)
                                                <div style="font-size:14px; color:#555; line-height:1.8;">
                                                    {!! nl2br(e($product->description)) !!}
                                                </div>
                                            @else
                                                <p class="text-muted">No description available.</p>
                                            @endif

                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="Additional-info">
                                        @if(count($aiRows) > 0)
                                            <table class="font-md">
                                                <tbody>
                                                    @foreach($aiRows as $row)
                                                    <tr>
                                                        <th>{{ $row['label'] ?? '' }}</th>
                                                        <td><p>{{ $row['value'] ?? '' }}</p></td>
                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        @else
                                            <p class="text-muted py-3">No additional information available.</p>
                                        @endif
                                    </div>
                                    <div class="tab-pane fade" id="Reviews">
                                        <!--Comments-->
                                        <div class="comments-area">
                                            <div class="row">
                                                <div class="col-lg-8">
                                                    <h4 class="mb-30">Customer questions & answers</h4>
                                                    <div class="comment-list">


                                                        @foreach ($product->reviews as $review)
                                                                                                        <div class="single-comment justify-content-between d-flex">
                                                                                                            <div class="user justify-content-between d-flex">
                                                                                                                <div class="thumb text-center">
                                                                                                                    <img src="assets/imgs/page/anonymous-user.png" alt="">
                                                                                                                    <h6><a
                                                                                                                            href="#">{{ $product->reviews[0]['user']['name']
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        }}</a>
                                                                                                                    </h6>
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
                                                                                                                            @for ($i = 1; $i <= 5; $i++) @if ($i <= $rating)
                                                                                                                                    {{-- Full Star --}} <i class="fa fa-star"
                                                                                                                                        style="color: #f15412;"></i>
                                                                                                                                @elseif (($i - 0.5) <= $rating) {{-- Half
                                                                                                                                    Star --}} <i class="fa fa-star-half-empty"
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
                                                                @for ($i = 1; $i <= 5; $i++) @if ($i <= $rating) {{-- Full
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
                                                            $percent = $totalReviewsCount > 0 ? ($specificStarCount /
                                                                $totalReviewsCount) * 100 : 0;
                                                        @endphp

                                                        <div class="progress mb-2" style="height: 20px;">
                                                            <span style="width: 60px;">{{ $i }} star</span>
                                                            <div class="progress-bar" role="progressbar"
                                                                style="width: {{ $percent }}%; background-color: #ffb300;"
                                                                aria-valuenow="{{ $percent }}" aria-valuemin="0"
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
                                    <div class="row">
                                        @foreach ($relatedProducts as $prod)
                                        <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6 col-6 mb-4">
                                            <div class="product-cart-wrap small hover-up h-100">
                                                <div class="product-img-action-wrap">
                                                    <div class="product-img product-img-zoom">
                                                        <a href="{{ route('Product_Details', [
                                                            'product_name'    => $prod['name'],
                                                            'category_name'   => $prod['category']['name'],
                                                            'auth_expired_key'=> 'eyJhbGciOiJFZERTQSIsInR5cCI6IkpXVCJ9.eyJzdWIiOiIxMjM0NTY3ODkwIiwibmFtZSI6IkpvaG4gRG9lIiwiYWRtaW4iOnRydWUsImlhdCI6MTUxNjIzOTAyMn0.JkKWCY39IdWEQttmdqR7VdsvT-_QxheW_eb0S5wr_j83ltux_JDUIXs7a3Dtn3xuqzuhetiuJrWIvy5TzimeCg',
                                                            'category_id'     => $prod['category']['id'],
                                                            'product_id'      => $prod['id'],
                                                        ]) }}">
                                                            @foreach ($prod['media'] as $media)
                                                                @if ($media['position'] == 1)
                                                                    <img class="default-img"
                                                                         src="{{ asset($media['file_path'] . $media['image_name']) }}"
                                                                         alt="{{ $media['image_name'] }}">
                                                                @else
                                                                    <img class="hover-img"
                                                                         src="{{ asset($media['file_path'] . $media['image_name']) }}"
                                                                         alt="{{ $media['image_name'] }}">
                                                                @endif
                                                            @endforeach
                                                        </a>
                                                    </div>
                                                    <div class="product-badges product-badges-position product-badges-mrg">
                                                        @php
                                                            $prodTypes = is_string($prod['product_type'])
                                                                ? json_decode($prod['product_type'], true)
                                                                : ($prod['product_type'] ?? []);
                                                        @endphp
                                                        @if(in_array('HOTSALEITEMS', $prodTypes ?? []))
                                                            <span class="badge hot">Hot</span>
                                                        @elseif(in_array('TOPSELLING', $prodTypes ?? []))
                                                            <span class="badge best-seller">Best Seller</span>
                                                        @elseif(in_array('TOPNEWITEMS', $prodTypes ?? []))
                                                            <span class="badge new">New</span>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="product-content-wrap" style="text-align: left;">
                                                    <h2>
                                                        <a href="{{ route('Product_Details', [
                                                            'product_name'    => $prod['name'],
                                                            'category_name'   => $prod['category']['name'],
                                                            'auth_expired_key'=> 'eyJhbGciOiJFZERTQSIsInR5cCI6IkpXVCJ9.eyJzdWIiOiIxMjM0NTY3ODkwIiwibmFtZSI6IkpvaG4gRG9lIiwiYWRtaW4iOnRydWUsImlhdCI6MTUxNjIzOTAyMn0.JkKWCY39IdWEQttmdqR7VdsvT-_QxheW_eb0S5wr_j83ltux_JDUIXs7a3Dtn3xuqzuhetiuJrWIvy5TzimeCg',
                                                            'category_id'     => $prod['category']['id'],
                                                            'product_id'      => $prod['id'],
                                                        ]) }}">{{ $prod['name'] }}</a>
                                                    </h2>
                                                    @php $rating = $prod['reviews_avg_rating'] ?? 0; @endphp
                                                    <div style="display:flex; gap:6px; align-items:center;">
                                                        <div>
                                                            @for ($i = 1; $i <= 5; $i++)
                                                                @if ($i <= $rating)
                                                                    <i class="fa fa-star" style="color:#f15412;"></i>
                                                                @elseif (($i - 0.5) <= $rating)
                                                                    <i class="fa fa-star-half-empty" style="color:#f15412;"></i>
                                                                @else
                                                                    <i class="fa fa-star-o" style="color:#f15412;"></i>
                                                                @endif
                                                            @endfor
                                                        </div>
                                                        <div style="color:#f15412; font-weight:bold; font-size:13px;">
                                                            ({{ number_format($rating, 1) }})
                                                        </div>
                                                    </div>
                                                    <div class="product-price" style="text-align:left;">
                                                        <span>৳{{ $prod['sale_price'] }}</span>
                                                        <span class="old-price">৳{{ $prod['regular_price'] }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        @endforeach
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
                                                            @php
                                                                $newProdMediaCol = collect($item['media'] ?? []);
                                                                $newProdImg = $newProdMediaCol->firstWhere('position', 2) ?? $newProdMediaCol->firstWhere('position', 1);
                                                            @endphp
                                                            @if ($newProdImg)
                                                                <img src="{{ asset($newProdImg['file_path'] . $newProdImg['image_name'])}}" alt={{
                                                                    $newProdImg['image_name'] }}>

                                                            @endif
                                                        </div>
                                                        <div class="content pt-10">
                                                            <h5><a href="{{ route('Product_Details', [
                                    'product_name' => $item['name'],
                                    'category_name' => $item['category']['name'],
                                    'auth_expired_key' => 'eyJhbGciOiJFZERTQSIsInR5cCI6IkpXVCJ9.eyJzdWIiOiIxMjM0NTY3ODkwIiwibmFtZSI6IkpvaG4gRG9lIiwiYWRtaW4iOnRydWUsImlhdCI6MTUxNjIzOTAyMn0.JkKWCY39IdWEQttmdqR7VdsvT-_QxheW_eb0S5wr_j83ltux_JDUIXs7a3Dtn3xuqzuhetiuJrWIvy5TzimeCg',
                                    'category_id' => $item['category']['id'],
                                    'product_id' => $item['id']
                                ]) }}" style="color: #222;">{{
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

@endsection