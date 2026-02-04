@extends('layout.master')

@section('title', 'E-Commerce')


@section('content')

<!--main area-->
<main class="main">
    <div class="page-header breadcrumb-wrap">
        <div class="container">
            <div class="breadcrumb">
                <a href="index.html" rel="nofollow">Home</a>
                <span></span> Shop
                <span></span> Checkout
            </div>
        </div>
    </div>
    <section class="mt-20 mb-50">
        <div class="container">
            {{--<div class="row">
                <div class="col-lg-6 mb-sm-15">
                    <div class="toggle_info">
                        <span><i class="fi-rs-user mr-10"></i><span class="text-muted">Already have an
                                account?</span> <a href="#loginform" data-bs-toggle="collapse" class="collapsed"
                                aria-expanded="false">Click here to login</a></span>
                    </div>
                    <div class="panel-collapse collapse login_form" id="loginform">
                        <div class="panel-body">
                            <p class="mb-30 font-sm">If you have shopped with us before, please enter your details
                                below. If you are a new customer, please proceed to the Billing &amp; Shipping
                                section.</p>
                            <form method="post">
                                <div class="form-group">
                                    <input type="text" name="email" placeholder="Username Or Email">
                                </div>
                                <div class="form-group">
                                    <input type="password" name="password" placeholder="Password">
                                </div>
                                <div class="login_footer form-group">
                                    <div class="chek-form">
                                        <div class="custome-checkbox">
                                            <input class="form-check-input" type="checkbox" name="checkbox"
                                                id="remember" value="">
                                            <label class="form-check-label" for="remember"><span>Remember
                                                    me</span></label>
                                        </div>
                                    </div>
                                    <a href="#">Forgot password?</a>
                                </div>
                                <div class="form-group">
                                    <button class="btn btn-md" name="login">Log in</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="toggle_info">
                        <span><i class="fi-rs-label mr-10"></i><span class="text-muted">Have a coupon?</span> <a
                                href="#coupon" data-bs-toggle="collapse" class="collapsed" aria-expanded="false">Click
                                here to enter your code</a></span>
                    </div>
                    <div class="panel-collapse collapse coupon_form " id="coupon">
                        <div class="panel-body">
                            <p class="mb-30 font-sm">If you have a coupon code, please apply it below.</p>
                            <form>
                                <div class="form-group">
                                    <input type="text" placeholder="Enter Coupon Code...">
                                </div>
                                <div class="form-group">
                                    <button class="btn  btn-md" name="login">Apply Coupon</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="divider mt-15 mb-15"></div>
                </div>
            </div>
            --}}
            <form id='billingDetailsForm' method="post">
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-25">
                            <h4>Billing Details</h4>
                        </div>

                        <div class="form-group">
                            <input type="text" required="" id="fname" name="fname" placeholder="First name *">
                        </div>
                        <div class="form-group">
                            <input type="text" required="" id="lname" name="lname" placeholder="Last name *">
                        </div>


                        <div class="form-group">
                            <input type="text" id="billing_address" name="billing_address" required=""
                                placeholder="Address *">
                        </div>

                        {{-- <div class="form-group">
                            <input required="" type="text" name="city" placeholder="City / Town *">
                        </div>
                        <div class="form-group">
                            <input required="" type="text" name="state" placeholder="State / County *">
                        </div>
                        <div class="form-group">
                            <input required="" type="text" name="zipcode" placeholder="Postcode / ZIP *">
                        </div> --}}
                        <div class="form-group">
                            <input required="" type="text" id="phone" name="phone" pattern="^(?:\+88|88)?01[3-9]\d{8}$"
                                placeholder="017XXXXXXXX">
                        </div>
                        <div class="form-group">
                            <input required="" type="text" id="email" name="email" placeholder="Email address *">
                        </div>
                        {{-- <div class="form-group">
                            <div class="checkbox">
                                <div class="custome-checkbox">
                                    <input class="form-check-input" type="checkbox" name="checkbox" id="createaccount">
                                    <label class="form-check-label label_info" data-bs-toggle="collapse"
                                        href="#collapsePassword" data-target="#collapsePassword"
                                        aria-controls="collapsePassword" for="createaccount"><span>Create an
                                            account?</span></label>
                                </div>
                            </div>
                        </div>
                        <div id="collapsePassword" class="form-group create-account collapse in">
                            <input required="" type="password" placeholder="Password" name="password">
                        </div> --}}
                        {{-- <div class="ship_detail">
                            <div class="form-group">
                                <div class="chek-form">
                                    <div class="custome-checkbox">
                                        <input class="form-check-input" type="checkbox" name="checkbox"
                                            id="differentaddress">
                                        <label class="form-check-label label_info" data-bs-toggle="collapse"
                                            data-target="#collapseAddress" href="#collapseAddress"
                                            aria-controls="collapseAddress" for="differentaddress"><span>Ship to a
                                                different address?</span></label>
                                    </div>
                                </div>
                            </div>
                            <div id="collapseAddress" class="different_address collapse in">
                                <div class="form-group">
                                    <input type="text" required="" id="email" name="fname" placeholder="First name *">
                                </div>
                                <div class="form-group">
                                    <input type="text" required="" name="lname" placeholder="Last name *">
                                </div>


                                <div class="form-group">
                                    <input type="text" name="billing_address" required="" placeholder="Address *">
                                </div>

                                <div class="form-group">
                                    <input required="" type="text" name="city" placeholder="City / Town *">
                                </div>
                                <div class="form-group">
                                    <input required="" type="text" name="state" placeholder="State / County *">
                                </div>
                                <div class="form-group">
                                    <input required="" type="text" name="zipcode" placeholder="Postcode / ZIP *">
                                </div>
                            </div>
                        </div> --}}
                        <div class="mb-20">
                            <h5>Additional information</h5>
                        </div>
                        <div class="form-group mb-30">
                            <textarea rows="5" id="notes" name="order_notes" placeholder="Order notes"></textarea>
                        </div>

                    </div>
                    <div class="col-md-6">
                        <div class="order_review">
                            <div class="mb-20">
                                <h4>Your Orders</h4>
                            </div>
                            <div class="table-responsive order_table text-center">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th colspan="2">Product</th>
                                            <th>Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if (isset($cart_info) && count($cart_info)> 0)
                                        @foreach ($cart_info as $cart)
                                        <tr>
                                            <td class="image product-thumbnail">

                                                @foreach ($cart['product']['media'] as $media)
                                                @if ($media['position'] == 0)
                                                <img src="{{ asset( $media['file_path']. $media['image_name'])}}" alt={{
                                                    $media['image_name'] }}>

                                                @endif

                                                @endforeach

                                            </td>
                                            <td>
                                                <h5><a href="product-details.html">{{ $cart['product']['name'] }}</a>
                                                </h5>
                                                <span class="product-qty">x {{ $cart['quantity'] }}</span>
                                            </td>
                                            <td>৳{{ number_format($cart['product']['sale_price'] * $cart['quantity'],
                                                2)}}</td>
                                        </tr>

                                        @endforeach

                                        @endif


                                        <tr>
                                            <th>SubTotal</th>
                                            <td class="product-subtotal" colspan="1"></td>
                                            <td class="product-subtotal">৳{{ number_format($subTotal,2) }}</td>
                                        </tr>
                                        <tr>
                                            <th>Shipping</th>
                                            <td colspan="2"><em>Free Shipping</em></td>
                                        </tr>
                                        <tr>
                                            <th>Total</th>
                                            <td class="product-subtotal" colspan="1"></td>
                                            <td colspan="2" class="product-subtotal"><span
                                                    class="font-xl text-brand fw-900">৳{{ number_format($subTotal,2)
                                                    }}</span></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="bt-1 border-color-1 mt-30 mb-30"></div>
                            <div class="payment_method">
                                <div class="mb-25">
                                    <h5>Payment</h5>
                                </div>
                                {{-- <div class="payment_option">
                                    <div class="custome-radio">
                                        <input class="form-check-input" required type="radio" name="payment_option"
                                            id="exampleRadios3">
                                        <label class="form-check-label" for="exampleRadios3" data-bs-toggle="collapse"
                                            data-target="#cashOnDelivery" aria-controls="cashOnDelivery">Cash On
                                            Delivery</label>
                                    </div>
                                    <div class="custome-radio">
                                        <input class="form-check-input" required type="radio" name="payment_option"
                                            id="exampleRadios4">
                                        <label class="form-check-label" for="exampleRadios4" data-bs-toggle="collapse"
                                            data-target="#cardPayment" aria-controls="cardPayment">Mobile
                                            Payment</label>
                                    </div>

                                </div> --}}
                            </div>
                            <button class="btn btn-fill-out btn-block mt-30">Place Order</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </section>
