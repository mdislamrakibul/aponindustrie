@extends('admin.layouts.app')

@section('title', 'Order History')

@section('content')

    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Order History</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            <a href="{{ route('admin.dashboard.index') }}">Home</a>
                        </li>
                        <li class="breadcrumb-item active">Order History</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">

            {{-- ── FILTER SECTION ── --}}
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-body">
                    <form method="GET" action="{{ route('admin.accounts.order.history') }}">
                        <div class="row align-items-end g-3">

                            <div class="col-lg-2 col-md-4">
                                <label class="form-label fw-semibold">Filter By</label>
                                <select name="filter_type" class="form-select" onchange="toggleFilterInputs(this.value)">
                                    <option value="all" {{ $filterType == 'all' ? 'selected' : '' }}>All Time</option>
                                    <option value="day" {{ $filterType == 'day' ? 'selected' : '' }}>By Day</option>
                                    <option value="month" {{ $filterType == 'month' ? 'selected' : '' }}>By Month</option>
                                    <option value="year" {{ $filterType == 'year' ? 'selected' : '' }}>By Year</option>
                                </select>
                            </div>

                            <div class="col-lg-2 col-md-4" id="input-day"
                                style="{{ $filterType == 'day' ? '' : 'display:none;' }}">
                                <label class="form-label fw-semibold">Date</label>
                                <input type="date" name="date" class="form-control" value="{{ $date }}">
                            </div>

                            <div class="col-lg-2 col-md-4" id="input-month"
                                style="{{ $filterType == 'month' ? '' : 'display:none;' }}">
                                <label class="form-label fw-semibold">Month</label>
                                <select name="month" class="form-select">
                                    @foreach(range(1, 12) as $m)
                                        <option value="{{ $m }}" {{ $month == $m ? 'selected' : '' }}>
                                            {{ date('F', mktime(0, 0, 0, $m, 1)) }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-lg-2 col-md-4" id="input-year"
                                style="{{ in_array($filterType, ['month', 'year']) ? '' : 'display:none;' }}">
                                <label class="form-label fw-semibold">Year</label>
                                <select name="year" class="form-select">
                                    @foreach($years as $y)
                                        <option value="{{ $y }}" {{ $year == $y ? 'selected' : '' }}>
                                            {{ $y }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-lg-3 col-md-4">
                                <label class="form-label fw-semibold">By Product</label>
                                <select name="product_id" class="form-select">
                                    <option value="">All Products</option>
                                    @foreach($products as $product)
                                        <option value="{{ $product->id }}" {{ $productId == $product->id ? 'selected' : '' }}>
                                            {{ $product->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-auto ms-auto">
                                <label class="form-label d-block">&nbsp;</label>
                                <div class="d-flex justify-content-end gap-2">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-filter"></i>
                                    </button>
                                    <a href="{{ route('admin.accounts.order.history') }}" class="btn btn-secondary">
                                        <i class="fas fa-redo"></i>
                                    </a>
                                </div>
                            </div>

                        </div>
                    </form>
                </div>
            </div>

            {{-- ── SUMMARY CARDS ── --}}
            <div class="row mb-4">

                {{-- Total Sale --}}
                <div class="col-lg-3 col-md-6 mb-3">
                    <div style="display:flex;align-items:center;gap:16px;
                                background:linear-gradient(135deg,#1e40af,#2563eb);
                                border-radius:12px;padding:22px 20px;color:#fff;
                                box-shadow:0 4px 15px rgba(37,99,235,0.35);">
                        <div style="font-size:2.2rem;opacity:.85;">
                            <i class="fas fa-shopping-bag"></i>
                        </div>
                        <div>
                            <h3 style="margin:0;font-size:1.6rem;font-weight:700;">
                                ৳ {{ number_format($totalSale, 2) }}
                            </h3>
                            <p style="margin:0;font-size:.85rem;opacity:.9;">Total Sale</p>
                            <small style="opacity:.8;">{{ $deliveredCount }} delivered orders</small>
                        </div>
                    </div>
                </div>

                {{-- Cancelled --}}
                <div class="col-lg-3 col-md-6 mb-3">
                    <div style="display:flex;align-items:center;gap:16px;
                                background:linear-gradient(135deg,#7f1d1d,#dc2626);
                                border-radius:12px;padding:22px 20px;color:#fff;
                                box-shadow:0 4px 15px rgba(220,38,38,0.35);">
                        <div style="font-size:2.2rem;opacity:.85;">
                            <i class="fas fa-times-circle"></i>
                        </div>
                        <div>
                            <h3 style="margin:0;font-size:1.6rem;font-weight:700;">
                                {{ $cancelledCount }}
                            </h3>
                            <p style="margin:0;font-size:.85rem;opacity:.9;">Cancelled Orders</p>
                            <small style="opacity:.8;">{{ $totalOrders }} total orders</small>
                        </div>
                    </div>
                </div>

                {{-- Profit --}}
                <div class="col-lg-3 col-md-6 mb-3">
                    <div style="display:flex;align-items:center;gap:16px;
                                background:linear-gradient(135deg,#064e3b,#059669);
                                border-radius:12px;padding:22px 20px;color:#fff;
                                box-shadow:0 4px 15px rgba(5,150,105,0.35);">
                        <div style="font-size:2.2rem;opacity:.85;">
                            <i class="fas fa-chart-line"></i>
                        </div>
                        <div>
                            <h3 style="margin:0;font-size:1.6rem;font-weight:700;">
                                ৳ {{ number_format($profit, 2) }}
                            </h3>
                            <p style="margin:0;font-size:.85rem;opacity:.9;">Total Profit</p>
                            <small style="opacity:.8;">Sale price − Purchase price</small>
                        </div>
                    </div>
                </div>

                {{-- Loss --}}
                <div class="col-lg-3 col-md-6 mb-3">
                    <div style="display:flex;align-items:center;gap:16px;
                                background:linear-gradient(135deg,#78350f,#d97706);
                                border-radius:12px;padding:22px 20px;color:#fff;
                                box-shadow:0 4px 15px rgba(217,119,6,0.35);">
                        <div style="font-size:2.2rem;opacity:.85;">
                            <i class="fas fa-exclamation-triangle"></i>
                        </div>
                        <div>
                            <h3 style="margin:0;font-size:1.6rem;font-weight:700;">
                                ৳ {{ number_format($loss, 2) }}
                            </h3>
                            <p style="margin:0;font-size:.85rem;opacity:.9;">Total Loss</p>
                            <small style="opacity:.8;">Shipping cost of cancelled orders</small>
                        </div>
                    </div>
                </div>

            </div>

            {{-- ── ORDER TABLE ── --}}
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white border-bottom d-flex align-items-center">
                    <h3 class="card-title font-weight-bold mb-0">Order History</h3>
                    <span class="badge badge-success ml-3">
                        {{ $deliveredCount }} Delivered
                    </span>
                    <span class="badge badge-danger ml-2">
                        {{ $cancelledCount }} Cancelled
                    </span>
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle" id="dataTable">
                            <thead class="bg-light">
                                <tr>
                                    <th>Order ID</th>
                                    <th>Date</th>
                                    <th>Customer</th>
                                    <th class="text-center">Items</th>
                                    <th class="text-right">Amount</th>
                                    <th class="text-right">Profit</th>
                                    <th class="text-center">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($orders as $order)
                                    @php
                                        // Per-row profit calculation
                                        // quantity = total units; price = per-package price; purchase_price = per-package cost
                                        // packages sold = quantity / minimum_order
                                        $rowProfit = 0;
                                        if ($order->order_status === 'DELIVERED') {
                                            foreach ($order->order_items as $item) {
                                                $purchasePrice = $item->product->purchase_price ?? 0;
                                                $packagePrice  = $item->product->package_price ?? $item->price;
                                                $minOrder      = $item->product->minimum_order ?? 1;
                                                $packages      = $minOrder > 0 ? $item->quantity / $minOrder : $item->quantity;
                                                $rowProfit    += ($packagePrice - $purchasePrice) * $packages;
                                            }
                                        }

                                        // Per-row loss
                                        $rowLoss = $order->order_status === 'CANCELLED'
                                            ? $order->shipping_amount
                                            : 0;
                                    @endphp
                                    <tr>
                                        <td>
                                            <span class="font-weight-bold text-primary">
                                                #{{ $order->order_number }}
                                            </span>
                                        </td>

                                        <td>
                                            {{ \Carbon\Carbon::parse($order->created_at)->format('d M Y') }}
                                            <br>
                                            <small class="text-muted">
                                                {{ \Carbon\Carbon::parse($order->created_at)->format('h:i A') }}
                                            </small>
                                        </td>

                                        <td>
                                            @if($order->order_address)
                                                {{ $order->order_address->first_name }}
                                                {{ $order->order_address->last_name }}
                                                <br>
                                                <small class="text-muted">
                                                    {{ $order->order_address->phone ?? '' }}
                                                </small>
                                            @else
                                                <span class="text-muted">N/A</span>
                                            @endif
                                        </td>

                                        <td class="text-center">
                                            <span class="badge badge-info px-2 py-1">
                                                {{ $order->order_items->count() }} items
                                            </span>
                                        </td>

                                        <td class="text-right font-weight-bold">
                                            ৳ {{ number_format($order->total_amount, 2) }}
                                            @if($order->shipping_amount > 0)
                                                <br>
                                                <small class="text-muted">
                                                    +৳ {{ number_format($order->shipping_amount, 2) }} shipping
                                                </small>
                                            @endif
                                        </td>

                                        {{-- Profit / Loss column --}}
                                        <td class="text-right font-weight-bold">
                                            @if($order->order_status === 'DELIVERED')
                                                <span style="color:#059669;">
                                                    +৳ {{ number_format($rowProfit, 2) }}
                                                </span>
                                            @elseif($order->order_status === 'CANCELLED')
                                                <span style="color:#dc2626;">
                                                    -৳ {{ number_format($rowLoss, 2) }}
                                                </span>
                                            @else
                                                <span class="text-muted">—</span>
                                            @endif
                                        </td>

                                        <td class="text-center">
                                            <span
                                                class="badge px-2 py-1
                                                                        {{ $order->order_status == 'DELIVERED' ? 'badge-success' : '' }}
                                                                        {{ $order->order_status == 'PROCESSING' ? 'badge-warning' : '' }}
                                                                        {{ $order->order_status == 'SHIPPED' ? 'badge-info' : '' }}
                                                                        {{ $order->order_status == 'CANCELLED' ? 'badge-danger' : '' }}">
                                                {{ $order->order_status }}
                                            </span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center py-5 text-muted">
                                            <i class="fas fa-inbox fa-2x mb-2 d-block"></i>
                                            No orders found.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    {{-- Pagination --}}
                    @if($orders->hasPages())
                        <div class="d-flex justify-content-between align-items-center mt-3">
                            <small class="text-muted">
                                Showing {{ $orders->firstItem() }} to {{ $orders->lastItem() }}
                                of {{ $orders->total() }} orders
                            </small>
                            {{ $orders->appends(request()->query())->links('pagination::bootstrap-4') }}
                        </div>
                    @endif

                </div>
            </div>

        </div>
    </section>

@endsection

@push('scripts')
    <script>
        function toggleFilterInputs(value) {
            document.getElementById('input-day').style.display = 'none';
            document.getElementById('input-month').style.display = 'none';
            document.getElementById('input-year').style.display = 'none';

            if (value === 'day') {
                document.getElementById('input-day').style.display = '';
            }
            if (value === 'month') {
                document.getElementById('input-month').style.display = '';
                document.getElementById('input-year').style.display = '';
            }
            if (value === 'year') {
                document.getElementById('input-year').style.display = '';
            }
        }
    </script>
@endpush
