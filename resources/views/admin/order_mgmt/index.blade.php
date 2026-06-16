@extends('admin.layouts.app')

@push('css')
<style>
    @media (max-width: 576px) {
        .filter-btn {
            flex: 1 1 auto;
            justify-content: center;
        }

        .filter-bar>a.btn {
            margin-left: 0 !important;
            margin-top: 4px;
            width: 100%;
            text-align: center;
        }
    }
</style>
@endpush

@section('title')
Order Management
@endsection

@section('content')

<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Orders</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard.index') }}">Home</a></li>
                    <li class="breadcrumb-item active">Orders</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card shadow-sm border-0">

                    <div class="card-header bg-white border-bottom d-flex align-items-center"
                        style="padding:16px 20px;">
                        <h3 class="card-title font-weight-bold mb-0">
                            <i class="fas fa-shopping-cart mr-2 text-primary"></i> Order Management
                        </h3>
                    </div>



                    <div class="card-body">

                        {{-- ── Filter Bar ── --}}
                        @php
                        $allCount = count($orders);
                        $activeCount = collect($orders)->filter(fn($o) => !in_array($o['order_status'],
                        ['DELIVERED','CANCELLED']))->count();
                        $completeCount = collect($orders)->filter(fn($o) => $o['order_status'] === 'DELIVERED' &&
                        $o['payment_status'] === 'PAID')->count();
                        $cancelledCount = collect($orders)->filter(fn($o) => $o['order_status'] ===
                        'CANCELLED')->count();
                        @endphp
                        <div class="filter-bar">
                            <button type="button" class="btn btn-sm btn-outline-info filter-btn active-filter"
                                data-filter="all">
                                All <span class="badge badge-info filter-count">{{ $allCount }}</span>
                            </button>

                            <button type="button" class="btn btn-sm btn-outline-success filter-btn"
                                data-filter="complete">
                                Complete <span class="badge badge-success filter-count">{{ $completeCount }}</span>
                            </button>
                            <button type="button" class="btn btn-sm btn-outline-primary filter-btn"
                                data-filter="active">
                                Active <span class="badge badge-primary filter-count">{{ $activeCount }}</span>
                            </button>
                            <button type="button" class="btn btn-sm btn-outline-danger filter-btn"
                                data-filter="cancelled">
                                Cancelled <span class="badge badge-danger filter-count">{{ $cancelledCount }}</span>
                            </button>
                            <a href="{{ route('admin.orders.new.page') }}" class="btn btn-sm btn-outline-warning"
                                style="margin-left:auto;">
                                <i class="fas fa-plus mr-1"></i> New Orders
                            </a>
                        </div>


                        <div class="table-responsive">
                            {{-- NOTE: id must be orderTable, NOT dataTable
                            because layout.app.blade.php already calls
                            $('#dataTable').DataTable() globally. --}}
                            <table class="table table-hover align-middle mb-0" id="orderTable">
                                <thead class="thead-light">
                                    <tr>
                                        <th>Order No.</th>
                                        <th>Customer</th>
                                        <th>Total</th>
                                        <th>Payment Method</th>
                                        <th>Date</th>
                                        <th>Order Status</th>
                                        <th>Payment Status</th>
                                        <th class="text-center nosort" style="width:130px;">Actions</th>
                                    </tr>
                                </thead>
                                <tbody id="orderTableBody">
                                    @forelse ($orders as $order)
                                    @php $isLocked = $order['order_status'] === 'DELIVERED' && $order['payment_status']
                                    === 'PAID'; @endphp
                                    <tr id="order-row-{{ $order['id'] }}" data-os="{{ $order['order_status'] }}"
                                        data-ps="{{ $order['payment_status'] }}"
                                        class="{{ $isLocked ? 'row-locked' : '' }}">

                                        {{-- Order Number --}}
                                        <td>
                                            <span class="font-weight-bold text-primary">{{ $order['order_number']
                                                }}</span>
                                            <br><small class="text-muted">#{{ $order['id'] }}</small>
                                        </td>

                                        {{-- Customer --}}
                                        <td>
                                            @if(!empty($order['order_address']))
                                            <span>{{ trim(($order['order_address']['first_name'] ?? '') . ' ' .
                                                ($order['order_address']['last_name'] ?? '')) }}</span>
                                            <br><small class="text-muted">{{ $order['order_address']['phone'] ?? ''
                                                }}</small>
                                            @else
                                            <span class="text-muted">N/A</span>
                                            @endif
                                        </td>

                                        {{-- Total --}}
                                        <td class="font-weight-bold">৳ {{ number_format($order['total_amount'], 2) }}
                                        </td>

                                        {{-- Payment Method --}}
                                        <td><span class="badge badge-light border">{{ $order['payment_method'] }}</span>
                                        </td>

                                        {{-- Date --}}
                                        <td>
                                            {{ \Carbon\Carbon::parse($order['created_at'])->format('d M Y') }}
                                            <br><small class="text-muted">{{
                                                \Carbon\Carbon::parse($order['created_at'])->format('h:i A') }}</small>
                                        </td>

                                        {{-- Order Status --}}
                                        <td>
                                            <span class="view-mode order-status-badge-{{ $order['id'] }}">
                                                @php $osBadge = match ($order['order_status']) {
                                                'PROCESSING' => 'badge-warning', 'SHIPPED' => 'badge-info',
                                                'DELIVERED' => 'badge-success', 'CANCELLED' => 'badge-danger',
                                                default => 'badge-secondary'
                                                }; @endphp
                                                <span class="badge {{ $osBadge }} px-3 py-2">{{ $order['order_status']
                                                    }}</span>
                                            </span>
                                            <select
                                                class="form-control form-control-sm edit-mode d-none order-status-select"
                                                id="order-status-{{ $order['id'] }}" style="min-width:130px;">
                                                <option value="PROCESSING" {{ $order['order_status']=='PROCESSING'
                                                    ? 'selected' : '' }}>Processing</option>
                                                <option value="SHIPPED" {{ $order['order_status']=='SHIPPED'
                                                    ? 'selected' : '' }}>Shipped</option>
                                                <option value="DELIVERED" {{ $order['order_status']=='DELIVERED'
                                                    ? 'selected' : '' }}>Delivered</option>
                                                <option value="CANCELLED" {{ $order['order_status']=='CANCELLED'
                                                    ? 'selected' : '' }}>Cancelled</option>
                                            </select>
                                        </td>

                                        {{-- Payment Status --}}
                                        <td>
                                            <span class="view-mode payment-status-badge-{{ $order['id'] }}">
                                                @php $psBadge = match ($order['payment_status']) {
                                                'PAID' => 'badge-success', 'PENDING' => 'badge-warning',
                                                'FAILED' => 'badge-danger', 'REFUNDED' => 'badge-info',
                                                default => 'badge-secondary'
                                                }; @endphp
                                                <span class="badge {{ $psBadge }} px-3 py-2">{{ $order['payment_status']
                                                    }}</span>
                                            </span>
                                            <select
                                                class="form-control form-control-sm edit-mode d-none payment-status-select"
                                                id="payment-status-{{ $order['id'] }}" style="min-width:120px;">
                                                <option value="PENDING" {{ $order['payment_status']=='PENDING'
                                                    ? 'selected' : '' }}>Pending</option>
                                                <option value="PAID" {{ $order['payment_status']=='PAID' ? 'selected'
                                                    : '' }}>Paid</option>
                                                <option value="FAILED" {{ $order['payment_status']=='FAILED'
                                                    ? 'selected' : '' }}>Failed</option>
                                                <option value="REFUNDED" {{ $order['payment_status']=='REFUNDED'
                                                    ? 'selected' : '' }}>Refunded</option>
                                            </select>
                                        </td>

                                        {{-- Actions --}}
                                        <td class="text-center">
                                            <div class="d-flex align-items-center justify-content-center"
                                                style="gap:5px;">
                                                <button type="button" class="action-btn view-order-btn"
                                                    data-id="{{ $order['id'] }}" title="View Invoice">
                                                    <i class="fas fa-eye" style="color:cornflowerblue;"></i>
                                                </button>
                                                @if($isLocked)
                                                <button type="button" class="action-btn" title="Order complete — locked"
                                                    disabled style="cursor:default;opacity:.55;">
                                                    <i class="fas fa-lock" style="color:#6c757d;"></i>
                                                </button>
                                                @else
                                                <button type="button" class="action-btn order-edit-btn"
                                                    data-id="{{ $order['id'] }}" title="Edit Status">
                                                    <i class="fas fa-pen" style="color:#e67e22;"></i>
                                                </button>
                                                <button type="button" class="action-btn order-save-btn d-none"
                                                    data-id="{{ $order['id'] }}" title="Save">
                                                    <i class="fas fa-check" style="color:darkgreen;"></i>
                                                </button>
                                                <button type="button" class="action-btn order-discard-btn d-none"
                                                    data-id="{{ $order['id'] }}" title="Discard">
                                                    <i class="fas fa-times" style="color:maroon;"></i>
                                                </button>
                                                @endif
                                            </div>
                                        </td>

                                    </tr>
                                    @empty
                                    <tr id="empty-orders-row">
                                        <td colspan="8" class="text-center py-5 text-muted">
                                            <i class="fas fa-inbox fa-3x mb-3 d-block" style="color:#dee2e6;"></i>
                                            No accepted orders yet. Go to
                                            <a href="{{ route('admin.orders.new.page') }}">New Orders</a> to accept
                                            pending orders.
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</section>

