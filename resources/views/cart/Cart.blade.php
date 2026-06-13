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
                <div class="row mb-50">
                    @if (isset($cart_info) && count($cart_info)> 0)
                    <div class="col-lg-8 col-md-12">
                        <div class="table-responsive">


                            <table class="table shopping-summery text-center clean">
                                <thead>
                                    <tr class="main-heading">
                                        <th scope="col">Image</th>
                                        <th scope="col">Name</th>
                                        <th scope="col">Price</th>
                                        <th scope="col">Minimum Order Item</th>
                                        <th scope="col">Subtotal</th>
                                        <th scope="col">Remove</th>
                                    </tr>
                                </thead>
                                <tbody>


                                    @foreach ($cart_info as $cart)
                                    <tr>
                                        <td class="image product-thumbnail">

                                            @foreach ($cart['product']['media'] as $media)
                                            @if ($media['position'] == 1)
                                            <img src="{{ asset( $media['file_path']. $media['image_name'])}}" alt={{
                                                $media['image_name'] }}>

                                            @endif

                                            @endforeach

                                        </td>
                                        <td class="product-des product-name" style="text-align: left;">
                                            <h5 class="product-name"><a href="product-details.html">
                                                    {{$cart['product']['name']}}</a></h5>
                                            {{-- <p class="font-xs">
                                                {{ $cart['product']['short_description'] }}
                                            </p> --}}
                                        </td>
                                        <td class="price" data-title="Price" style="font-weight:bold"><span>৳{{
                                                $cart['product']['package_price'] }}
                                            </span>
                                        </td>
                                        {{-- <td class="text-center" data-title="Stock">
                                            <div class="detail-qty border radius  m-auto cart-item-controls"
                                                data-id="{{ $cart['product']['id']  }}">
                                                </a>
                                                <input type="number" class="qty-val" value={{ $cart['quantity'] }} />

                                                <a href="#" class="qty-up btn-update">
                                                    <i class="fi-rs-check" style="color: green;"></i>
                                                </a>
                                            </div>

                                        </td> --}}
                                        <td class="action" data-title="update">
                                            {{-- <input type="hidden" value={{ $cart['product']['id'] }}
                                                class="update_item_id" /> --}}
                                            {{-- <input type="number" class="detail-qty qty-val update_item_number"
                                                value="{{ $cart['quantity'] }}" /> --}}
                                            <span style="font-weight:bold">{{ $cart['minimum_order'] }}
                                            </span>
                                            {{-- <a href="#" class="text-muted update_single_item_btn"
                                                data-id="{{ $cart['product']['id'] }}">
                                                <i class="fi-rs-shopping-cart-check" style="color: green;"></i>
                                            </a> --}}
                                        </td>
                                        <td class="text-right" data-title="Cart" style="font-weight:bold">
                                            <span>৳{{ number_format($cart['product']['package_price'] *
                                                $cart['quantity'],
                                                2)}} </span>
                                        </td>
                                        <td class="action" data-title="Remove">
                                            <input type="hidden" value={{ $cart['product']['id'] }}
                                                class="remove_item_id" />
                                            <a href="#" class="text-muted" id="remove_single_item"
                                                data-id="{{ $cart['product']['id']  }}">
                                                <i class="fi-rs-trash" style="color: red;"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    @endforeach



                                </tbody>
                            </table>
                        </div>
                        <div class="cart-action text-end">
                            <a class="btn  mr-10 mb-sm-15" style=" border: 1px solid red !important;
                                background-color: red !important;" data-bs-toggle="modal" id="delete_pop_modal"
                                data-bs-target="#delete_modal"><i class="fi-rs-trash mr-10"></i>
                                Clear Cart
                            </a>
                            <a class="btn " href="{{ route('home.index') }}"><i
                                    class="fi-rs-shopping-bag mr-10"></i>Continue Shopping</a>
                        </div>


                    </div>
                    <div class="col-lg-4 col-md-12">
                        <div class="border p-md-4 p-10 border-radius cart-totals">
                            <div class="heading_s1 mb-3">
                                <h4>Cart Totals</h4>
                            </div>
                            <div class="table-responsive">
                                <table class="table">
                                    <tbody>
                                        <tr>
                                            <td class="cart_total_label">Cart Subtotal</td>
                                            <td class="cart_total_amount"><span class="font-lg fw-900 text-brand">
                                                    ৳{{ number_format($subTotal,2) }}




                                                </span></td>
                                        </tr>
                                        <tr>
                                            <td class="cart_total_label">Shipping</td>
                                            <td class="cart_total_amount"> <i class="ti-gift mr-5"></i> Free
                                                Shipping</td>
                                        </tr>
                                        <tr>
                                            <td class="cart_total_label">Total</td>
                                            <td class="cart_total_amount"><strong><span
                                                        class="font-xl fw-900 text-brand">৳{{ number_format($subTotal,2)
                                                        }}</span></strong>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            {{-- <div class="mb-30 mt-50">
                                <div class="heading_s1 mb-3">
                                    <h4>Apply Coupon</h4>
                                </div>
                                <div class="total-amount">
                                    <div class="left">
                                        <div class="coupon">
                                            <form action="#" target="_blank">
                                                <div class="form-row row justify-content-center">
                                                    <div class="form-group col-lg-6">
                                                        <input class="font-medium" name="Coupon"
                                                            placeholder="Enter Your Coupon">
                                                    </div>
                                                    <div class="form-group col-lg-6">
                                                        <button class="btn  btn-sm"><i
                                                                class="fi-rs-label mr-10"></i>Apply</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div> --}}
                            @if (isset($cart_info) && count($cart_info)> 0)
                            <a href="{{ route('Product_Checkout') }}" class="btn "> <i class="fi-rs-box-alt mr-10"></i>
                                Proceed To
                                CheckOut</a>
                            @endif
                        </div>
                    </div>
                    @else
                    <div class="mt-100" style="font-size: 30px;
                                        text-align: center;
                                        color: #f15412;
                                        font-weight: bold;">
                        Your cart is empty!
                    </div>
                    @endif
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
                                <span>৳{{ $prod['sale_price'] }} </span>
                                <span class="old-price">৳{{ $prod['regular_price'] }}</span>
                            </div>
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


        // $('.btn-update').on('click', function() {
        //     let button = $(this);
        //     let id = button.closest('.cart-item-controls').data('id');
        //     let changeValue = button.data('change');

        //     $.ajax({
        //         url: `/cart/update-quantity/${id}`,
        //         method: "PATCH",
        //         data: {
        //             _token: '{{ csrf_token() }}',
        //             change: changeValue
        //         },
        //         success: function(response) {
        //             if(response.status === 'success') {
        //                 // Option 1: Refresh to update all totals
        //                 location.reload();

        //                 // Option 2: Manually update the DOM for a smoother feel
        //                 // button.siblings('.qty-display').text(response.newQty);
        //             }
        //         }
        //     });
        // });
    })
</script>
@endsection
