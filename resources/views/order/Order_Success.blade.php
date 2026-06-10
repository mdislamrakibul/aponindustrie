@extends('layout.master')

@section('title', 'Order Successful — ' . $order->order_number)

@section('content')
    <main class="main">
        <div class="page-header breadcrumb-wrap">
            <div class="container">
                <div class="breadcrumb">
                    <a href="{{ route('home.index') }}">Home</a>
                    <span></span> Order Successful
                </div>
            </div>
        </div>

        <section class="mt-50 mb-50">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-8">

                        {{-- SUCCESS BANNER --}}
                        <div
                            style="background:linear-gradient(135deg,#064e3b,#059669);border-radius:16px;padding:36px 30px;text-align:center;color:#fff;margin-bottom:30px;box-shadow:0 8px 25px rgba(5,150,105,0.3);">
                            <div style="font-size:3.5rem;margin-bottom:12px;">✓</div>
                            <h2 style="margin:0 0 8px;font-size:1.8rem;font-weight:700;">Order Placed Successfully!</h2>
                            <p style="margin:0;opacity:.9;font-size:1rem;">Thank you for your order. We will contact you
                                shortly.</p>
                            <div
                                style="display:inline-block;margin-top:16px;background:rgba(255,255,255,0.2);border-radius:8px;padding:8px 20px;font-size:1rem;font-weight:600;letter-spacing:1px;">
                                Order ID: #{{ $order->order_number }}
                            </div>
                        </div>

                        {{-- ORDER INFO --}}
                        <div
                            style="background:#fff;border-radius:12px;border:1px solid #e5e7eb;box-shadow:0 2px 12px rgba(0,0,0,0.06);overflow:hidden;margin-bottom:24px;">

                            <div
                                style="background:#f8fafc;border-bottom:1px solid #e5e7eb;padding:16px 24px;display:flex;justify-content:space-between;align-items:center;">
                                <h5 style="margin:0;font-weight:700;color:#1a365d;">Order Summary</h5>
                                <span
                                    style="background:#fef3c7;color:#92400e;padding:4px 12px;border-radius:20px;font-size:12px;font-weight:600;">
                                    {{ $order->order_status }}
                                </span>
                            </div>

                            {{-- Meta info --}}
                            <div style="display:flex;flex-wrap:wrap;border-bottom:1px solid #e5e7eb;">
                                @php
                                    $meta = [
                                        ['Date', \Carbon\Carbon::parse($order->created_at)->format('d M Y, h:i A')],
                                        ['Payment', $order->payment_method],
                                        ['Pay Status', $order->payment_status],
                                        ['Transaction', $order->transaction_id],
                                    ];
                                @endphp
                                @foreach($meta as [$label, $value])
                                    <div style="flex:1 1 45%;padding:14px 24px;border-bottom:1px solid #f0f0f0;">
                                        <div
                                            style="font-size:11px;color:#888;text-transform:uppercase;letter-spacing:.5px;margin-bottom:4px;">
                                            {{ $label }}</div>
                                        <div style="font-weight:600;color:#222;font-size:14px;">{{ $value }}</div>
                                    </div>
                                @endforeach
                            </div>

                            {{-- Product table --}}
                            <table style="width:100%;border-collapse:collapse;">
                                <thead>
                                    <tr style="background:#f8fafc;">
                                        <th
                                            style="padding:12px 24px;text-align:left;font-size:13px;color:#555;font-weight:600;border-bottom:1px solid #e5e7eb;">
                                            Product</th>
                                        <th
                                            style="padding:12px 16px;text-align:center;font-size:13px;color:#555;font-weight:600;border-bottom:1px solid #e5e7eb;">
                                            Unit Price</th>
                                        <th
                                            style="padding:12px 16px;text-align:center;font-size:13px;color:#555;font-weight:600;border-bottom:1px solid #e5e7eb;">
                                            Qty</th>
                                        <th
                                            style="padding:12px 24px;text-align:right;font-size:13px;color:#555;font-weight:600;border-bottom:1px solid #e5e7eb;">
                                            Line Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($order->order_items as $item)
                                        @php

                                            $minOrder = $item->product->minimum_order ?? 1;
                                            $unitPrice = $minOrder > 0
                                                ? $item->price / $minOrder
                                                : $item->price;
                                            $lineTotal = $item->price * ($item->quantity / ($minOrder ?: 1));
                                        @endphp
                                        <tr style="border-bottom:1px solid #f0f0f0;">
                                            <td style="padding:14px 24px;">
                                                <div style="font-weight:600;color:#222;font-size:14px;">
                                                    {{ $item->product->name ?? 'Product' }}
                                                </div>
                                                <div style="font-size:12px;color:#888;margin-top:2px;">
                                                    SKU: {{ $item->product->sku ?? '-' }}
                                                </div>
                                            </td>
                                            <td style="padding:14px 16px;text-align:center;color:#444;font-size:14px;">
                                                ৳{{ number_format($unitPrice, 2) }}
                                            </td>
                                            <td style="padding:14px 16px;text-align:center;">
                                                <span
                                                    style="background:#eff6ff;color:#1d4ed8;padding:3px 10px;border-radius:12px;font-size:13px;font-weight:600;">
                                                    {{ $item->quantity }}
                                                </span>
                                            </td>
                                            <td
                                                style="padding:14px 24px;text-align:right;font-weight:600;color:#222;font-size:14px;">
                                                ৳{{ number_format($item->total, 2) }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>

                            {{-- Totals --}}
                            @php
                                // Sub Total =
                                $subTotal = $order->order_items->sum('total');
                            @endphp
                            <div style="padding:16px 24px;border-top:1px solid #e5e7eb;">
                                <div style="max-width:280px;margin-left:auto;">

                                    <div
                                        style="display:flex;justify-content:space-between;padding:6px 0;color:#555;font-size:14px;">
                                        <span>Sub Total</span>
                                        <span>৳{{ number_format($subTotal, 2) }}</span>
                                    </div>

                                    <div
                                        style="display:flex;justify-content:space-between;padding:6px 0;font-size:14px;color:{{ $order->shipping_amount > 0 ? '#555' : '#059669' }};">
                                        <span>Shipping</span>
                                        <span>{{ $order->shipping_amount > 0 ? '৳' . number_format($order->shipping_amount, 2) : 'Free' }}</span>
                                    </div>

                                    @if($order->tax_amount > 0)
                                        <div
                                            style="display:flex;justify-content:space-between;padding:6px 0;color:#555;font-size:14px;">
                                            <span>Tax</span>
                                            <span>৳{{ number_format($order->tax_amount, 2) }}</span>
                                        </div>
                                    @endif

                                    <div
                                        style="display:flex;justify-content:space-between;padding:12px 0;margin-top:8px;border-top:2px solid #1a365d;font-size:16px;font-weight:700;color:#1a365d;">
                                        <span>Net Payable</span>
                                        <span>৳{{ number_format($subTotal + $order->shipping_amount + $order->tax_amount, 2) }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- CUSTOMER INFO --}}
                        @if($order->order_address)
                            <div
                                style="background:#fff;border-radius:12px;border:1px solid #e5e7eb;box-shadow:0 2px 12px rgba(0,0,0,0.06);overflow:hidden;margin-bottom:30px;">
                                <div style="background:#f8fafc;border-bottom:1px solid #e5e7eb;padding:16px 24px;">
                                    <h5 style="margin:0;font-weight:700;color:#1a365d;">Delivery Information</h5>
                                </div>
                                <div style="padding:20px 24px;">
                                    <div style="display:flex;flex-wrap:wrap;gap:20px;">
                                        @php
                                            $addr = $order->order_address;
                                            $fields = [
                                                ['Name', $addr->first_name . ' ' . $addr->last_name],
                                                ['Phone', $addr->phone],
                                                ['Email', $addr->email],
                                                ['Address', $addr->address_line1],
                                            ];
                                        @endphp
                                        @foreach($fields as [$label, $value])
                                            <div style="flex:1 1 45%;">
                                                <div
                                                    style="font-size:11px;color:#888;text-transform:uppercase;letter-spacing:.5px;margin-bottom:4px;">
                                                    {{ $label }}</div>
                                                <div style="font-weight:600;color:#222;">{{ $value }}</div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        @endif

                        {{-- ACTION BUTTONS --}}
                        <div style="display:flex;gap:12px;justify-content:center;flex-wrap:wrap;">
                            <a href="{{ route('home.index') }}"
                                style="display:inline-block;background:#1a365d;color:#fff;padding:12px 32px;border-radius:8px;text-decoration:none;font-weight:600;font-size:14px;">
                                Continue Shopping
                            </a>
                            <button onclick="window.print()"
                                style="display:inline-block;background:#fff;color:#1a365d;padding:12px 32px;border-radius:8px;border:2px solid #1a365d;font-weight:600;font-size:14px;cursor:pointer;">
                                Print Receipt
                            </button>
                        </div>

                    </div>
                </div>
            </div>
        </section>
    </main>

    <style>
        @media print {

            header,
            footer,
            nav,
            .breadcrumb-wrap,
            div[style*="justify-content:center"] {
                display: none !important;
            }
        }
    </style>
@endsection