{{-- INVOICE MODAL --}}
<div class="modal fade" id="orderViewModal" tabindex="-1">
    <div class="modal-dialog modal-xl" style="max-width:1200px;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Order Invoice</h5>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
            </div>
            <div class="modal-body p-0">
                <div id="invoiceContent" style="padding:30px;"></div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('css')
<style>
    /* ─── TABLE ── */
    #orderTable td,
    #orderTable th {
        vertical-align: middle;
    }

    #orderTable thead th {
        font-size: 12px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: .5px;
        color: #555;
        border-top: none;
        padding: 14px 12px;
    }

    #orderTable tbody td {
        padding: 12px;
    }

    /* ─── LOCKED ROW ── */
    tr.row-locked {
        background: #f6fff9 !important;
    }

    tr.row-locked td {
        color: #555;
    }

    /* ─── ACTION BUTTONS ── */
    .action-btn {
        width: 34px;
        height: 34px;
        border-radius: 8px;
        border: none;
        outline: none;
        background: #f8f9fa;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all .2s;
        box-shadow: 0 1px 3px rgba(0, 0, 0, .08);
    }

    .action-btn:hover {
        background: #e2e8f0;
        transform: translateY(-2px);
    }

    .action-btn:focus {
        outline: none;
        box-shadow: none;
    }

    .action-btn i {
        font-size: 13px;
    }

    /* ─── FILTER BAR ── */
    .filter-bar {
        padding: 14px 20px;
        background: #f8f9fa;
        border-bottom: 1px solid #e8ecf0;
        display: flex;
        align-items: flex-end;
        gap: 10px;
        flex-wrap: wrap;
    }

    .filter-btn {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 7px 16px;
        border-radius: 20px;
        border: 1.5px solid #dee2e6;
        background: #fff;
        color: #555;
        font-size: 12px;
        font-weight: 600;
        cursor: pointer;
        transition: all .18s;
        white-space: nowrap;
        box-shadow: 0 1px 2px rgba(0, 0, 0, .06);
    }

    .filter-btn:hover {
        border-color: #0d6efd;
        color: #0d6efd;
        box-shadow: 0 2px 5px rgba(13, 110, 253, .15);
    }

    .filter-btn.active-filter {
        background: #0d6efd;
        border-color: #0d6efd;
        color: #fff;
        box-shadow: 0 3px 8px rgba(13, 110, 253, .35);
    }

    .filter-btn.active-filter:hover {
        background: #0b5ed7;
    }

    .filter-btn[data-filter="cancelled"].active-filter {
        background: #dc3545;
        border-color: #dc3545;
        box-shadow: 0 3px 8px rgba(220, 53, 69, .35);
    }

    .filter-btn[data-filter="cancelled"].active-filter:hover {
        background: #c82333;
        border-color: #c82333;
    }

    .filter-btn[data-filter="cancelled"]:hover {
        border-color: #dc3545;
        color: #dc3545;
    }

    .filter-count {
        background: rgba(0, 0, 0, .1);
        border-radius: 10px;
        padding: 1px 7px;
        font-size: 11px;
        font-weight: 700;
        min-width: 20px;
        text-align: center;
    }

    .filter-btn.active-filter .filter-count {
        background: rgba(255, 255, 255, .3);
    }

    /* ─── PAYMENT PROOF ── */
    .payment-proof-img {
        max-width: 100%;
        max-height: 200px;
        border: 1px solid #dee2e6;
        border-radius: 6px;
        margin-top: 8px;
        cursor: pointer;
        display: block;
    }

    /* ─── PRINT: fallback for Ctrl+P on the modal page ── */
    @media print {
        body * {
            visibility: hidden !important;
        }

        #invoiceContent,
        #invoiceContent * {
            visibility: visible !important;
        }

        #invoiceContent {
            position: absolute;
            left: 0;
            top: 0;
            width: 100%;
            padding: 0 !important;
            margin: 0 !important;
            box-shadow: none !important;
        }

        .no-print,
        .modal-header,
        .modal-footer {
            display: none !important;
        }

        .modal,
        .modal-dialog,
        .modal-content {
            position: static !important;
            border: 0 !important;
            box-shadow: none !important;
        }

        * {
            -webkit-print-color-adjust: exact !important;
            print-color-adjust: exact !important;
        }
    }
