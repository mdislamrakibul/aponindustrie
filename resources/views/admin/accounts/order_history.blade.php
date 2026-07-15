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

            {{-- ── SALES REPORT ── --}}
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-body">
                    <div class="row align-items-end g-3">
                        <div class="col-lg-2 col-md-4">
                            <label class="form-label fw-semibold">Report Period</label>
                            <select id="reportPeriod" class="form-select">
                                <option value="daily">Daily</option>
                                <option value="weekly">Weekly</option>
                                <option value="monthly">Monthly</option>
                                <option value="yearly">Yearly</option>
                            </select>
                        </div>
                        <div class="col-lg-2 col-md-4">
                            <label class="form-label fw-semibold">Reference Date</label>
                            <input type="date" id="reportRefDate" class="form-control" value="{{ now()->toDateString() }}">
                        </div>
                        <div class="col-auto">
                            <label class="form-label d-block">&nbsp;</label>
                            <button type="button" id="downloadReportBtn" class="btn btn-success">
                                <i class="fas fa-file-download mr-1"></i> Download Report
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Hidden container the report HTML is built into before being handed to html2pdf --}}
            <div id="salesReportContent" style="display:none;"></div>

            {{-- ── SUMMARY CARDS ── --}}
            <div class="row mb-4 align-items-stretch">

                {{-- Total Sale --}}
                <div class="col-lg-3 col-md-6 mb-3 d-flex">
                    <div style="display:flex;align-items:center;gap:16px;width:100%;
                                background:linear-gradient(135deg,#1e40af,#2563eb);
                                border-radius:12px;padding:22px 20px;color:#fff;
                                box-shadow:0 4px 15px rgba(37,99,235,0.35);">
                        <div style="font-size:2.2rem;opacity:.85;flex-shrink:0;">
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
                <div class="col-lg-3 col-md-6 mb-3 d-flex">
                    <div style="display:flex;align-items:center;gap:16px;width:100%;
                                background:linear-gradient(135deg,#7f1d1d,#dc2626);
                                border-radius:12px;padding:22px 20px;color:#fff;
                                box-shadow:0 4px 15px rgba(220,38,38,0.35);">
                        <div style="font-size:2.2rem;opacity:.85;flex-shrink:0;">
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
                <div class="col-lg-3 col-md-6 mb-3 d-flex">
                    @php
                        $profitIsNegative = $totalProfit < 0;
                    @endphp
                    <div style="display:flex;align-items:center;gap:16px;width:100%;
                                background:{{ $profitIsNegative ? 'linear-gradient(135deg,#7f1d1d,#dc2626)' : 'linear-gradient(135deg,#064e3b,#059669)' }};
                                border-radius:12px;padding:22px 20px;color:#fff;
                                box-shadow:0 4px 15px {{ $profitIsNegative ? 'rgba(220,38,38,0.35)' : 'rgba(5,150,105,0.35)' }};">
                        <div style="font-size:2.2rem;opacity:.85;flex-shrink:0;">
                            <i class="fas {{ $profitIsNegative ? 'fa-arrow-trend-down' : 'fa-chart-line' }}"></i>
                        </div>
                        <div>
                            <h3 style="margin:0;font-size:1.6rem;font-weight:700;">
                                ৳ {{ number_format($totalProfit, 2) }}
                            </h3>
                            <p style="margin:0;font-size:.85rem;opacity:.9;">Total Profit</p>
                            <small style="opacity:.8;">Package price − Purchase price</small>
                        </div>
                    </div>
                </div>

                {{-- Loss --}}
                <div class="col-lg-3 col-md-6 mb-3 d-flex">
                    <div style="display:flex;align-items:center;gap:16px;width:100%;
                                background:linear-gradient(135deg,#78350f,#d97706);
                                border-radius:12px;padding:22px 20px;color:#fff;
                                box-shadow:0 4px 15px rgba(217,119,6,0.35);">
                        <div style="font-size:2.2rem;opacity:.85;flex-shrink:0;">
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
                        <table class="table table-hover align-middle">
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
                                        $rowProfit = $profitByOrder->get($order->id, 0);
                                        // Only counts as a loss if the order was accepted before being
                                        // cancelled — an order rejected straight from "New Orders" never
                                        // had a courier engaged, so no delivery charge was ever incurred.
                                        $rowLoss   = ($order->order_status === 'CANCELLED' && $order->accepted_by)
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
                                                @if($rowProfit < 0)
                                                    <span style="color:#dc2626;">
                                                        -৳ {{ number_format(abs($rowProfit), 2) }}
                                                    </span>
                                                @else
                                                    <span style="color:#059669;">
                                                        +৳ {{ number_format($rowProfit, 2) }}
                                                    </span>
                                                @endif
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

    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
    <script>
        (function () {
            var btn = document.getElementById('downloadReportBtn');
            if (!btn) return;

            btn.addEventListener('click', function () {
                var period  = document.getElementById('reportPeriod').value;
                var refDate = document.getElementById('reportRefDate').value;

                btn.disabled = true;
                var originalHtml = btn.innerHTML;
                btn.innerHTML = '<i class="fas fa-spinner fa-spin mr-1"></i> Generating...';

                fetch('{{ route('admin.accounts.sales.report') }}?period=' + encodeURIComponent(period) + '&ref_date=' + encodeURIComponent(refDate))
                    .then(function (res) { return res.json(); })
                    .then(function (data) {
                        if (!data.success) throw new Error('Report failed');
                        downloadReport(data);
                    })
                    .catch(function () {
                        alert('Could not generate the report. Please try again.');
                    })
                    .finally(function () {
                        btn.disabled = false;
                        btn.innerHTML = originalHtml;
                    });
            });

            function fmtMoney(n) {
                return '৳ ' + Number(n).toLocaleString('en-BD', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
            }

            function periodTitle(period) {
                return { daily: 'Daily', weekly: 'Weekly', monthly: 'Monthly', yearly: 'Yearly' }[period] + ' Sales Report';
            }

            function rowColumnLabel(period) {
                return period === 'daily' ? 'Order' : (period === 'weekly' ? 'Day' : (period === 'monthly' ? 'Week' : 'Month'));
            }

            function downloadReport(data) {
                var rowsHtml = data.rows.map(function (r) {
                    var profitColor = r.profit < 0 ? '#dc2626' : '#059669';
                    return '<tr>' +
                        '<td style="padding:5px 8px;border-bottom:1px solid #eee;word-wrap:break-word;">' + r.label + '</td>' +
                        '<td style="padding:5px 8px;border-bottom:1px solid #eee;text-align:center;">' + r.orders + '</td>' +
                        '<td style="padding:5px 8px;border-bottom:1px solid #eee;text-align:right;word-wrap:break-word;">' + fmtMoney(r.sales) + '</td>' +
                        '<td style="padding:5px 8px;border-bottom:1px solid #eee;text-align:right;word-wrap:break-word;color:' + profitColor + ';">' + fmtMoney(r.profit) + '</td>' +
                        '</tr>';
                }).join('');
                var totalProfitColor = data.totals.profit < 0 ? '#dc2626' : '#059669';

                var html =
                    // Right padding is deliberately larger than left: html2canvas
                    // reproducibly exports a canvas ~30px narrower than the
                    // element's real width (a known quirk, not fixed by
                    // scrollX/scrollY/windowWidth options), which was clipping
                    // the last few characters of the right-most column. This
                    // buffer keeps all real content clear of that clipped zone.
                    '<div style="font-family:Arial,sans-serif;font-size:12px;color:#1a1a1a;padding:10px 40px 10px 16px;box-sizing:border-box;overflow:hidden;">' +
                        '<div style="text-align:center;border-bottom:3px solid #0d3b66;padding-bottom:8px;margin-bottom:10px;">' +
                            '<div style="font-size:20px;font-weight:800;color:#0d3b66;">APON PLASTIC INDUSTRIES</div>' +
                            '<div style="font-size:11px;color:#555;margin-top:2px;">Office &amp; Factory: Rupshi, Rupganj, Narayanganj.</div>' +
                            '<div style="font-size:15px;font-weight:700;letter-spacing:2px;color:#444;margin-top:6px;">' + periodTitle(data.period).toUpperCase() + '</div>' +
                            '<div style="font-size:12px;color:#666;margin-top:2px;">' + data.range_label + '</div>' +
                        '</div>' +

                        '<table style="width:100%;table-layout:fixed;border-collapse:collapse;margin-bottom:12px;">' +
                            '<tr>' +
                                '<td style="width:20%;padding:8px;background:#f8f9fa;border:1px solid #dce0e4;text-align:center;word-wrap:break-word;">' +
                                    '<div style="font-size:15px;font-weight:700;color:#0d3b66;">' + data.totals.orders + '</div>' +
                                    '<div style="font-size:10px;color:#666;">Delivered Orders</div>' +
                                '</td>' +
                                '<td style="width:20%;padding:8px;background:#f8f9fa;border:1px solid #dce0e4;text-align:center;word-wrap:break-word;">' +
                                    '<div style="font-size:15px;font-weight:700;color:#0d3b66;">' + fmtMoney(data.totals.sales) + '</div>' +
                                    '<div style="font-size:10px;color:#666;">Total Sales</div>' +
                                '</td>' +
                                '<td style="width:20%;padding:8px;background:#f8f9fa;border:1px solid #dce0e4;text-align:center;word-wrap:break-word;">' +
                                    '<div style="font-size:15px;font-weight:700;color:' + totalProfitColor + ';">' + fmtMoney(data.totals.profit) + '</div>' +
                                    '<div style="font-size:10px;color:#666;">Total Profit</div>' +
                                '</td>' +
                                '<td style="width:20%;padding:8px;background:#f8f9fa;border:1px solid #dce0e4;text-align:center;word-wrap:break-word;">' +
                                    '<div style="font-size:15px;font-weight:700;color:#dc2626;">' + data.totals.cancelled + '</div>' +
                                    '<div style="font-size:10px;color:#666;">Cancelled Orders</div>' +
                                '</td>' +
                                '<td style="width:20%;padding:8px;background:#f8f9fa;border:1px solid #dce0e4;text-align:center;word-wrap:break-word;">' +
                                    '<div style="font-size:15px;font-weight:700;color:#d97706;">' + fmtMoney(data.totals.loss) + '</div>' +
                                    '<div style="font-size:10px;color:#666;">Total Loss</div>' +
                                '</td>' +
                            '</tr>' +
                        '</table>' +

                        '<table style="width:100%;table-layout:fixed;border-collapse:collapse;">' +
                            '<thead><tr style="background:#0d3b66;color:#fff;">' +
                                '<th style="width:40%;padding:6px 8px;text-align:left;font-size:11px;">' + rowColumnLabel(data.period) + '</th>' +
                                '<th style="width:15%;padding:6px 8px;text-align:center;font-size:11px;">Orders</th>' +
                                '<th style="width:22%;padding:6px 8px;text-align:right;font-size:11px;">Sales</th>' +
                                '<th style="width:23%;padding:6px 8px;text-align:right;font-size:11px;">Profit</th>' +
                            '</tr></thead>' +
                            '<tbody>' + (rowsHtml || '<tr><td colspan="4" style="padding:16px;text-align:center;color:#888;">No delivered orders in this period.</td></tr>') + '</tbody>' +
                        '</table>' +

                        '<div style="text-align:center;margin-top:14px;padding-top:8px;border-top:1px solid #e5e7eb;font-size:10px;color:#777;">' +
                            'Generated ' + new Date().toLocaleString('en-BD') +
                        '</div>' +
                    '</div>';

                var container = document.getElementById('salesReportContent');
                container.innerHTML = html;
                var el = container.firstElementChild;

                // Same single-page-fit safety net used for invoice downloads:
                // shrink font/padding a bit further if the report is still
                // too tall relative to its width for one A4 page.
                var backdrop = document.createElement('div');
                backdrop.style.cssText = 'position:absolute;top:0;left:0;width:100%;min-height:100vh;background:#fff;z-index:99998;';
                el.style.position = 'relative';
                el.style.width = '760px';
                backdrop.appendChild(el);
                document.body.appendChild(backdrop);

                var A4_SAFE_RATIO = (277 / 190) * 0.92;
                var fontPx = 12;
                while (el.scrollHeight > 760 * A4_SAFE_RATIO && fontPx > 8) {
                    fontPx -= 1;
                    el.style.fontSize = fontPx + 'px';
                }

                html2pdf().set({
                    margin: 8,
                    filename: periodTitle(data.period).replace(/\s+/g, '_') + '_' + data.range_label.replace(/[^\w]+/g, '_') + '.pdf',
                    image: { type: 'jpeg', quality: 0.98 },
                    html2canvas: { scale: 2, useCORS: true, scrollX: 0, scrollY: 0 },
                    jsPDF: { unit: 'mm', format: 'a4', orientation: 'portrait' },
                    pagebreak: { mode: ['avoid-all'] }
                }).from(el).save().then(function () {
                    if (backdrop.parentNode) backdrop.parentNode.removeChild(backdrop);
                    container.innerHTML = '';
                }).catch(function (err) {
                    if (backdrop.parentNode) backdrop.parentNode.removeChild(backdrop);
                    throw err;
                });
            }
        })();
    </script>
@endpush