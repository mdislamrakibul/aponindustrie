@extends('layout.master')

@section('title', 'E-Commerce')


@section('content')

<!--main area-->
<main class="main">
    <div class="page-header breadcrumb-wrap">
        <div class="container">
            <div class="breadcrumb">
                <a href="{{ route('home.index') }}" rel="nofollow">Home</a>
                <span></span> Shop
                <span></span> Your Cart
            </div>
        </div>
    </div>
    <section class="mt-20">

        <div class="container">

            <div class="row">
                <div id="cartPageSummary">
                    @include('partials.cart-page-summary')
                </div>
            </div>
        </div>
    </section>


    {{-- New Arrival Product --}}
    <section class="section-padding">
        <div class="container wow fadeIn animated">
            <h3 class="section-title style-1 mb-20"><span>New</span> Arrivals</h3>
            <div class="carausel-6-columns-cover position-relative">
                <div class="slider-arrow slider-arrow-2 carausel-6-columns-arrow" id="carausel-6-columns-2-arrows">
                </div>
                <div class="carausel-6-columns carausel-arrow-center" id="carausel-6-columns-2">

                    @foreach ( $newProducts as $prod)
                    <div class="product-cart-wrap small hover-up">
                        <div class="product-img-action-wrap">
                            <div class="product-img product-img-zoom">
                                <a href="{{ route('Product_Details', ['product_name' => $prod['name'],'category_name' => $prod['category']['name'],'auth_expired_key'=>'eyJhbGciOiJFZERTQSIsInR5cCI6IkpXVCJ9.eyJzdWIiOiIxMjM0NTY3ODkwIiwibmFtZSI6IkpvaG4gRG9lIiwiYWRtaW4iOnRydWUsImlhdCI6MTUxNjIzOTAyMn0.JkKWCY39IdWEQttmdqR7VdsvT-_QxheW_eb0S5wr_j83ltux_JDUIXs7a3Dtn3xuqzuhetiuJrWIvy5TzimeCg',
                                        'category_id' => $prod['category']['id'],'product_id'=>$prod['id'] ]) }}">
                                    @foreach ($prod['media'] as $media)
                                    @if ($media['position'] == 1)
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

                            <div class="product-badges product-badges-position product-badges-mrg">
                                <span class="hot">New</span>
                            </div>
                        </div>
                        <div class="product-content-wrap">
                            <h2><a href="{{ route('Product_Details', ['product_name' => $prod['name'],'category_name' => $prod['category']['name'],'auth_expired_key'=>'eyJhbGciOiJFZERTQSIsInR5cCI6IkpXVCJ9.eyJzdWIiOiIxMjM0NTY3ODkwIiwibmFtZSI6IkpvaG4gRG9lIiwiYWRtaW4iOnRydWUsImlhdCI6MTUxNjIzOTAyMn0.JkKWCY39IdWEQttmdqR7VdsvT-_QxheW_eb0S5wr_j83ltux_JDUIXs7a3Dtn3xuqzuhetiuJrWIvy5TzimeCg',
                                        'category_id' => $prod['category']['id'],'product_id'=>$prod['id'] ]) }}">{{ $prod['name'] }}</a></h2>
                            <div class="rating-result" title="90%">
                                <span>
                                </span>
                            </div>
                            <div class="product-price">
                                <span>৳{{ $prod['sale_price'] }}/per</span>
                                <span class="old-price{{ (float) ($prod['regular_price'] ?? 0) == (float) ($prod['package_price'] ?? 0) ? ' no-discount' : '' }}">৳{{ $prod['regular_price'] }}</span>
                            </div>
                            <a aria-label="Add To Cart" class="btn-add-to-cart-full" href="{{ route('Product_Cart_Add', ['product_name' => $prod['name'], 'auth_expired_key' => 'eyJhbGciOiJFZERTQSIsInR5cCI6IkpXVCJ9.eyJzdWIiOiIxMjM0NTY3ODkwIiwibmFtZSI6IkpvaG4gRG9lIiwiYWRtaW4iOnRydWUsImlhdCI6MTUxNjIzOTAyMn0.JkKWCY39IdWEQttmdqR7VdsvT-_QxheW_eb0S5wr_j83ltux_JDUIXs7a3Dtn3xuqzuhetiuJrWIvy5TzimeCg', 'product_id' => $prod['id']]) }}"><i class="fi-rs-shopping-bag-add"></i> Add To Cart</a>
                        </div>
                    </div>
                    <!--End product-cart-wrap-2-->
                    @endforeach


                </div>
            </div>
        </div>
    </section>

    {{--
    /**
    * Clear Cart Modal
    *
    * @param mixed $request
    * @return void
    */
    --}}


    <div id="delete_modal" class="modal fade delete-modal" role="dialog">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body text-center">
                    <img src={{asset('assets/uploads/delete-circle.png')}} alt="" width="150">
                    <h3 style="padding:25px 0px">Are you sure want to delete?</h3>
                    <input type="hidden" class="form-control" name="idkl" id="idkl" value="">
                    <div class="m-t-20">
                        <a href="#" class="btn btn-white" data-bs-dismiss="modal" style="color: #f15412 !important;
    background: white !important;">Close

                        </a>
                        <button type="submit" class="btn btn-danger" id="delete_button">Delete</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