</style>
@endpush

@push('js')
<script>
    $(document).ready(function () {

        const CSRF     = '{{ csrf_token() }}';
        const BASE_URL = '{{ url("admin/orders") }}';

        $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': CSRF, 'X-Requested-With': 'XMLHttpRequest' } });

        /* ════════════════════════════════════════════════════════
           📊 FILTER LOGIC — registered BEFORE DataTable init
        ════════════════════════════════════════════════════════ */
        var currentFilter = 'all';

        $.fn.dataTable.ext.search.push(function (settings, data, dataIndex) {
            if (settings.nTable.id !== 'orderTable') return true;
            if (currentFilter === 'all') return true;
            var node = orderDT.row(dataIndex).node();
            var os   = $(node).data('os');
            var ps   = $(node).data('ps');
            if (currentFilter === 'complete')   return os === 'DELIVERED' && ps === 'PAID';
            if (currentFilter === 'active')     return os !== 'DELIVERED' && os !== 'CANCELLED';
            if (currentFilter === 'cancelled')  return os === 'CANCELLED';
            return true;
        });

        /* ── DataTable ── */
        var orderDT = $('#orderTable').DataTable({
            columnDefs: [{ orderable: false, targets: [5, 6, 7] }],
            order: [[4, 'desc']],
            pageLength: 10,
            language: { emptyTable: 'No accepted orders yet.' }
        });

        /* ── Filter pill buttons ── */
        $(document).on('click', '.filter-btn', function () {
            currentFilter = $(this).data('filter');
            $('.filter-btn').removeClass('active-filter');
            $(this).addClass('active-filter');
            orderDT.draw();
        });

        /* ════════════════════════════════════════════════════════
           ✏️ EDIT / SAVE / DISCARD — Main Table
        ════════════════════════════════════════════════════════ */

        /* EDIT */
        $(document).on('click', '.order-edit-btn', function () {
            var id  = $(this).data('id');
            var row = $('#order-row-' + id);
            row.data('orig-os', row.find('.order-status-select').val());
            row.data('orig-ps', row.find('.payment-status-select').val());
            row.find('.view-mode').addClass('d-none');
            row.find('.edit-mode').removeClass('d-none');
            row.find('.order-edit-btn, .view-order-btn').addClass('d-none');
            row.find('.order-save-btn, .order-discard-btn').removeClass('d-none');
        });

        /* DISCARD */
        $(document).on('click', '.order-discard-btn', function () {
            var id  = $(this).data('id');
            var row = $('#order-row-' + id);
            row.find('.order-status-select').val(row.data('orig-os'));
            row.find('.payment-status-select').val(row.data('orig-ps'));
            row.find('.view-mode').removeClass('d-none');
            row.find('.edit-mode').addClass('d-none');
            row.find('.order-edit-btn, .view-order-btn').removeClass('d-none');
            row.find('.order-save-btn, .order-discard-btn').addClass('d-none');
        });

        /* SAVE */
        $(document).on('click', '.order-save-btn', function () {
            var id      = $(this).data('id');
            var row     = $('#order-row-' + id);
            var saveBtn = $(this);
            var os      = row.find('.order-status-select').val();
            var ps      = row.find('.payment-status-select').val();

            if (!os || !ps) {
                Swal.fire('Error', 'Could not read status values — please refresh the page.', 'error');
                return;
            }

            saveBtn.prop('disabled', true)
                   .html('<i class="fas fa-spinner fa-spin" style="color:darkgreen;font-size:13px;"></i>');

            $.ajax({
                url:      BASE_URL + '/' + id + '/update-status',
                type:     'POST',
                dataType: 'json',
                data:     { _token: CSRF, _method: 'PATCH', order_status: os, payment_status: ps }
            })
            .done(function (res) {
                try {
                    if (!res.success) { Swal.fire('Error', 'Update failed.', 'error'); return; }

                    var osBadge = { PROCESSING:'badge-warning', SHIPPED:'badge-info', DELIVERED:'badge-success', CANCELLED:'badge-danger' };
                    var psBadge = { PAID:'badge-success', PENDING:'badge-warning', FAILED:'badge-danger', REFUNDED:'badge-info' };

                    row.find('.order-status-badge-'   + id).html('<span class="badge ' + (osBadge[res.order_status]  || 'badge-secondary') + ' px-3 py-2">' + res.order_status  + '</span>');
                    row.find('.payment-status-badge-' + id).html('<span class="badge ' + (psBadge[res.payment_status] || 'badge-secondary') + ' px-3 py-2">' + res.payment_status + '</span>');

                    row.attr('data-os', res.order_status).data('os', res.order_status);
                    row.attr('data-ps', res.payment_status).data('ps', res.payment_status);

                    var isNowLocked = res.order_status === 'DELIVERED' && res.payment_status === 'PAID';

                    if (isNowLocked) {
                        row.addClass('row-locked');
                        row.find('.view-mode').removeClass('d-none');
                        row.find('.edit-mode').addClass('d-none');
                        /* hide save/discard, replace only edit with lock icon — saveBtn stays in DOM for .always() */
                        row.find('.order-save-btn, .order-discard-btn').addClass('d-none');
                        row.find('.order-edit-btn').replaceWith(
                            '<button type="button" class="action-btn" title="Order complete — locked" disabled style="cursor:default;opacity:.55;">' +
                            '<i class="fas fa-lock" style="color:#6c757d;"></i></button>'
                        );
                        row.find('.view-order-btn').removeClass('d-none');
                        Swal.fire({
                            icon: 'success',
                            title: 'Order Complete!',
                            html: '<span style="color:#28a745;font-weight:600;">DELIVERED & PAID</span> — this order is now locked.',
                            timer: 2200,
                            showConfirmButton: false
                        });
                    } else {
                        row.find('.view-mode').removeClass('d-none');
                        row.find('.edit-mode').addClass('d-none');
                        row.find('.order-edit-btn, .view-order-btn').removeClass('d-none');
                        row.find('.order-save-btn, .order-discard-btn').addClass('d-none');
                        Swal.fire({ icon:'success', title:'Saved!', text:'Order status updated.', timer:1500, showConfirmButton:false });
                    }
                } catch (e) {
                    Swal.fire('Error', 'Unexpected error while updating UI.', 'error');
                }
            })
            .fail(function (xhr) {
                try {
                    var msg = 'Failed to update. (HTTP ' + xhr.status + ')';
                    if (xhr.responseJSON) {
                        if (xhr.responseJSON.errors) {
                            /* .flat() is ES2019 — use concat for compatibility */
                            var lines = [];
                            $.each(xhr.responseJSON.errors, function(k, v) {
                                lines.push($.isArray(v) ? v[0] : v);
                            });
                            msg = lines.join('\n');
                        } else if (xhr.responseJSON.message) {
                            msg = xhr.responseJSON.message;
                        }
                    }
                    Swal.fire('Update Failed', msg, 'error');
                } catch (e) {
                    Swal.fire('Update Failed', 'HTTP ' + xhr.status, 'error');
                }
            })
            .always(function () {
                /* guaranteed to run even if .done() throws — restores the save button */
                saveBtn.prop('disabled', false)
                       .html('<i class="fas fa-check" style="color:darkgreen;font-size:13px;"></i>');
            });
        });

        /* ════════════════════════════════════════════════════════
           🧾 INVOICE MODAL — Main Table
        ════════════════════════════════════════════════════════ */
        $(document).on('click', '.view-order-btn', function () {
            var id = $(this).data('id');
            $('#invoiceContent').html(
                '<div style="text-align:center;padding:60px 0;">' +
                '<div class="spinner-border text-primary" role="status"></div>' +
                '<p class="mt-3 text-muted">Loading invoice...</p></div>'
            );
            $('#orderViewModal').modal('show');

            $.get(BASE_URL + '/' + id).done(function (res) {
                if (!res.success) { $('#invoiceContent').html('<div class="alert alert-danger m-3">Order not found.</div>'); return; }

                var o = res.order, rows = '', sub = 0, totalDiscount = 0;
                o.order_items.forEach(function (item, i) {
                    var pp = parseFloat(item.package_price || 0);
                    var qs = parseInt(item.qty_sets || 1);
                    var mo = parseInt(item.min_order || 1);
                    var lt = parseFloat(item.line_total || 0); sub += lt;
                    var ppp = mo > 0 ? pp / mo : pp;
                    var da = parseFloat(item.discount_amount || 0);
                    totalDiscount += da * qs;
                    rows += '<tr style="background:' + (i%2===0?'#fff':'#f7f9fc') + ';">' +
                        '<td style="border:1px solid #dee2e6;padding:10px;text-align:center;">' + (i+1) + '</td>' +
                        '<td style="border:1px solid #dee2e6;padding:10px;">' + (item.product ? item.product.name : '-') + '</td>' +
                        '<td style="border:1px solid #dee2e6;padding:10px;text-align:center;">' + mo + '</td>' +
                        '<td style="border:1px solid #dee2e6;padding:10px;text-align:right;">৳ ' + ppp.toLocaleString('en-BD',{minimumFractionDigits:2}) + '</td>' +
                        '<td style="border:1px solid #dee2e6;padding:10px;text-align:right;">' + (da > 0 ? '− ৳ ' + da.toLocaleString('en-BD',{minimumFractionDigits:2}) : '৳ 0.00') + '</td>' +
                        '<td style="border:1px solid #dee2e6;padding:10px;text-align:right;">৳ ' + pp.toLocaleString('en-BD',{minimumFractionDigits:2}) + '</td>' +
                        '<td style="border:1px solid #dee2e6;padding:10px;text-align:center;">' + qs + '</td>' +
                        '<td style="border:1px solid #dee2e6;padding:10px;text-align:right;">৳ ' + lt.toLocaleString('en-BD',{minimumFractionDigits:2}) + '</td>' +
                        '</tr>';
                });

                var ship = parseFloat(o.shipping_amount||0);
                var tax  = parseFloat(o.tax_amount||0);
                var net  = sub - totalDiscount + ship + tax;
                var addr = o.order_address || {};
                var cn   = [addr.first_name,addr.last_name].filter(Boolean).join(' ') || 'N/A';
                var pbg  = o.payment_status === 'PAID' ? '#28a745' : '#ffc107';
                var ptx  = o.payment_status === 'PAID' ? '#fff'    : '#000';

                $('#invoiceContent').html(
                    '<div style="background:#fff;color:#222;font-family:\'Segoe UI\',sans-serif;font-size:14px;">' +
                    '<div style="text-align:center;border-bottom:3px solid #0d6efd;padding-bottom:20px;margin-bottom:30px;">' +
                      '<div style="font-size:15px;font-weight:600;color:#444;line-height:26px;">Government of the People\'s Republic of Bangladesh<br>National Board of Revenue</div>' +
                      '<div style="font-size:32px;font-weight:800;color:#0d6efd;letter-spacing:1px;margin-top:10px;">APON PLASTIC INDUSTRIES</div>' +
                      '<div style="margin-top:6px;font-size:13px;line-height:24px;color:#555;">Gazipur, Dhaka, Bangladesh<br>Phone: 017xxxxxxxx &nbsp;|&nbsp; Email: info@aponplastic.com</div>' +
                      '<div style="margin-top:14px;font-size:20px;font-weight:700;letter-spacing:3px;color:#444;">RETAIL INVOICE</div>' +
                    '</div>' +
                    '<div class="row" style="margin-bottom:30px;">' +
                      '<div class="col-md-6"><div style="background:#f8f9fa;border:1px solid #dce0e4;border-radius:10px;padding:18px;">' +
                        '<div style="background:#0d6efd;color:#fff;padding:8px 14px;border-radius:4px;font-weight:700;margin-bottom:12px;font-size:13px;">CUSTOMER INFORMATION</div>' +
                        '<p style="margin:0 0 7px;"><strong>Name:</strong> ' + cn + '</p>' +
                        '<p style="margin:0 0 7px;"><strong>Phone:</strong> ' + (addr.phone||'N/A') + '</p>' +
                        '<p style="margin:0 0 7px;"><strong>Email:</strong> ' + (addr.email||'N/A') + '</p>' +
                        '<p style="margin:0;"><strong>Address:</strong> ' + (addr.address_line1||'N/A') + '</p>' +
                      '</div></div>' +
                      '<div class="col-md-6"><div style="background:#f8f9fa;border:1px solid #dce0e4;border-radius:10px;padding:18px;">' +
                        '<div style="background:#0d6efd;color:#fff;padding:8px 14px;border-radius:4px;font-weight:700;margin-bottom:12px;font-size:13px;">INVOICE INFORMATION</div>' +
                        '<p style="margin:0 0 7px;"><strong>Order ID:</strong> ' + o.order_number + '</p>' +
                        '<p style="margin:0 0 7px;"><strong>Accepted By:</strong> ' + (o.accepted_by_name || 'N/A') + '</p>' +
                        '<p style="margin:0 0 7px;"><strong>Date:</strong> ' + new Date(o.created_at).toLocaleString('en-BD') + '</p>' +
                        '<p style="margin:0 0 7px;"><strong>Transaction:</strong> ' + (o.transaction_id||'N/A') + '</p>' +
                        '<p style="margin:0 0 7px;"><strong>Payment:</strong> ' + o.payment_method + '</p>' +
                        (o.payment_method !== 'CASH'
                            ? '<p style="margin:0 0 7px;"><strong>Payer No:</strong> ' + (o.payer_number || 'N/A') + '</p>'
                            : '') +
                        '<p style="margin:0;"><strong>Payment Status:</strong> <span style="background:' + pbg + ';color:' + ptx + ';padding:3px 12px;border-radius:4px;font-size:12px;font-weight:600;">' + o.payment_status + '</span></p>' +
                      '</div></div>' +
                    '</div>' +
                    '<table style="width:100%;border-collapse:collapse;margin-top:10px;">' +
                    '<thead><tr style="background:#0d6efd;">' +
                      '<th style="color:#fff;border:1px solid #0d6efd;padding:10px;text-align:center;width:4%;">SL</th>' +
                      '<th style="color:#fff;border:1px solid #0d6efd;padding:10px;text-align:left;">Product</th>' +
                      '<th style="color:#fff;border:1px solid #0d6efd;padding:10px;text-align:center;width:10%;">Min Qty/Per</th>' +
                      '<th style="color:#fff;border:1px solid #0d6efd;padding:10px;text-align:right;width:12%;">Per Piece Price</th>' +
                      '<th style="color:#fff;border:1px solid #0d6efd;padding:10px;text-align:right;width:11%;">Discount (−)</th>' +
                      '<th style="color:#fff;border:1px solid #0d6efd;padding:10px;text-align:right;width:12%;">Package Price</th>' +
                      '<th style="color:#fff;border:1px solid #0d6efd;padding:10px;text-align:center;width:7%;">Qty</th>' +
                      '<th style="color:#fff;border:1px solid #0d6efd;padding:10px;text-align:right;width:12%;">Total</th>' +
                    '</tr></thead><tbody>' + rows + '</tbody></table>' +
                    '<table style="width:50%;border-collapse:collapse;margin-top:20px;margin-left:auto;">' +
                      '<tr><td style="border:1px solid #dee2e6;padding:10px;background:#f8f9fa;">Sub Total</td><td style="border:1px solid #dee2e6;padding:10px;text-align:right;">৳ ' + sub.toLocaleString('en-BD',{minimumFractionDigits:2}) + '</td></tr>' +
                      '<tr><td style="border:1px solid #dee2e6;padding:10px;background:#f8f9fa;">Discount (−)</td><td style="border:1px solid #dee2e6;padding:10px;text-align:right;' + (totalDiscount > 0 ? 'color:#dc3545;font-weight:600;' : '') + '">' + (totalDiscount > 0 ? '− ৳ ' + totalDiscount.toLocaleString('en-BD',{minimumFractionDigits:2}) : '৳ 0.00') + '</td></tr>' +
                      '<tr><td style="border:1px solid #dee2e6;padding:10px;background:#f8f9fa;">Shipping</td><td style="border:1px solid #dee2e6;padding:10px;text-align:right;">৳ ' + ship.toLocaleString('en-BD',{minimumFractionDigits:2}) + '</td></tr>' +
                      '<tr><td style="border:1px solid #dee2e6;padding:10px;background:#f8f9fa;">VAT</td><td style="border:1px solid #dee2e6;padding:10px;text-align:right;">৳ ' + tax.toLocaleString('en-BD',{minimumFractionDigits:2}) + '</td></tr>' +
                      '<tr><td style="background:#0d6efd;color:#fff;font-weight:700;padding:12px;font-size:15px;border:1px solid #0d6efd;">NET PAYABLE</td><td style="background:#0d6efd;color:#fff;font-weight:700;padding:12px;text-align:right;font-size:15px;border:1px solid #0d6efd;">৳ ' + net.toLocaleString('en-BD',{minimumFractionDigits:2}) + '</td></tr>' +
                    '</table>' +
                    '<div class="row" style="margin-top:50px;">' +
                      '<div class="col-md-6" style="text-align:center;">' +
                        '<div style="width:200px;margin:40px auto 8px;border-top:2px solid #000;"></div>' +
                        '<small style="color:#555;">Customer Signature</small>' +
                      '</div>' +
                      '<div class="col-md-6" style="text-align:center;">' +
                        '<div style="width:200px;margin:40px auto 8px;border-top:2px solid #000;"></div>' +
                        '<small style="color:#555;">Authorized Signature</small>' +
                      '</div>' +
                    '</div>' +
                    '<div style="text-align:center;margin-top:30px;padding-top:14px;border-top:1px solid #e5e7eb;font-size:12px;color:#777;">' +
                      'Design, Developed &amp; Managed by ' +
                      '<a href="https://versedsoft.com/" target="_blank" rel="noopener" style="color:#0d6efd;font-weight:600;text-decoration:none;">' +
                      'Versedsoft &mdash; Your Complication, Our Solutions</a>' +
                    '</div>' +
                    '<div style="text-align:center;margin-top:20px;">' +
                      '<button onclick="printInvoice()" class="btn btn-primary px-4 no-print"><i class="fas fa-print mr-2"></i> Print Invoice</button>' +
                    '</div></div>'
                );
            }).fail(function (xhr) {
                $('#invoiceContent').html('<div class="alert alert-danger m-3">Error ' + xhr.status + '. Failed to load.</div>');
            });
        });

    });

    function printInvoice() {
        var invoice = document.getElementById('invoiceContent');
        if (!invoice) return;

        var clone = invoice.cloneNode(true);
        clone.querySelectorAll('.no-print').forEach(function (el) { el.remove(); });

        var headStyles = '';
        document.querySelectorAll('link[rel="stylesheet"], style').forEach(function (node) {
            headStyles += node.outerHTML;
        });

        var printCss =
            '<style>' +
                '@media print { @page { margin: 12mm; } }' +
                '* { -webkit-print-color-adjust: exact !important; print-color-adjust: exact !important; }' +
                'body { margin: 0; padding: 20px; background: #fff; }' +
                '.no-print { display: none !important; }' +
            '</style>';

        var w = window.open('', 'PRINT', 'width=900,height=700');
        w.document.open();
        w.document.write(
            '<!DOCTYPE html><html><head><meta charset="utf-8"><title>Invoice</title>' +
            headStyles + printCss +
            '</head><body>' + clone.outerHTML + '</body></html>'
        );
        w.document.close();

        var printFired = false;
        w.onload = function () {
            if (printFired) return;
            printFired = true;
            setTimeout(function () { w.focus(); w.print(); w.close(); }, 300);
        };
        setTimeout(function () {
            if (printFired) return;
            printFired = true;
            try { w.focus(); w.print(); } catch (e) {}
        }, 700);
    }
</script>
@endpush
