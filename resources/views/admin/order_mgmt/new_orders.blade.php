@extends('admin.layouts.app')

@section('title')
    New Orders
@endsection

@section('content')

    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6"><h1 class="m-0">New Orders</h1></div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard.index') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.orders.index') }}">Orders</a></li>
                        <li class="breadcrumb-item active">New Orders</li>
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

                        <div class="card-header bg-white border-bottom" style="padding:16px 20px;">
                            <h3 class="card-title font-weight-bold mb-0">
                                <i class="fas fa-bell mr-2 text-warning"></i> Pending New Orders
                            </h3>
                        </div>

                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-hover align-middle mb-0" id="newOrderTable">
                                    <thead class="thead-light">
                                        <tr>
                                            <th>Order No.</th>
                                            <th>Customer Name</th>
                                            <th>Customer Phone</th>
                                            <th>Total</th>
                                            <th>Payment Method</th>
                                            <th>Date</th>
                                            <th class="text-center nosort" style="width:130px;">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    @forelse ($orders as $order)
                                        <tr id="new-order-row-{{ $order['id'] }}">

                                            <td>
                                                <span class="font-weight-bold text-primary">{{ $order['order_number'] }}</span>
                                                <br><small class="text-muted">#{{ $order['id'] }}</small>
                                            </td>

                                            <td>
                                                @if(!empty($order['order_address']))
                                                    {{ trim(($order['order_address']['first_name'] ?? '') . ' ' . ($order['order_address']['last_name'] ?? '')) }}
                                                @else
                                                    <span class="text-muted">N/A</span>
                                                @endif
                                            </td>

                                            <td><small>{{ $order['order_address']['phone'] ?? 'N/A' }}</small></td>

                                            <td class="font-weight-bold">৳ {{ number_format($order['total_amount'], 2) }}</td>

                                            <td>
                                                @php
                                                    $pmColor = match($order['payment_method']) {
                                                        'BKASH'  => '#E2136E',
                                                        'NAGAD'  => '#F47B25',
                                                        'ROCKET' => '#8332AC',
                                                        'BANK'   => '#1565C0',
                                                        default  => '#6c757d',
                                                    };
                                                @endphp
                                                <span class="badge"
                                                    style="background:{{ $pmColor }};color:#fff;padding:4px 10px;">
                                                    {{ $order['payment_method'] }}
                                                </span>
                                            </td>

                                            <td>
                                                {{ \Carbon\Carbon::parse($order['created_at'])->format('d M Y') }}
                                                <br><small class="text-muted">{{ \Carbon\Carbon::parse($order['created_at'])->format('h:i A') }}</small>
                                            </td>

                                            <td class="text-center">
                                                <div class="d-flex align-items-center justify-content-center" style="gap:5px;">
                                                    <button type="button" class="action-btn new-view-btn"
                                                        data-id="{{ $order['id'] }}" title="View Summary">
                                                        <i class="fas fa-eye" style="color:cornflowerblue;"></i>
                                                    </button>
                                                    <button type="button" class="action-btn new-accept-btn"
                                                        data-id="{{ $order['id'] }}" title="Accept">
                                                        <i class="fas fa-check" style="color:darkgreen;"></i>
                                                    </button>
                                                    <button type="button" class="action-btn new-cancel-btn"
                                                        data-id="{{ $order['id'] }}" title="Cancel">
                                                        <i class="fas fa-times" style="color:maroon;"></i>
                                                    </button>
                                                </div>
                                            </td>

                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="7" class="text-center py-5 text-muted">
                                                <i class="fas fa-check-circle fa-3x mb-3 d-block" style="color:#48bb78;"></i>
                                                No pending orders at the moment.
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

    {{-- ORDER SUMMARY MODAL --}}
    <div class="modal fade" id="newOrderSummaryModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content border-0 shadow-lg">
                <div class="modal-header" style="background:linear-gradient(135deg,#1a73e8,#0d47a1);color:#fff;">
                    <h5 class="modal-title font-weight-bold">
                        <i class="fas fa-receipt mr-2"></i> Order Summary
                    </h5>
                    <button type="button" class="close text-white" data-dismiss="modal"><span>&times;</span></button>
                </div>
                <div class="modal-body p-0">
                    <div id="newSummaryContent" style="padding:24px;"></div>
                </div>
                <div class="modal-footer bg-light" id="newSummaryFooter"></div>
            </div>
        </div>
    </div>

