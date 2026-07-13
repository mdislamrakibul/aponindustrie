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

    {{-- ═══════════════════════════════════════════════
         PRINT-ONLY INVOICE
         Hidden on screen, shown only when printing
    ═══════════════════════════════════════════════ --}}
    @php
        $addr    = $order->order_address;
        $subTotal = $order->order_items->sum('total');
        $grandTotal = $subTotal + $order->shipping_amount + ($order->tax_amount ?? 0);
    @endphp

    <div id="invoice-print">

        {{-- Header --}}
        <div class="inv-header">
            <div class="inv-logo-block">
                <img src="{{ asset('assets/imgs/logo/logo.png') }}" alt="Apon Plastic Industries" class="inv-logo">
            </div>
            <div class="inv-company-info">
                <div class="inv-company-name">Apon Plastic Industries</div>
                <div class="inv-company-sub">Narayanganj, Bangladesh</div>
                <div class="inv-company-sub">Phone: +880 1330-473873</div>
                <div class="inv-company-sub">Email: info@aponindustries.com</div>
                <div class="inv-company-sub">Web: aponindustries.com</div>
            </div>
            <div class="inv-meta-block">
                <div class="inv-badge">INVOICE</div>
                <table class="inv-meta-table">
                    <tr><td>Invoice No</td><td><strong>#{{ $order->order_number }}</strong></td></tr>
                    <tr><td>Date</td><td>{{ \Carbon\Carbon::parse($order->created_at)->format('d M Y') }}</td></tr>
                    <tr><td>Payment</td><td>{{ $order->payment_method }}</td></tr>
                    <tr><td>Status</td><td>{{ $order->payment_status }}</td></tr>
                </table>
            </div>
        </div>

        <div class="inv-divider"></div>

        {{-- Bill To --}}
        @if($addr)
        <div class="inv-bill-section">
            <div class="inv-bill-to">
                <div class="inv-section-title">Bill To</div>
                <div class="inv-bill-name">{{ $addr->first_name }} {{ $addr->last_name }}</div>
                @if($addr->phone) <div class="inv-bill-line">{{ $addr->phone }}</div> @endif
                @if($addr->email) <div class="inv-bill-line">{{ $addr->email }}</div> @endif
                @if($addr->address_line1) <div class="inv-bill-line">{{ $addr->address_line1 }}</div> @endif
                @if(isset($addr->district) && $addr->district) <div class="inv-bill-line">{{ $addr->district }}</div> @endif
            </div>
            <div class="inv-order-status-block">
                <div class="inv-section-title">Order Status</div>
                <div class="inv-status-pill">{{ $order->order_status }}</div>
                @if($order->transaction_id)
                    <div class="inv-bill-line" style="margin-top:6px;font-size:11px;color:#666;">Txn: {{ $order->transaction_id }}</div>
                @endif
            </div>
        </div>
        @endif

        {{-- Items Table --}}
        <table class="inv-table">
            <thead>
                <tr>
                    <th class="inv-th" style="width:5%;text-align:center;">#</th>
                    <th class="inv-th">Product</th>
                    <th class="inv-th" style="width:15%;text-align:center;">Unit Price</th>
                    <th class="inv-th" style="width:10%;text-align:center;">Qty</th>
                    <th class="inv-th" style="width:15%;text-align:right;">Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach($order->order_items as $i => $item)
                @php
                    $minOrder  = $item->product?->minimum_order ?? 1;
                    $unitPrice = $minOrder > 0 ? $item->price / $minOrder : $item->price;
                @endphp
                <tr class="{{ $loop->even ? 'inv-row-alt' : '' }}">
                    <td class="inv-td" style="text-align:center;color:#888;">{{ $i + 1 }}</td>
                    <td class="inv-td"><strong>{{ $item->product?->name ?? 'Product' }}</strong></td>
                    <td class="inv-td" style="text-align:center;">৳{{ number_format($unitPrice, 2) }}</td>
                    <td class="inv-td" style="text-align:center;">{{ $item->quantity }}</td>
                    <td class="inv-td" style="text-align:right;font-weight:600;">৳{{ number_format($item->total, 2) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        {{-- Totals --}}
        <div class="inv-totals-wrap">
            <table class="inv-totals-table">
                <tr>
                    <td class="inv-total-label">Sub Total</td>
                    <td class="inv-total-value">৳{{ number_format($subTotal, 2) }}</td>
                </tr>
                <tr>
                    <td class="inv-total-label">Shipping</td>
                    <td class="inv-total-value">{{ $order->shipping_amount > 0 ? '৳'.number_format($order->shipping_amount,2) : 'Free' }}</td>
                </tr>
                @if(($order->tax_amount ?? 0) > 0)
                <tr>
                    <td class="inv-total-label">Tax</td>
                    <td class="inv-total-value">৳{{ number_format($order->tax_amount, 2) }}</td>
                </tr>
                @endif
                <tr class="inv-grand-row">
                    <td class="inv-total-label">Net Payable</td>
                    <td class="inv-total-value">৳{{ number_format($grandTotal, 2) }}</td>
                </tr>
            </table>
        </div>

        {{-- Footer --}}
        <div class="inv-footer">
            <p>Thank you for shopping with <strong>Apon Plastic Industries</strong>!</p>
            <p style="color:#888;font-size:11px;font-style:italic;">This is a software generated invoice. Therefore, no signature is required.</p>
            <div class="inv-credit">
                Design, Developed &amp; Managed by
                <a href="https://versedsoft.com/" target="_blank" rel="noopener">Versedsoft &mdash; Your Complication, Our Solutions</a>
                <div>+8801723821264 (WhatsApp)</div>
            </div>
        </div>

    </div>{{-- #invoice-print --}}

    <style>
        /* ── Screen: hide invoice ── */
        #invoice-print { display: none; }

        /* ── Print: hide page, show only invoice ── */
        @media print {
            /* Missing before — without an explicit @page rule the browser's
               own default print margins apply (larger/inconsistent across
               browsers), which combined with the invoice's own spacing below
               pushed the footer onto a 2nd A4 page. */
            @page { size: A4; margin: 10mm; }

            body > *:not(#invoice-print) { display: none !important; }
            #invoice-print               { display: block !important; }

            /* Invoice layout — spacing kept deliberately tight below so the
               whole receipt fits on one A4 page. */
            #invoice-print {
                font-family: 'Arial', sans-serif;
                font-size: 12px;
                color: #1a1a1a;
                padding: 0;
                width: 100%;
                box-sizing: border-box;
            }

            /* Header */
            .inv-header {
                display: flex;
                justify-content: space-between;
                align-items: flex-start;
                margin-bottom: 10px;
            }
            .inv-logo { height: 46px; object-fit: contain; }
            .inv-company-name { font-size: 15px; font-weight: 700; color: #0d3b66; }
            .inv-company-sub  { font-size: 10px; color: #555; margin-top: 1px; }
            .inv-meta-block   { text-align: right; }
            .inv-badge {
                display: inline-block;
                background: #0d3b66;
                color: #fff;
                font-size: 15px;
                font-weight: 700;
                letter-spacing: 3px;
                padding: 3px 12px;
                border-radius: 4px;
                margin-bottom: 5px;
            }
            .inv-meta-table td { padding: 1px 6px; font-size: 11px; }
            .inv-meta-table td:first-child { color: #666; }
            .inv-meta-table td:last-child  { text-align: right; }

            /* Divider */
            .inv-divider {
                border: none;
                border-top: 2px solid #0d3b66;
                margin: 8px 0;
            }

            /* Bill To */
            .inv-bill-section {
                display: flex;
                justify-content: space-between;
                margin-bottom: 10px;
            }
            .inv-section-title { font-size: 10px; text-transform: uppercase; color: #888; letter-spacing: 1px; margin-bottom: 3px; }
            .inv-bill-name     { font-size: 13px; font-weight: 700; color: #0d3b66; }
            .inv-bill-line     { font-size: 11px; color: #444; margin-top: 1px; }
            .inv-status-pill {
                display: inline-block;
                background: #e8f4fd;
                color: #0d3b66;
                padding: 2px 10px;
                border-radius: 12px;
                font-size: 11px;
                font-weight: 700;
            }

            /* Table */
            .inv-table { width: 100%; border-collapse: collapse; margin-bottom: 0; }
            .inv-th {
                background: #0d3b66;
                color: #fff;
                padding: 5px 8px;
                font-size: 11px;
                font-weight: 600;
                text-align: left;
            }
            .inv-td        { padding: 5px 8px; font-size: 11px; border-bottom: 1px solid #eee; }
            .inv-row-alt td { background: #f8fafc; }

            /* Totals */
            .inv-totals-wrap  { display: flex; justify-content: flex-end; margin-top: 6px; }
            .inv-totals-table { border-collapse: collapse; min-width: 220px; }
            .inv-total-label  { padding: 3px 10px; font-size: 12px; color: #555; }
            .inv-total-value  { padding: 3px 10px; font-size: 12px; text-align: right; font-weight: 600; }
            .inv-grand-row td {
                border-top: 2px solid #0d3b66;
                padding-top: 5px;
                font-size: 14px;
                font-weight: 700;
                color: #0d3b66;
            }

            /* Footer */
            .inv-footer {
                margin-top: 12px;
                text-align: center;
                border-top: 1px solid #ddd;
                padding-top: 8px;
                font-size: 11px;
                color: #444;
            }
            .inv-credit {
                margin-top: 8px;
                padding-top: 6px;
                border-top: 1px solid #e5e7eb;
                font-size: 10px;
                color: #777;
            }
            .inv-credit a {
                color: #0d6efd;
                font-weight: 600;
                text-decoration: none;
            }
        }
    </style>
@endsection