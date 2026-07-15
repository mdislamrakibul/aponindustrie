{{-- Cart page's own items table + Cart Totals box. Also rendered directly
     by CartController's add/update/remove endpoints so JS can refresh this
     section via AJAX (e.g. after adding a "New Arrivals" product from this
     same page) without a full page reload. Expects $cart_info, $subTotal. --}}
<div class="row mb-50">
    @if (isset($cart_info) && count($cart_info) > 0)
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
                        <th scope="col">Quantity</th>
                        <th scope="col">Remove</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($cart_info as $cart)
                    <tr>
                        <td class="image product-thumbnail">
                            @foreach ($cart['product']['media'] as $media)
                                @if ($media['position'] == 1)
                                    <img src="{{ asset($media['file_path'] . $media['image_name']) }}" alt="{{ $media['image_name'] }}">
                                @endif
                            @endforeach
                        </td>
                        <td class="product-des product-name" style="text-align: left;">
                            <h5 class="product-name"><a href="product-details.html">
                                    {{ $cart['product']['name'] }}</a></h5>
                        </td>
                        <td class="price" data-title="Price" style="font-weight:bold"><span>৳{{ $cart['product']['package_price'] }}
                            </span>
                        </td>
                        <td class="action" data-title="update">
                            <span style="font-weight:bold">{{ $cart['minimum_order'] }}
                            </span>
                        </td>
                        <td class="text-right" data-title="Cart" style="font-weight:bold">
                            <span>৳{{ number_format($cart['product']['package_price'] * $cart['quantity'], 2) }} </span>
                        </td>
                        <td class="action" data-title="Quantity">
                            <div class="cart-qty-stepper" data-product-id="{{ $cart['product']['id'] }}">
                                <button type="button" class="cart-qty-stepper__btn cart-qty-stepper__btn--minus" aria-label="Decrease quantity">&minus;</button>
                                <span class="cart-qty-stepper__qty">{{ $cart['quantity'] }}</span>
                                <button type="button" class="cart-qty-stepper__btn cart-qty-stepper__btn--plus" aria-label="Increase quantity">+</button>
                            </div>
                        </td>
                        <td class="action" data-title="Remove">
                            <input type="hidden" value="{{ $cart['product']['id'] }}" class="remove_item_id">
                            <a href="#" class="text-muted" id="remove_single_item" data-id="{{ $cart['product']['id'] }}">
                                <i class="fi-rs-trash" style="color: red;"></i>
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="cart-action text-end">
            <a class="btn mr-10 mb-sm-15" data-bs-toggle="modal" id="delete_pop_modal"
                data-bs-target="#delete_modal"><i class="fi-rs-trash mr-10"></i>
                Clear Cart
            </a>
            <a class="btn " href="{{ route('home.index') }}"><i
                    class="fi-rs-shopping-bag mr-10"></i>Continue Shopping</a>
        </div>
    </div>
    <div class="col-lg-4 col-md-12">
        @php
            $deliveryInside   = config('delivery.inside_dhaka');
            $deliveryOutside  = config('delivery.outside_dhaka');
            $freeThreshold    = config('delivery.free_threshold');
            $isFreeDelivery   = $subTotal >= $freeThreshold;
        @endphp

        {{-- Free delivery offer notification --}}
        @if($isFreeDelivery)
        <div style="background:#e6f7ec;color:#1a7f4b;border:1px solid #b7e4cb;border-radius:10px;padding:12px 16px;font-size:14px;margin-bottom:16px;">
            🎉 You have unlocked <strong>FREE delivery</strong> on this order!
        </div>
        @else
        @php $remaining = $freeThreshold - $subTotal; @endphp
        <div style="background:#fff8e6;color:#a86b00;border:1px solid #ffe08a;border-radius:10px;padding:12px 16px;font-size:14px;margin-bottom:16px;">
            Add <strong>৳{{ number_format($remaining, 2) }}</strong> more to get <strong>FREE delivery!</strong>
            <span style="display:block;margin-top:4px;font-size:12px;color:#c47f00;">Free delivery on orders above ৳{{ number_format($freeThreshold, 0) }}</span>
        </div>
        @endif

        <div class="border p-md-4 p-10 border-radius cart-totals">
            <div class="heading_s1 mb-3">
                <h4>Cart Totals</h4>
            </div>
            <div class="table-responsive">
                <table class="table">
                    <tbody>
                        <tr>
                            <td class="cart_total_label">Cart Subtotal</td>
                            <td class="cart_total_amount">
                                <span class="font-lg fw-900 text-brand">৳{{ number_format($subTotal, 2) }}</span>
                            </td>
                        </tr>
                        <tr>
                            <td class="cart_total_label">Shipping</td>
                            <td class="cart_total_amount">
                                @if($isFreeDelivery)
                                    <i class="ti-gift mr-5" style="color:#0d3b66;"></i>
                                    <span style="color:#0d3b66;font-weight:600;">Free Shipping 🎉</span>
                                @else
                                    <span style="font-weight:600;">৳{{ $deliveryInside }} – ৳{{ $deliveryOutside }}</span>
                                    <br><small class="text-muted" style="font-size:11px;">Exact charge set at checkout</small>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td class="cart_total_label">Total</td>
                            <td class="cart_total_amount">
                                <strong>
                                @if($isFreeDelivery)
                                    <span class="font-xl fw-900 text-brand">৳{{ number_format($subTotal, 2) }}</span>
                                @else
                                    <span class="font-xl fw-900 text-brand">
                                        ৳{{ number_format($subTotal + $deliveryInside, 2) }}
                                        – ৳{{ number_format($subTotal + $deliveryOutside, 2) }}
                                    </span>
                                @endif
                                </strong>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            @if (isset($cart_info) && count($cart_info) > 0)
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