@endsection

@push('css')
    <style>
    #newOrderTable td, #newOrderTable th { vertical-align: middle; }
    #newOrderTable thead th {
        font-size: 12px; font-weight: 700;
        text-transform: uppercase; letter-spacing:.5px;
        color:#555; border-top:none; padding:14px 12px;
    }
    #newOrderTable tbody td { padding:12px; }

    .action-btn {
        width:34px; height:34px; border-radius:8px;
        border:none; outline:none; background:#f8f9fa;
        display:inline-flex; align-items:center; justify-content:center;
        cursor:pointer; transition:all .2s;
        box-shadow:0 1px 3px rgba(0,0,0,.08);
    }
    .action-btn:hover { background:#e2e8f0; transform:translateY(-2px); }
    .action-btn:focus { outline:none; box-shadow:none; }
    .action-btn i { font-size:13px; }

    .payment-proof-img {
        max-width:100%; max-height:220px;
        border:1px solid #dee2e6; border-radius:6px;
        margin-top:8px; cursor:pointer; display:block;
    }

    .psb { font-size:10px; font-weight:700; padding:2px 8px; border-radius:20px; text-transform:uppercase; }
    .psb-paid     { background:#d4edda; color:#155724; }
    .psb-pending  { background:#fff3cd; color:#856404; }
    .psb-failed   { background:#f8d7da; color:#721c24; }
    .psb-refunded { background:#d1ecf1; color:#0c5460; }
    </style>
@endpush

@push('js')
    <script>
    $(document).ready(function () {

        var CSRF     = '{{ csrf_token() }}';
        var BASE_URL = '{{ url("admin/orders") }}';

        $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': CSRF, 'X-Requested-With': 'XMLHttpRequest' } });

        /* ── DataTable ── */
        var newDT = $('#newOrderTable').DataTable({
            columnDefs: [{ orderable: false, targets: [6] }],
            order: [[5, 'desc']],
            pageLength: 25,
            language: { emptyTable: 'No pending orders at the moment.' }
        });

        /* ── ACCEPT ── */
        $(document).on('click', '.new-accept-btn', function () {
            var id  = $(this).data('id');
            var btn = $(this);

            Swal.fire({
                title: 'Accept this order?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#38a169',
                cancelButtonColor: '#718096',
                confirmButtonText: 'Yes, Accept',
            }).then(function (r) {
                if (!r.isConfirmed) return;

                btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin" style="color:darkgreen;font-size:13px;"></i>');

                $.ajax({ url: BASE_URL + '/' + id + '/accept', type: 'POST', dataType: 'json', data: { _token: CSRF } })
                    .done(function (res) {
                        if (res.success) {
                            $('#newOrderSummaryModal').modal('hide');
                            newDT.row('#new-order-row-' + id).remove().draw(false);
                            Swal.fire({ icon:'success', title:'Accepted!', text:res.message, timer:1800, showConfirmButton:false });
                        } else {
                            Swal.fire('Error', res.message || 'Could not accept order.', 'error');
                        }
                    })
                    .fail(function (xhr) {
                        var errMsg = (xhr.responseJSON && (xhr.responseJSON.message || xhr.responseJSON.error)) || 'Failed to accept order.';
                        Swal.fire('Error', errMsg, 'error');
                    })
                    .always(function () {
                        btn.prop('disabled', false).html('<i class="fas fa-check" style="color:darkgreen;font-size:13px;"></i>');
                    });
            });
        });

        /* ── CANCEL ── */
        $(document).on('click', '.new-cancel-btn', function () {
            var id  = $(this).data('id');
            var btn = $(this);

            Swal.fire({
                title: 'Cancel this order?',
                text: 'This cannot be undone.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#e53e3e',
                cancelButtonColor: '#718096',
                confirmButtonText: 'Yes, Cancel',
                cancelButtonText: 'Go Back'
            }).then(function (r) {
                if (!r.isConfirmed) return;

                btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin" style="color:maroon;font-size:13px;"></i>');

                $.ajax({ url: BASE_URL + '/' + id + '/reject', type: 'POST', dataType: 'json', data: { _token: CSRF } })
                    .done(function (res) {
                        if (res.success) {
                            $('#newOrderSummaryModal').modal('hide');
                            newDT.row('#new-order-row-' + id).remove().draw(false);
                            Swal.fire({ icon:'info', title:'Cancelled', text:res.message, timer:1800, showConfirmButton:false });
                        } else {
                            Swal.fire('Error', res.message || 'Could not cancel order.', 'error');
                        }
                    })
                    .fail(function (xhr) {
                        var errMsg = (xhr.responseJSON && (xhr.responseJSON.message || xhr.responseJSON.error)) || 'Failed to cancel order.';
                        Swal.fire('Error', errMsg, 'error');
                    })
                    .always(function () {
                        btn.prop('disabled', false).html('<i class="fas fa-times" style="color:maroon;font-size:13px;"></i>');
                    });
            });
        });

        /* ── SUMMARY VIEW ── */
        $(document).on('click', '.new-view-btn', function () {
            var id = $(this).data('id');

            $('#newSummaryContent').html(
                '<div style="text-align:center;padding:40px;">' +
                '<div class="spinner-border text-primary"></div>' +
                '<p class="mt-3 text-muted">Loading...</p></div>'
            );
            $('#newSummaryFooter').html('');
            $('#newOrderSummaryModal').modal('show');

            $.get(BASE_URL + '/' + id).done(function (res) {
                if (!res.success) {
                    $('#newSummaryContent').html('<div class="alert alert-danger">Not found.</div>');
                    return;
                }

                var o    = res.order;
                var addr = o.order_address || {};
                var name = [addr.first_name, addr.last_name].filter(Boolean).join(' ') || 'N/A';
                var psCls = { PAID:'psb-paid', PENDING:'psb-pending', FAILED:'psb-failed', REFUNDED:'psb-refunded' }[o.payment_status] || '';
                var isOnline = (o.payment_method !== 'CASH');

                /* ── product rows ── */
                var rows = '', sub = 0;
                (o.order_items || []).forEach(function (item, i) {
                    var lt = parseFloat(item.line_total || 0); sub += lt;
                    rows += '<tr>' +
                        '<td>' + (i + 1) + '</td>' +
                        '<td>' + (item.product ? item.product.name : '—') + '</td>' +
                        '<td class="text-center">' + (item.qty_sets || item.quantity) + '</td>' +
                        '<td class="text-right">৳ ' + lt.toLocaleString('en-BD', { minimumFractionDigits: 2 }) + '</td>' +
                        '</tr>';
                });

                var ship  = parseFloat(o.shipping_amount || 0);
                var tax   = parseFloat(o.tax_amount || 0);
                var total = sub + ship + tax;

                /* ── payment proof block ── */
                var proofHtml = '';
                if (isOnline) {
                    proofHtml += '<div style="margin-top:10px;padding-top:10px;border-top:1px solid #e2e8f0;">';
                    proofHtml += '<div><i class="fas fa-mobile-alt mr-1 text-muted"></i>' +
                        '<strong>Payer Number:</strong> ' + (o.payer_number || '<span class="text-muted">N/A</span>') + '</div>';
                    proofHtml += '<div><strong>TXN Ref:</strong> <small class="text-muted">' + (o.transaction_id || 'N/A') + '</small></div>';
                    if (o.payment_screenshot) {
                        proofHtml += '<div class="mt-2"><strong>Screenshot:</strong><br>' +
                            '<a href="/storage/' + o.payment_screenshot + '" target="_blank">' +
                            '<img src="/storage/' + o.payment_screenshot + '" class="payment-proof-img" alt="Payment Screenshot">' +
                            '</a></div>';
                    }
                    proofHtml += '</div>';
                } else {
                    proofHtml = '<div class="text-muted mt-1"><i class="fas fa-truck mr-1"></i>Cash on Delivery</div>';
                }

                $('#newSummaryContent').html(
                    '<div class="row mb-4">' +
                      '<div class="col-6"><div class="p-3 rounded" style="background:#f7fafc;border:1px solid #e2e8f0;">' +
                        '<div class="font-weight-bold text-primary mb-2" style="font-size:12px;text-transform:uppercase;">Customer</div>' +
                        '<div class="font-weight-bold">' + name + '</div>' +
                        '<div class="text-muted">' + (addr.phone || '') + '</div>' +
                        '<div class="text-muted">' + (addr.address_line1 || '') + '</div>' +
                      '</div></div>' +
                      '<div class="col-6"><div class="p-3 rounded" style="background:#f7fafc;border:1px solid #e2e8f0;">' +
                        '<div class="font-weight-bold text-primary mb-2" style="font-size:12px;text-transform:uppercase;">Payment Info</div>' +
                        '<div><strong>Order:</strong> ' + o.order_number + '</div>' +
                        '<div><strong>Method:</strong> <span class="badge badge-light border">' + o.payment_method + '</span></div>' +
                        '<div><strong>Status:</strong> <span class="psb ' + psCls + '">' + o.payment_status + '</span></div>' +
                        proofHtml +
                      '</div></div>' +
                    '</div>' +
                    '<table class="table table-sm table-bordered mb-3">' +
                    '<thead class="thead-light"><tr>' +
                    '<th>#</th><th>Product</th><th class="text-center">Qty</th><th class="text-right">Total</th>' +
                    '</tr></thead>' +
                    '<tbody>' + rows + '</tbody>' +
                    '<tfoot>' +
                      '<tr><td colspan="3" class="text-right font-weight-bold">Subtotal</td>' +
                        '<td class="text-right">৳ ' + sub.toLocaleString('en-BD', { minimumFractionDigits: 2 }) + '</td></tr>' +
                      '<tr><td colspan="3" class="text-right">Shipping</td>' +
                        '<td class="text-right">৳ ' + ship.toLocaleString('en-BD', { minimumFractionDigits: 2 }) + '</td></tr>' +
                      '<tr><td colspan="3" class="text-right">Tax</td>' +
                        '<td class="text-right">৳ ' + tax.toLocaleString('en-BD', { minimumFractionDigits: 2 }) + '</td></tr>' +
                      '<tr style="background:#1a73e8;color:#fff;">' +
                        '<td colspan="3" class="text-right font-weight-bold" style="color:#fff;">NET PAYABLE</td>' +
                        '<td class="text-right font-weight-bold" style="color:#fff;">৳ ' + total.toLocaleString('en-BD', { minimumFractionDigits: 2 }) + '</td>' +
                      '</tr>' +
                    '</tfoot></table>'
                );

                $('#newSummaryFooter').html(
                    '<button class="btn btn-success new-accept-btn mr-2" data-id="' + o.id + '">' +
                        '<i class="fas fa-check mr-1"></i>Accept Order</button>' +
                    '<button class="btn btn-danger new-cancel-btn" data-id="' + o.id + '">' +
                        '<i class="fas fa-times mr-1"></i>Cancel Order</button>' +
                    '<button class="btn btn-secondary ml-auto" data-dismiss="modal">Close</button>'
                );
            }).fail(function () {
                $('#newSummaryContent').html('<div class="alert alert-danger">Failed to load order.</div>');
            });
        });

    });
    </script>
@endpush
