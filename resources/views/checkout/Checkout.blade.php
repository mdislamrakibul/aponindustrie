@extends('layout.master')

@section('title', 'Checkout')

@section('content')

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
            <form id="billingDetailsForm" method="post" enctype="multipart/form-data">
                @csrf
                <div class="row">

                    {{-- ── LEFT COLUMN ── --}}
                    <div class="col-lg-7 col-md-12">

                        {{-- Order Review --}}
                        <div class="card border-0 shadow-sm mb-25" style="border-radius:12px;">
                            <div class="card-body p-4">
                                <h5 class="mb-20" style="font-weight:700;">
                                    <i class="fas fa-shopping-cart mr-2" style="color:#3bb77e;"></i>Order Review
                                </h5>
                                <div class="table-responsive">
                                    <table class="table table-borderless" id="cartReviewTable" style="font-size:14px;">
                                        <thead style="background:#f8f9fa;">
                                            <tr>
                                                <th style="font-size:13px;font-weight:600;">Product</th>
                                                <th class="text-center" style="font-size:13px;font-weight:600;">Qty</th>
                                                <th class="text-right" style="font-size:13px;font-weight:600;">Subtotal</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($cart_info as $productId => $cart)
                                            <tr id="cartRow_{{ $productId }}" data-id="{{ $productId }}" data-price="{{ $cart['price'] }}">
                                                <td style="vertical-align:middle;">
                                                    <div class="d-flex align-items-center" style="gap:10px;">
                                                        @foreach($cart['product']['media'] as $media)
                                                            @if($media['position'] == 1)
                                                            <img src="{{ asset($media['file_path'] . $media['image_name']) }}"
                                                                 alt="{{ $media['image_name'] }}"
                                                                 style="width:52px;height:52px;object-fit:cover;border-radius:6px;border:1px solid #eee;flex-shrink:0;">
                                                            @endif
                                                        @endforeach
                                                        <span style="font-size:13px;font-weight:600;color:#333;line-height:1.4;">
                                                            {{ $cart['product']['name'] }}
                                                        </span>
                                                    </div>
                                                </td>
                                                <td class="text-center" style="vertical-align:middle;">
                                                    <div class="d-flex align-items-center justify-content-center" style="gap:4px;">
                                                        <button type="button" class="qty-btn qty-minus" data-id="{{ $productId }}"
                                                            style="width:26px;height:26px;border:1px solid #ddd;background:#fff;border-radius:4px;font-size:15px;line-height:1;cursor:pointer;">−</button>
                                                        <input type="number" class="qty-input text-center" data-id="{{ $productId }}"
                                                               value="{{ $cart['quantity'] }}" min="1"
                                                               style="width:42px;height:26px;border:1px solid #ddd;border-radius:4px;font-size:13px;padding:0 4px;">
                                                        <button type="button" class="qty-btn qty-plus" data-id="{{ $productId }}"
                                                            style="width:26px;height:26px;border:1px solid #ddd;background:#fff;border-radius:4px;font-size:15px;line-height:1;cursor:pointer;">+</button>
                                                    </div>
                                                </td>
                                                <td class="text-right" style="vertical-align:middle;">
                                                    <span class="row-total" data-id="{{ $productId }}"
                                                          style="font-weight:600;color:#3bb77e;">
                                                        ৳{{ number_format($cart['price'] * $cart['quantity'], 2) }}
                                                    </span>
                                                </td>
                                                <td class="text-center" style="vertical-align:middle;">
                                                    <button type="button" class="cart-remove-btn" data-id="{{ $productId }}"
                                                        style="border:none;background:none;color:#dc3545;font-size:16px;cursor:pointer;padding:4px 6px;"
                                                        title="Remove item">
                                                        <i class="fas fa-trash-alt"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        {{-- Shipping Address --}}
                        <div class="card border-0 shadow-sm mb-25" style="border-radius:12px;">
                            <div class="card-body p-4">
                                <h5 class="mb-20" style="font-weight:700;">
                                    <i class="fas fa-map-marker-alt mr-2" style="color:#3bb77e;"></i>Shipping Address
                                </h5>

                                <div class="form-group">
                                    <label class="font-sm mb-5" style="color:#555;display:block;">Full Name *</label>
                                    <input type="text" id="full_name" name="full_name" required
                                           class="form-control" placeholder="Your full name">
                                </div>

                                <div class="form-group">
                                    <label class="font-sm mb-5" style="color:#555;display:block;">Phone Number *</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"
                                                  style="background:#f0faf5;border-color:#ddd;font-weight:600;color:#555;">+88</span>
                                        </div>
                                        <input type="text" id="phone" name="phone" required
                                               class="form-control"
                                               pattern="^(?:\+88|88)?(01[3-9]\d{8})$"
                                               placeholder="01XXXXXXXXX">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="font-sm mb-5" style="color:#555;display:block;">Address *</label>
                                    <input type="text" id="billing_address" name="billing_address" required
                                           class="form-control" placeholder="House no, Road, Area">
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="font-sm mb-5" style="color:#555;display:block;">District *</label>
                                            <select id="districtSelect" name="district" required class="form-control">
                                                <option value="">-- Select District --</option>
                                                @php
                                                $districts = ['Bagerhat','Bandarban','Barguna','Barisal','Bhola','Bogura','Brahmanbaria','Chandpur','Chattogram','Chuadanga',"Cox's Bazar",'Cumilla','Dhaka','Dinajpur','Faridpur','Feni','Gaibandha','Gazipur','Gopalganj','Habiganj','Jamalpur','Jashore','Jhalokati','Jhenaidah','Joypurhat','Khagrachhari','Khulna','Kishoreganj','Kurigram','Kushtia','Lakshmipur','Lalmonirhat','Madaripur','Magura','Manikganj','Meherpur','Moulvibazar','Munshiganj','Mymensingh','Naogaon','Narail','Narayanganj','Narsingdi','Natore','Chapainawabganj','Netrokona','Nilphamari','Noakhali','Pabna','Panchagarh','Patuakhali','Pirojpur','Rajbari','Rajshahi','Rangamati','Rangpur','Satkhira','Shariatpur','Sherpur','Sirajganj','Sunamganj','Sylhet','Tangail','Thakurgaon'];
                                                @endphp
                                                @foreach($districts as $d)
                                                <option value="{{ $d }}">{{ $d }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="font-sm mb-5" style="color:#555;display:block;">
                                                Thana / Upazila <span style="color:#aaa;font-weight:400;">(optional)</span>
                                            </label>
                                            <input type="text" id="thana" name="thana"
                                                   class="form-control" placeholder="e.g. Dhanmondi">
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="font-sm mb-5" style="color:#555;display:block;">
                                        Email <span style="color:#aaa;font-weight:400;">(optional)</span>
                                    </label>
                                    <input type="email" id="email" name="email"
                                           class="form-control" placeholder="example@email.com">
                                </div>
                            </div>
                        </div>

                        {{-- Billing Address --}}
                        <div class="card border-0 shadow-sm mb-25" style="border-radius:12px;">
                            <div class="card-body p-4">
                                <h5 class="mb-15" style="font-weight:700;">
                                    <i class="fas fa-file-invoice mr-2" style="color:#3bb77e;"></i>Billing Address
                                </h5>
                                <div class="custome-checkbox mb-0">
                                    <input class="form-check-input" type="checkbox" id="sameAsShipping" checked>
                                    <label class="form-check-label" for="sameAsShipping">
                                        <span>Same as shipping address</span>
                                    </label>
                                </div>
                                <div id="billingAddressFields" style="display:none;margin-top:15px;">
                                    <div class="form-group">
                                        <input type="text" name="billing_full_name"
                                               class="form-control" placeholder="Full Name">
                                    </div>
                                    <div class="form-group">
                                        <input type="text" name="billing_address_alt"
                                               class="form-control" placeholder="Address">
                                    </div>
                                    <div class="form-group mb-0">
                                        <input type="text" name="billing_district"
                                               class="form-control" placeholder="District">
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                    {{-- ── RIGHT COLUMN ── --}}
                    <div class="col-lg-5 col-md-12">

                        {{-- Payment Method --}}
                        <div class="card border-0 shadow-sm mb-25" style="border-radius:12px;">
                            <div class="card-body p-4">
                                <h5 class="mb-20" style="font-weight:700;">
                                    <i class="fas fa-credit-card mr-2" style="color:#3bb77e;"></i>Payment Method
                                </h5>

                                <div class="payment_option">
                                    <div class="custome-radio mb-10">
                                        <input class="form-check-input" type="radio" name="payment_option"
                                               id="cashOnDelivery" value="cod" checked>
                                        <label class="form-check-label" for="cashOnDelivery">
                                            <i class="fas fa-truck mr-2" style="color:#28a745;"></i>Cash on Delivery
                                        </label>
                                    </div>
                                    <div class="custome-radio mb-10">
                                        <input class="form-check-input" type="radio" name="payment_option"
                                               id="onlinePayment" value="online">
                                        <label class="form-check-label" for="onlinePayment">
                                            <i class="fas fa-mobile-alt mr-2" style="color:#0d6efd;"></i>Online Payment
                                        </label>
                                    </div>
                                </div>

                                <div id="onlinePaymentOptions" style="display:none;margin-top:15px;">
                                    <p class="font-sm text-muted mb-15">Select your payment provider:</p>
                                    <div class="pay-method-grid">

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

                                    <div id="onlinePaymentInfo" style="display:none;margin-top:15px;">
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
                                            <label class="font-sm" style="color:#555;margin-bottom:5px;display:block;">
                                                <i class="fas fa-image mr-1"></i> Payment Screenshot *
                                            </label>
                                            <input type="file" id="paymentScreenshot" name="payment_screenshot"
                                                   class="form-control" accept="image/jpeg,image/png,image/jpg"
                                                   style="padding:6px;">
                                            <small class="text-muted">JPG / PNG, সর্বোচ্চ 5MB</small>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>

                        {{-- Order Summary --}}
                        <div class="card border-0 shadow-sm mb-25" style="border-radius:12px;">
                            <div class="card-body p-4">
                                <h5 class="mb-20" style="font-weight:700;">
                                    <i class="fas fa-receipt mr-2" style="color:#3bb77e;"></i>Order Summary
                                </h5>

                                <div id="freeDeliveryOffer"
                                     style="display:none;border-radius:8px;font-size:13px;margin-bottom:14px;padding:10px 14px;"></div>

                                <div id="summaryData"
                                     data-subtotal="{{ $subTotal }}"
                                     data-inside="{{ config('delivery.inside_dhaka') }}"
                                     data-outside="{{ config('delivery.outside_dhaka') }}"
                                     data-free="{{ config('delivery.free_threshold') }}">
                                </div>

                                <table class="table table-borderless mb-10" style="font-size:14px;">
                                    <tr>
                                        <td style="color:#555;padding:6px 0;">Subtotal</td>
                                        <td class="text-right" style="padding:6px 0;font-weight:600;">
                                            ৳{{ number_format($subTotal, 2) }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="color:#555;padding:6px 0;">Delivery Charge</td>
                                        <td class="text-right" style="padding:6px 0;">
                                            <span id="deliveryCostCell" style="color:#3bb77e;font-weight:600;">
                                                <em style="color:#aaa;">Select district…</em>
                                            </span>
                                        </td>
                                    </tr>
                                    <tr style="border-top:2px solid #f0f0f0;">
                                        <td style="font-weight:700;font-size:15px;padding-top:10px;">Total</td>
                                        <td class="text-right" style="padding-top:10px;">
                                            <span id="grandTotalCell"
                                                  style="font-weight:800;font-size:18px;color:#3bb77e;">
                                                ৳{{ number_format($subTotal, 2) }}
                                            </span>
                                        </td>
                                    </tr>
                                </table>

                                <input type="hidden" name="delivery_charge" id="deliveryChargeInput" value="">

                                <div class="form-group mt-15">
                                    <label class="font-sm mb-5" style="color:#555;display:block;">
                                        Order Notes <span style="color:#aaa;font-weight:400;">(optional)</span>
                                    </label>
                                    <textarea rows="3" id="notes" name="order_notes"
                                              class="form-control" maxlength="90"
                                              placeholder="Any special instructions…"></textarea>
                                    <small class="text-muted"><span id="notesCounter">0</span>/90</small>
                                </div>

                                <div class="custome-checkbox mt-15 mb-20">
                                    <input class="form-check-input" type="checkbox" id="termsCheck" required>
                                    <label class="form-check-label" for="termsCheck">
                                        <span>I agree to the <a href="#" style="color:#3bb77e;">Terms &amp; Conditions</a></span>
                                    </label>
                                </div>

                                <button type="submit" class="btn btn-fill-out btn-block" id="placeOrderBtn">
                                    <i class="fas fa-lock mr-2"></i>Place Order
                                </button>
                            </div>
                        </div>

                    </div>
                </div>
            </form>
        </div>
    </section>
</main>

@endsection


@section('custom_script')
<style>
    /* ── Card hover ── */
    .card { transition: box-shadow .2s ease; }

    /* ── Qty stepper ── */
    .qty-btn:hover { background: #f0faf5 !important; border-color: #3bb77e !important; }
    .qty-input::-webkit-outer-spin-button,
    .qty-input::-webkit-inner-spin-button { -webkit-appearance: none; }
    .qty-input { -moz-appearance: textfield; }

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
        transition: border-color .15s, box-shadow .15s, background .15s;
        user-select: none;
    }
    .pay-card input[type="radio"] { position: absolute; opacity: 0; width: 0; height: 0; }
    .pay-card:hover { border-color: #3bb77e; box-shadow: 0 2px 8px rgba(59,183,126,.15); }
    .pay-card.is-selected { border-color: #3bb77e; background: #f2fbf6; box-shadow: 0 3px 12px rgba(59,183,126,.22); }
    .pay-card__icon { width: 40px; height: 40px; }
    .pay-card__icon svg { width: 40px; height: 40px; }
    .pay-card__name { font-size: 12px; font-weight: 600; color: #444; text-align: center; }
    .pay-card__check { display: none; position: absolute; top: 5px; right: 7px; font-size: 14px; color: #3bb77e; }
    .pay-card.is-selected .pay-card__check { display: block; }

    /* ── Select2: match Bootstrap form-control height ── */
    .select2-container--default .select2-selection--single {
        height: calc(1.5em + .75rem + 2px) !important;
        border: 1px solid #ced4da !important;
        border-radius: .25rem !important;
        padding: .375rem .75rem !important;
        line-height: 1.5 !important;
    }
    .select2-container--default .select2-selection--single .select2-selection__rendered {
        line-height: 1.5 !important;
        padding: 0 !important;
        color: #495057;
    }
    .select2-container--default .select2-selection--single .select2-selection__arrow {
        height: 100% !important;
        top: 0 !important;
    }
    .select2-container { width: 100% !important; }
</style>

<script>
$(document).ready(function () {

    // ── Select2: District (manual init — do NOT add select-active class) ──
    $('#districtSelect').select2({
        placeholder: '-- Select District --',
        allowClear: true,
        width: '100%'
    });

    $('#districtSelect').on('change', function () {
        calcDelivery();
    });

    // ── Delivery charge calculator ──
    function calcDelivery() {
        var data    = document.getElementById('summaryData');
        var sub     = parseFloat(data.dataset.subtotal) || 0;
        var inside  = parseFloat(data.dataset.inside)   || 100;
        var outside = parseFloat(data.dataset.outside)  || 150;
        var free    = parseFloat(data.dataset.free)     || 1000;

        var district = $('#districtSelect').val() || '';

        if (!district) {
            $('#deliveryCostCell').html('<em style="color:#aaa;">Select district…</em>');
            $('#grandTotalCell').text('৳' + sub.toLocaleString('en-BD', {minimumFractionDigits: 2}));
            $('#deliveryChargeInput').val('');
            $('#freeDeliveryOffer').hide();
            return;
        }

        var isInsideDhaka = (district === 'Dhaka');
        var charge = sub > free ? 0 : (isInsideDhaka ? inside : outside);

        if (charge === 0) {
            $('#deliveryCostCell').html('<em style="color:#3bb77e;font-weight:600;">Free Shipping 🎉</em>');
        } else {
            $('#deliveryCostCell').text('৳' + charge.toFixed(2));
        }
        $('#grandTotalCell').text('৳' + (sub + charge).toLocaleString('en-BD', {minimumFractionDigits: 2}));
        $('#deliveryChargeInput').val(charge);

        var box = document.getElementById('freeDeliveryOffer');
        if (sub >= free || charge === 0) {
            box.style.background = '#e6f7ec';
            box.style.color      = '#1a7f4b';
            box.style.border     = '1px solid #b7e4cb';
            box.innerHTML        = '🎉 You have unlocked <b>FREE delivery</b> on this order!';
        } else {
            var remaining = (free - sub).toLocaleString('en-BD', {minimumFractionDigits: 2});
            box.style.background = '#fff8e6';
            box.style.color      = '#a86b00';
            box.style.border     = '1px solid #ffe08a';
            box.innerHTML        = 'Add <b>৳' + remaining + '</b> more to get <b>FREE delivery!</b> (Free on orders above ৳' + free + ')';
        }
        $(box).show();
    }

    // ── Cart qty stepper ──
    $(document).on('click', '.qty-minus, .qty-plus', function () {
        var id    = $(this).data('id');
        var input = $('.qty-input[data-id="' + id + '"]');
        var qty   = parseInt(input.val()) || 1;
        qty = $(this).hasClass('qty-minus') ? Math.max(1, qty - 1) : qty + 1;
        input.val(qty);
        updateCartQty(id, qty);
    });

    $(document).on('change', '.qty-input', function () {
        var id  = $(this).data('id');
        var qty = Math.max(1, parseInt($(this).val()) || 1);
        $(this).val(qty);
        updateCartQty(id, qty);
    });

    var cartUpdateUrl = '{{ route("Product_Cart_update_Single", ["id" => "__ID__", "quantity" => "__QTY__"]) }}';
    var cartRemoveUrl = '{{ route("Product_Cart_Remove_Single", ["id" => "__ID__"]) }}';

    function updateCartQty(productId, qty) {
        var url = cartUpdateUrl.replace('__ID__', productId).replace('__QTY__', qty);
        $.get(url)
            .done(function (res) {
                if (res && res.status === 'success') {
                    var price = parseFloat($('#cartRow_' + productId).data('price')) || 0;
                    $('.row-total[data-id="' + productId + '"]')
                        .text('৳' + (price * qty).toLocaleString('en-BD', {minimumFractionDigits: 2}));
                    recalcSubtotal();
                }
            });
    }

    function recalcSubtotal() {
        var newSub = 0;
        $('.row-total').each(function () {
            newSub += parseFloat($(this).text().replace('৳', '').replace(/,/g, '')) || 0;
        });
        document.getElementById('summaryData').dataset.subtotal = newSub;
        calcDelivery();
    }

    // ── Cart item remove ──
    $(document).on('click', '.cart-remove-btn', function () {
        var id = $(this).data('id');
        Swal.fire({
            title: 'Remove Item?',
            text: 'Remove this item from your cart?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc3545',
            confirmButtonText: 'Yes, remove it!'
        }).then(function (result) {
            if (result.isConfirmed) {
                $.get(cartRemoveUrl.replace('__ID__', id))
                    .done(function (res) {
                        if (res && res.status === 'success') {
                            $('#cartRow_' + id).fadeOut(300, function () {
                                $(this).remove();
                                recalcSubtotal();
                                if ($('#cartReviewTable tbody tr').length === 0) {
                                    window.location.href = '{{ route("home.index") }}';
                                }
                            });
                        }
                    });
            }
        });
    });

    // ── Same-as-shipping toggle ──
    $('#sameAsShipping').on('change', function () {
        if ($(this).is(':checked')) {
            $('#billingAddressFields').slideUp(200);
        } else {
            $('#billingAddressFields').slideDown(200);
        }
    });

    // ── Notes character counter ──
    $('#notes').on('input', function () {
        $('#notesCounter').text($(this).val().length);
    });

    // ── Payment method toggle ──
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

    // ── Payment card selection ──
    $('.pay-card').on('click', function () {
        $('.pay-card').removeClass('is-selected');
        $(this).addClass('is-selected');
        $(this).find('input[type="radio"]').prop('checked', true).trigger('change');
    });

    // ── Online sub-method instructions ──
    var paymentInstructions = {
        BANK:   'Please transfer to: Bank Asia | Account: 12345678 | Routing: 060271539. Send screenshot via WhatsApp.',
        BKASH:  'Send money to bKash: 01XXXXXXXXX (Merchant). Use "Send Money" and enter your Order Number as reference.',
        NAGAD:  'Send money to Nagad: 01XXXXXXXXX. Enter your Order Number as reference.',
        ROCKET: 'Send money to Rocket: 01XXXXXXXXX-1. Enter your Order Number as reference.',
    };

    $('input[name="online_method"]').on('change', function () {
        $('#paymentInstructionText').text(paymentInstructions[$(this).val()] || '');
        $('#onlinePaymentInfo').slideDown(200);
        $('#transactionRef, #payerNumber, #paymentScreenshot').prop('required', true);
    });

    // ── Form submit ──
    $(document).off('submit', '#billingDetailsForm').on('submit', '#billingDetailsForm', function (e) {
        e.preventDefault();

        if (!$('#districtSelect').val()) {
            Swal.fire('District Required', 'Please select your district to calculate the delivery charge.', 'warning');
            $('#districtSelect').next('.select2-container').find('.select2-selection').css('border-color', '#dc3545');
            return;
        }

        Swal.fire({
            title: 'Confirm Order',
            text: 'Are you sure you want to place this order?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, Place Order!'
        }).then(function (result) {
            if (!result.isConfirmed) return;

            Swal.fire({
                title: 'Processing your order…',
                allowOutsideClick: false,
                didOpen: function () { Swal.showLoading(); }
            });

            var formData = new FormData(document.getElementById('billingDetailsForm'));

            var paymentOption = $('input[name="payment_option"]:checked').val();
            if (paymentOption === 'online') {
                var onlineMethod = $('input[name="online_method"]:checked').val();
                if (!onlineMethod) {
                    Swal.fire('Warning', 'Please select an online payment method.', 'warning');
                    return;
                }
                formData.set('payment_method_override', onlineMethod);
            } else {
                formData.set('payment_method_override', 'CASH');
            }

            $.ajax({
                url:         '{{ route("Product_Checkout_Create") }}',
                method:      'POST',
                data:        formData,
                processData: false,
                contentType: false,
                headers:     {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                success: function (response) {
                    Swal.fire('Success!', 'Your order has been placed.', 'success')
                        .then(function () {
                            window.location.href = '/product/order/success/' + response.order_number;
                        });
                },
                error: function (xhr) {
                    var msg = 'Something went wrong. Please check your details.';
                    if (xhr.status === 422) {
                        var errors = xhr.responseJSON && xhr.responseJSON.errors;
                        msg = errors
                            ? Object.values(errors).flat().join('\n')
                            : ((xhr.responseJSON && xhr.responseJSON.message) || msg);
                    } else if (xhr.status === 500) {
                        msg = (xhr.responseJSON && xhr.responseJSON.message) || 'Server error. Please try again.';
                    }
                    Swal.fire('Error', msg, 'error');
                }
            });
        });
    });

});
</script>
@endsection