</main>
<!--main area-->


@endsection


@section('custom_script')
<script>
    $(document).ready(function() {


        $(document).off('submit', '#billingDetailsForm').on('submit', '#billingDetailsForm', function(e) {
    e.preventDefault();

    // 1. Better Confirmation with SweetAlert instead of browser confirm
    Swal.fire({
        title: 'Confirm Order',
        text: "Are you sure you want to place this order?",
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, Place Order!'
    }).then((result) => {
        if (result.isConfirmed) {

            // 2. Show Loading Overlay
            Swal.fire({
                title: 'Processing your order...',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            // 3. Grab the Data correctly
            let form = $('#billingDetailsForm')[0];
            let formData = new FormData(form);
            // 4. Send via AJAX
            $.ajax({
                url: "{{ route('Product_Checkout_Create') }}", // Replace with your route
                method: "POST",
                data: formData,
                processData: false, // Required for FormData
                contentType: false, // Required for FormData
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    Swal.fire('Success!', 'Your order has been placed.', 'success')
                    .then(() => {
                        window.location.href = "/product/order/success/" + response.order_id;
                    });
                },
                error: function(xhr) {
                    Swal.fire('Error', 'Something went wrong. Please check your details.', 'error');
                }
            });
        }
    });
});

    })
</script>
@endsection
