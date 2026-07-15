{{-- Shared mini-cart dropdown content (desktop + mobile), also rendered
     directly by CartController::miniCart() so JS can refresh it via AJAX
     after any add/update/remove action, without a full page reload.
     Params: $subtotalId (string), $withLinks (bool, desktop only). --}}
@php $withLinks = $withLinks ?? false; @endphp
@if (session('cart') && count(session('cart')) > 0)
<ul>
    @foreach (session('cart') as $cart)
        @php $prod = $cart['product'] ?? null; $cat = $prod['category'] ?? null; @endphp
        @if ($prod)
        <li>
            <div class="header-cart-serial">{{ $loop->iteration }}</div>
            <div class="shopping-cart-img">
                @foreach (($prod['media'] ?? []) as $media)
                    @if (($media['position'] ?? null) == 1)
                        <img src="{{ asset(($media['file_path'] ?? '') . ($media['image_name'] ?? '')) }}"
                            alt="{{ $media['image_name'] ?? '' }}">
                    @endif
                @endforeach
            </div>
            <div class="shopping-cart-title">
                <div class="header-cart-stepper" data-product-id="{{ $prod['id'] ?? 0 }}">
                    <button type="button" class="header-cart-stepper__btn header-cart-stepper__btn--minus" aria-label="Decrease quantity">&minus;</button>
                    <span class="header-cart-stepper__qty">{{ $cart['quantity'] ?? 1 }}</span>
                    <button type="button" class="header-cart-stepper__btn header-cart-stepper__btn--plus" aria-label="Increase quantity">+</button>
                </div>
                <h4>
                    @if ($withLinks && $cat)
                        <a href="{{ route('Product_Details', ['product_name' => $prod['name'] ?? '', 'category_name' => $cat['name'] ?? '', 'auth_expired_key' => 'eyJhbGciOiJFZERTQSIsInR5cCI6IkpXVCJ9.eyJzdWIiOiIxMjM0NTY3ODkwIiwibmFtZSI6IkpvaG4gRG9lIiwiYWRtaW4iOnRydWUsImlhdCI6MTUxNjIzOTAyMn0.JkKWCY39IdWEQttmdqR7VdsvT-_QxheW_eb0S5wr_j83ltux_JDUIXs7a3Dtn3xuqzuhetiuJrWIvy5TzimeCg', 'category_id' => $cat['id'] ?? 0, 'product_id' => $prod['id'] ?? 0]) }}">{{ $prod['name'] ?? '' }}</a>
                    @else
                        {{ $prod['name'] ?? '' }}
                    @endif
                </h4>
                <h4>৳{{ number_format($cart['price'] ?? 0, 2) }}</h4>
            </div>
        </li>
        @endif
    @endforeach
</ul>
<div class="shopping-cart-footer">
    <div class="shopping-cart-total">
        <h4>Total <span>৳<span id="{{ $subtotalId }}">
            @php
                $subtotal = collect(session('cart'))->sum(function ($item) {
                    return $item['price'] * $item['quantity'];
                });
            @endphp
            {{ number_format($subtotal, 2) }}
        </span></span></h4>
    </div>
    <div class="shopping-cart-button">
        <a href="{{ route('Product_Cart') }}" class="outline">View cart</a>
        <a href="{{ route('Product_Checkout') }}">Checkout</a>
    </div>
</div>
@else
No Items
@endif
