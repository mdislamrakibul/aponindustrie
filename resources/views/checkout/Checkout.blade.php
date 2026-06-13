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
                                            @if (isset($cart_info) && count($cart_info) > 0)
                                                @foreach ($cart_info as $cart)
                                                    <tr>
                                                        <td class="image product-thumbnail">

                                                            @foreach ($cart['product']['media'] as $media)
                                                                @if ($media['position'] == 1)
                                                                                                <img src="{{ asset($media['file_path'] . $media['image_name'])}}" alt={{
                                                                    $media['image_name'] }}>

                                                                @endif

                                                            @endforeach

                                                        </td>
                                                        <td>
                                                            <h5>{{ $cart['product']['name'] }}
                                                            </h5>
                                                            {{-- <span class="product-qty">x {{ $cart['quantity'] }}</span> --}}
                                                        </td>
                                                        <td>৳{{ number_format($cart['price'], 2)}}</td>
                                                    </tr>

                                                @endforeach

                                            @endif


                                            <tr>
                                                <th>SubTotal</th>
                                                <td class="product-subtotal" colspan="1"></td>
                                                <td class="product-subtotal">৳{{ number_format($subTotal, 2) }}</td>
                                            </tr>
                                            <tr>
                                                <th>Shipping</th>
                                                <td colspan="2"><em>Free Shipping</em></td>
                                            </tr>
                                            <tr>
                                                <th>Total</th>
                                                <td class="product-subtotal" colspan="1"></td>
                                                <td colspan="2" class="product-subtotal"><span
                                                        class="font-xl text-brand fw-900">৳{{ number_format($subTotal, 2)
                                                                        }}</span></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="bt-1 border-color-1 mt-30 mb-30"></div>
                                <div class="payment_method">
                                    <div class="mb-25">
                                        <h5>Payment Method</h5>
                                    </div>

                                    {{-- Payment Option Selector --}}
                                    <div class="payment_option">

                                        {{-- Cash on Delivery --}}
                                        <div class="custome-radio mb-10">
                                            <input class="form-check-input" type="radio" name="payment_option"
                                                id="cashOnDelivery" value="cod" checked>
                                            <label class="form-check-label" for="cashOnDelivery">
                                                <i class="fas fa-truck mr-2" style="color:#28a745;"></i>
                                                Cash on Delivery
                                            </label>
                                        </div>

                                        {{-- Online Payment --}}
                                        <div class="custome-radio mb-10">
                                            <input class="form-check-input" type="radio" name="payment_option"
                                                id="onlinePayment" value="online">
                                            <label class="form-check-label" for="onlinePayment">
                                                <i class="fas fa-mobile-alt mr-2" style="color:#0d6efd;"></i>
                                                Online Payment
                                            </label>
                                        </div>
                                    </div>

                                    {{-- Online Payment Sub-options (hidden by default) --}}
                                    <div id="onlinePaymentOptions" style="display:none; margin-top:15px;">
                                        <p class="font-sm text-muted mb-15">Select your payment provider:</p>

                                        <div class="pay-method-grid">

                                            {{-- Bank Transfer --}}
                                            <label class="pay-card" for="payBank">
                                                <input type="radio" name="online_method" id="payBank" value="BANK">
                                                <div class="pay-card__icon">
                                                    <svg viewBox="0 0 40 40" xmlns="http://www.w3.org/2000/svg">
                                                        <rect width="40" height="40" rx="8" fill="#1565C0"/>
                                                        <polygon points="20,8 32,16 32,18 8,18 8,16" fill="white"/>
                                                        <rect x="11" y="20" width="3.5" height="10" rx="0.5" fill="white"/>
                                                        <rect x="18.25" y="20" width="3.5" height="10" rx="0.5" fill="white"/>
                                                        <rect x="25.5" y="20" width="3.5" height="10" rx="0.5" fill="white"/>
                                                        <rect x="8" y="31" width="24" height="2.5" rx="1" fill="white"/>
                                                    </svg>
                                                </div>
                                                <span class="pay-card__name">Bank Transfer</span>
                                                <span class="pay-card__check"><i class="fas fa-check-circle"></i></span>
                                            </label>

                                            {{-- bKash --}}
                                            <label class="pay-card" for="payBkash">
                                                <input type="radio" name="online_method" id="payBkash" value="BKASH">
                                                <div class="pay-card__icon">
                                                    <svg viewBox="0 0 40 40" xmlns="http://www.w3.org/2000/svg">
                                                        <rect width="40" height="40" rx="8" fill="#E2136E"/>
                                                        <rect x="14" y="9" width="12" height="20" rx="2" fill="none" stroke="white" stroke-width="2"/>
                                                        <rect x="17" y="9" width="6" height="2" rx="1" fill="white" opacity="0.7"/>
                                                        <text x="20" y="23" text-anchor="middle" font-family="Arial,sans-serif" font-size="11" font-weight="bold" fill="white">৳</text>
                                                        <circle cx="20" cy="32" r="1.5" fill="white" opacity="0.8"/>
                                                    </svg>
                                                </div>
                                                <span class="pay-card__name">bKash</span>
                                                <span class="pay-card__check"><i class="fas fa-check-circle"></i></span>
                                            </label>

                                            {{-- Nagad --}}
                                            <label class="pay-card" for="payNagad">
                                                <input type="radio" name="online_method" id="payNagad" value="NAGAD">
                                                <div class="pay-card__icon">
                                                    <svg viewBox="0 0 40 40" xmlns="http://www.w3.org/2000/svg">
                                                        <rect width="40" height="40" rx="8" fill="#F47B25"/>
                                                        <rect x="8" y="15" width="24" height="16" rx="3" fill="none" stroke="white" stroke-width="2"/>
                                                        <rect x="8" y="20" width="24" height="2" fill="white"/>
                                                        <rect x="14" y="12" width="12" height="5" rx="2" fill="none" stroke="white" stroke-width="2"/>
                                                        <rect x="24" y="23" width="5" height="5" rx="2.5" fill="white" opacity="0.9"/>
                                                        <text x="16" y="29" text-anchor="middle" font-family="Arial,sans-serif" font-size="9" font-weight="bold" fill="white">৳</text>
                                                    </svg>
                                                </div>
                                                <span class="pay-card__name">Nagad</span>
                                                <span class="pay-card__check"><i class="fas fa-check-circle"></i></span>
                                            </label>

                                            {{-- Rocket --}}
                                            <label class="pay-card" for="payRocket">
                                                <input type="radio" name="online_method" id="payRocket" value="ROCKET">
                                                <div class="pay-card__icon">
                                                    <svg viewBox="0 0 40 40" xmlns="http://www.w3.org/2000/svg">
                                                        <rect width="40" height="40" rx="8" fill="#8332AC"/>
                                                        <path d="M20,7 C17.5,11 16,16 16,21 L20,23.5 L24,21 C24,16 22.5,11 20,7 Z" fill="white"/>
                                                        <circle cx="20" cy="17" r="2.5" fill="#8332AC"/>
                                                        <path d="M16,21 L12,26.5 L16,24.5 Z" fill="white" opacity="0.85"/>
                                                        <path d="M24,21 L28,26.5 L24,24.5 Z" fill="white" opacity="0.85"/>
                                                        <path d="M17.5,24 Q20,29 22.5,24" fill="none" stroke="white" stroke-width="1.8" stroke-linecap="round"/>
                                                    </svg>
                                                </div>
                                                <span class="pay-card__name">Rocket</span>
                                                <span class="pay-card__check"><i class="fas fa-check-circle"></i></span>
                                            </label>

                                        </div>

                                        {{-- Online payment instruction + proof fields --}}
                                        <div id="onlinePaymentInfo" style="display:none; margin-top:15px;">
                                            <div class="alert alert-info" style="border-radius:8px;">
                                                <i class="fas fa-info-circle mr-2"></i>
                                                <span id="paymentInstructionText"></span>
                                            </div>
                                            <div class="form-group mt-10">
                                                <input type="text" id="transactionRef" name="transaction_ref"
                                                    class="form-control"
                                                    placeholder="Transaction ID / Reference Number *">
                                            </div>
                                            <div class="form-group mt-10">
                                                <input type="text" id="payerNumber" name="payer_number"
                                                    class="form-control"
                                                    placeholder="যে নাম্বার থেকে পেমেন্ট করেছেন (01XXXXXXXXX) *">
                                            </div>
                                            <div class="form-group mt-10">
                                                <label class="font-sm" style="color:#555; margin-bottom:5px; display:block;">
                                                    <i class="fas fa-image mr-1"></i> Payment Screenshot *
                                                </label>
                                                <input type="file" id="paymentScreenshot" name="payment_screenshot"
                                                    class="form-control"
                                                    accept="image/jpeg,image/png,image/jpg"
                                                    style="padding:6px;">
                                                <small class="text-muted">JPG / PNG, সর্বোচ্চ 5MB</small>
                                            </div>
                                        </div>
                                    </div>

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
    <style>
        /* ── Payment Method Cards ── */
        .pay-method-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 10px;
        }
        .pay-card {
            position: relative;
            border: 2px solid #e0e0e0;
            border-radius: 10px;
            padding: 14px 10px 10px;
            cursor: pointer;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 6px;
            background: #fff;
            transition: border-color .15s ease, box-shadow .15s ease, background .15s ease;
            user-select: none;
        }
        .pay-card input[type="radio"] {
            position: absolute;
            opacity: 0;
            width: 0;
            height: 0;
        }
        .pay-card:hover {
            border-color: #3bb77e;
            box-shadow: 0 2px 8px rgba(59,183,126,.15);
        }
        .pay-card.is-selected {
            border-color: #3bb77e;
            background: #f2fbf6;
            box-shadow: 0 3px 12px rgba(59,183,126,.22);
        }
        .pay-card__icon {
            width: 40px;
            height: 40px;
            flex-shrink: 0;
        }
        .pay-card__icon svg {
            width: 40px;
            height: 40px;
        }
        .pay-card__name {
            font-size: 12px;
            font-weight: 600;
            color: #444;
            text-align: center;
            line-height: 1.3;
        }
        .pay-card__check {
            display: none;
            position: absolute;
            top: 5px;
            right: 7px;
            font-size: 14px;
            color: #3bb77e;
        }
        .pay-card.is-selected .pay-card__check {
            display: block;
        }
    </style>

    <script>
        $(document).ready(function () {

            // ── Payment Method Toggle ──
            $('input[name="payment_option"]').on('change', function () {
                if ($(this).val() === 'online') {
                    $('#onlinePaymentOptions').slideDown(200);
                } else {
                    $('#onlinePaymentOptions').slideUp(200);
                    $('#onlinePaymentInfo').hide();
                    $('.pay-card').removeClass('is-selected');
                    $('#transactionRef, #payerNumber, #paymentScreenshot').prop('required', false);
                }
            });

            // ── Payment Card Selection ──
            $('.pay-card').on('click', function () {
                $('.pay-card').removeClass('is-selected');
                $(this).addClass('is-selected');
                $(this).find('input[type="radio"]').prop('checked', true).trigger('change');
            });

            // ── Online Sub-method Instructions ──
            const paymentInstructions = {
                BANK: 'Please transfer to: Bank Asia | Account: 12345678 | Routing: 060271539. Send screenshot via WhatsApp.',
                BKASH: 'Send money to bKash: 01XXXXXXXXX (Merchant). Use "Send Money" and enter your Order Number as reference.',
                NAGAD: 'Send money to Nagad: 01XXXXXXXXX. Enter your Order Number as reference.',
                ROCKET: 'Send money to Rocket: 01XXXXXXXXX-1. Enter your Order Number as reference.',
            };

            $('input[name="online_method"]').on('change', function () {
                let method = $(this).val();
                $('#paymentInstructionText').text(paymentInstructions[method] || '');
                $('#onlinePaymentInfo').slideDown(200);
                $('#transactionRef').prop('required', true);
                $('#payerNumber').prop('required', true);
                $('#paymentScreenshot').prop('required', true);
            });
            $(document).off('submit', '#billingDetailsForm').on('submit', '#billingDetailsForm', function (e) {
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
                        // payment method determine
                        let paymentOption = $('input[name="payment_option"]:checked').val();
                        if (paymentOption === 'online') {
                            let onlineMethod = $('input[name="online_method"]:checked').val();
                            if (!onlineMethod) {
                                Swal.fire('Warning', 'Please select an online payment method.', 'warning');
                                return;
                            }
                            formData.set('payment_method_override', onlineMethod);
                        } else {
                            formData.set('payment_method_override', 'CASH');
                        }
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
                            success: function (response) {
                                Swal.fire('Success!', 'Your order has been placed.', 'success')
                                    .then(() => {
                                        window.location.href = "/product/order/success/" + response.order_number;
                                    });
                            },
                            error: function (xhr) {
                                let errorMessage = 'Something went wrong. Please check your details.';

                                if (xhr.status === 422) {

                                    let errors = xhr.responseJSON?.errors;
                                    if (errors) {
                                        errorMessage = Object.values(errors).flat().join('\n');
                                    } else if (xhr.responseJSON?.message) {
                                        errorMessage = xhr.responseJSON.message;
                                    }
                                } else if (xhr.status === 500) {

                                    errorMessage = xhr.responseJSON?.message || 'Server error. Please try again.';
                                }

                                Swal.fire('Error', errorMessage, 'error');
                            }
                        });
                    }
                });
            });

        })
    </script>
@endsection