<!--main area-->


@endsection


@section('custom_script')
<script>
    $(document).ready(function() {


        $(document).on("click", "#delete_button", function () {
            $.ajax({
                url: "/product-cart/remove/all",
                type: "get",
                // dataType: "json",
                success: function(res) {
                    if (res.status == 'success') {
                        Swal.fire({
                            icon: 'success',
                            title: res.message,
                            showConfirmButton: true,
                        }).then(() => {
                            // This executes after the alert closes or the alert timer finishes
                            location.reload();
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: res.message,
                            showConfirmButton: true,
                            }).then(() => {
                            // This executes after the alert closes or the alert timer finishes
                            location.reload();
                        });
                    }
                }
            })
        });




        $(document).on("click", "#remove_single_item", function () {
            var id = $(this).data('id');
            $.ajax({

                url: "/product-cart/remove/single/" + id,
                type: "get",
                // dataType: "json",
                success: function(res) {
                    if (res.status == 'success') {
                        Swal.fire({
                            icon: 'success',
                            title: res.message,
                            showConfirmButton: true,
                        }).then(() => {
                            // This executes after the alert closes or the alert timer finishes
                            location.reload();
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: res.message,
                            showConfirmButton: true,
                            }).then(() => {
                            // This executes after the alert closes or the alert timer finishes
                            location.reload();
                        });
                    }
                }
            })
        });



        $(document).on('click', '.update_single_item_btn', function(e) {
            e.preventDefault();

            // 1. Get the ID directly from the data attribute of the button
            var productId = $(this).data('id');

            // 2. Get the quantity from the sibling input field
            var quantity = $(this).siblings('.update_item_number').val();

            // Debugging
            console.log("Product ID:", productId);
            console.log("New Quantity:", quantity);
            $.ajax({

                url: "/product-cart/update/single/" + productId+ "/quantity/" + quantity,
                type: "get",
                // dataType: "json",
                success: function(res) {
                    if (res.status == 'success') {
                        Swal.fire({
                            icon: 'success',
                            title: res.message,
                            showConfirmButton: true,
                        }).then(() => {
                            // This executes after the alert closes or the alert timer finishes
                            location.reload();
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: res.message,
                            showConfirmButton: true,
                            }).then(() => {
                            // This executes after the alert closes or the alert timer finishes
                            location.reload();
                        });
                    }
                }
            })
        });


        $(document).on('click', '.cart-qty-stepper__btn', function (e) {
            e.preventDefault();

            var $btn = $(this);
            var $stepper = $btn.closest('.cart-qty-stepper');
            if ($stepper.hasClass('is-loading')) return;

            var productId = $stepper.data('product-id');
            var currentQty = parseInt($stepper.find('.cart-qty-stepper__qty').text(), 10) || 1;
            var newQty = $btn.hasClass('cart-qty-stepper__btn--plus') ? currentQty + 1 : currentQty - 1;

            $stepper.addClass('is-loading');

            $.ajax({
                url: "/product-cart/update/single/" + productId + "/quantity/" + newQty,
                type: "get",
                success: function (res) {
                    if (res.status == 'success') {
                        location.reload();
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: res.message,
                            showConfirmButton: true,
                        });
                        $stepper.removeClass('is-loading');
                    }
                },
                error: function (xhr) {
                    var msg = (xhr.responseJSON && xhr.responseJSON.message) || 'Something went wrong.';
                    Swal.fire({
                        icon: 'error',
                        title: msg,
                        showConfirmButton: true,
                    });
                    $stepper.removeClass('is-loading');
                }
            });
        });
    })
</script>
@endsection
