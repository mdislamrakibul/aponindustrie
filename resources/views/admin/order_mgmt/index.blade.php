@extends('admin.layouts.app')

@section('title')
    Order Management
@endsection



@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Dashboard</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard.index') }}">Home</a></li>
                        <li class="breadcrumb-item active">Orders</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card shadow-sm border-0">

                        {{-- Page Header --}}
                        <div class="card-header bg-white border-bottom d-flex align-items-center">
                            <div class="flex-grow-1">
                                <h3 class="card-title font-weight-bold mb-0">Order Management</h3>
                            </div>
                        </div>

                        {{-- Page Body --}}
                        <div class="card-body border-bottom bg-light">
                            <div class="table-responsive">
                                <table class="table table-hover" id="dataTable">

                                    <thead class="bg-light">
                                        <tr>
                                            <th>Order Number</th>
                                            <th>Total Amount</th>
                                            <th>Payment Method</th>
                                            <th>Payment Status</th>
                                            <th>Order Status</th>
                                            <th>Transaction ID</th>
                                            <th>Created At</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        @foreach ($orders as $order)
                                            <tr>
                                                <td>{{ $order['order_number'] }}</td>

                                                <td>৳ {{ number_format($order['total_amount'], 2) }}</td>

                                                <td>{{ $order['payment_method'] }}</td>
                                                <td>{{ $order['payment_status'] }}</td>
                                                <td>{{ $order['order_status'] }}</td>
                                                <td>{{ $order['transaction_id'] }}</td>
                                                <td>{{ \Carbon\Carbon::parse($order['created_at'])->format('Y-m-d h:i A') }}</td>

                                                <td>
                                                    <div style="display:flex; align-items:center; justify-content:center; gap:5px;">
                                                        <button type="button" class="view-order-btn" data-id="{{ $order['id'] }}"
                                                            title="View Invoice" style="
                                                                                        width:38px;
                                                                                        height:38px;
                                                                                        border-radius:10px;
                                                                                        border:none;
                                                                                        outline:none;
                                                                                        background:#fff;
                                                                                        display:inline-flex;
                                                                                        align-items:center;
                                                                                        justify-content:center;
                                                                                        cursor:pointer;
                                                                                        transition:all .2s ease;
                                                                                        box-shadow: 0 1px 4px rgba(0,0,0,0.08);
                                                                                    "
                                                            onmouseover="this.style.background='#e2e6ea'; this.style.transform='translateY(-2px)';"
                                                            onmouseout="this.style.background='#fff'; this.style.transform='translateY(0)';">
                                                            <i class="fas fa-eye" style="color:cornflowerblue; font-size:14px;"></i>
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>

                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    {{-- ══ Invoice Modal ══ --}}
    <div class="modal fade" id="orderViewModal" tabindex="-1" aria-labelledby="orderModalLabel">
        <div class="modal-dialog modal-xl" style="max-width:1200px;">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title" id="orderModalLabel">Order Invoice</h5>
                    <button type="button" class="close" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                </div>

                <div class="modal-body p-0">
                    <div id="invoiceContent" style="padding:30px;"></div>
                </div>

            </div>
        </div>
    </div>

@endsection

@push('js')
    <script>
        $(document).ready(function () {

            /*
             * ─── FIX: Event Delegation ─────────────────────────────────────────────────
             * ─────────────────────────────────────────────────────────────────────────
             */
            $(document).on('click', '.view-order-btn', function () {

                let orderId = $(this).data('id');

                // Loading state 
                $('#invoiceContent').html(`
                                            <div style="text-align:center; padding:60px 0;">
                                                <div class="spinner-border text-primary" role="status"></div>
                                                <p class="mt-3 text-muted">Loading invoice...</p>
                                            </div>
                                        `);
                $('#orderViewModal').modal('show');

                $.ajax({
                    url: "{{ url('admin/orders') }}/" + orderId,
                    type: 'GET',
                    success: function (response) {

                        if (!response.success) {
                            $('#invoiceContent').html('<div class="alert alert-danger m-3">Order not found.</div>');
                            return;
                        }

                        let order = response.order;

                        /*
                         * ─── PRICE LOGIC (Frontend) ──────────────────────────────────────────

                         * ─────────────────────────────────────────────────────────────────────
                         */
                        let rows = '';
                        let subtotal = 0;

                        order.order_items.forEach((item, index) => {

                            let packagePrice = parseFloat(item.package_price || 0);
                            let qtySets = parseInt(item.qty_sets || 1);
                            let minOrder = parseInt(item.min_order || 1);
                            let lineTotal = parseFloat(item.line_total || 0);

                            subtotal += lineTotal;

                            let unitLabel = minOrder > 1
                                ? `৳ ${packagePrice.toLocaleString('en-BD', { minimumFractionDigits: 2 })} <small style="color:#888;font-size:11px;">/ ${minOrder} pcs</small>`
                                : `৳ ${packagePrice.toLocaleString('en-BD', { minimumFractionDigits: 2 })}`;

                            rows += `
                                                    <tr style="background:${index % 2 === 0 ? '#fff' : '#f7f9fc'};">
                                                        <td style="border:1px solid #dee2e6; padding:10px; text-align:center;">${index + 1}</td>
                                                        <td style="border:1px solid #dee2e6; padding:10px;">${item.product?.name ?? '-'}</td>
                                                        <td style="border:1px solid #dee2e6; padding:10px; text-align:center;">${unitLabel}</td>
                                                        <td style="border:1px solid #dee2e6; padding:10px; text-align:center;">${qtySets}</td>
                                                        <td style="border:1px solid #dee2e6; padding:10px; text-align:right;">৳ ${lineTotal.toLocaleString('en-BD', { minimumFractionDigits: 2 })}</td>
                                                    </tr>`;
                        });

                        let shippingAmt = parseFloat(order.shipping_amount || 0);
                        let taxAmt = parseFloat(order.tax_amount || 0);
                        let netPayable = subtotal + shippingAmt + taxAmt;

                        // Customer info — null safe
                        let custName = order.order_address
                            ? `${order.order_address.first_name ?? ''} ${order.order_address.last_name ?? ''}`.trim()
                            : 'N/A';
                        let custPhone = order.order_address?.phone ?? 'N/A';
                        let custEmail = order.order_address?.email ?? 'N/A';
                        let custAddress = order.order_address?.address_line1 ?? 'N/A';

                        let payBadgeColor = order.payment_status === 'PAID' ? '#28a745' : '#ffc107';
                        let payBadgeText = order.payment_status === 'PAID' ? '#fff' : '#000';
                        let orderBadgeColor = '#0d6efd';

                        $('#invoiceContent').html(`
                                                    <div style="background:#fff; color:#222; font-family:'Segoe UI',sans-serif; font-size:14px;">

                                                        <!-- ══ HEADER ══ -->
                                                        <div style="text-align:center; border-bottom:3px solid #0d6efd; padding-bottom:20px; margin-bottom:30px;">
                                                            <div style="font-size:15px; font-weight:600; color:#444; line-height:26px;">
                                                                Government of the People's Republic of Bangladesh<br>
                                                                National Board of Revenue
                                                            </div>
                                                            <div style="font-size:32px; font-weight:800; color:#0d6efd; letter-spacing:1px; margin-top:10px;">
                                                                APON PLASTIC INDUSTRIES
                                                            </div>
                                                            <div style="margin-top:6px; font-size:13px; line-height:24px; color:#555;">
                                                                Gazipur, Dhaka, Bangladesh<br>
                                                                Phone : 017xxxxxxxx &nbsp;|&nbsp; Email : info@aponplastic.com<br>
                                                                Website : www.aponplastic.com &nbsp;|&nbsp; BIN : 123456789
                                                            </div>
                                                            <div style="margin-top:14px; font-size:20px; font-weight:700; letter-spacing:3px; color:#444;">
                                                                RETAIL INVOICE
                                                            </div>
                                                        </div>

                                                        <!-- ══ CUSTOMER + INVOICE INFO ══ -->
                                                        <div class="row" style="margin-bottom:30px;">
                                                            <div class="col-md-6">
                                                                <div style="background:#f8f9fa; border:1px solid #dce0e4; border-radius:10px; padding:18px; min-height:180px;">
                                                                    <div style="background:#0d6efd; color:#fff; padding:8px 14px; border-radius:4px; font-weight:700; margin-bottom:12px; font-size:13px;">
                                                                        CUSTOMER INFORMATION
                                                                    </div>
                                                                    <p style="margin:0 0 7px;"><strong>Name :</strong> ${custName}</p>
                                                                    <p style="margin:0 0 7px;"><strong>Phone :</strong> ${custPhone}</p>
                                                                    <p style="margin:0 0 7px;"><strong>Email :</strong> ${custEmail}</p>
                                                                    <p style="margin:0;"><strong>Address :</strong> ${custAddress}</p>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div style="background:#f8f9fa; border:1px solid #dce0e4; border-radius:10px; padding:18px; min-height:180px;">
                                                                    <div style="background:#0d6efd; color:#fff; padding:8px 14px; border-radius:4px; font-weight:700; margin-bottom:12px; font-size:13px;">
                                                                        INVOICE INFORMATION
                                                                    </div>
                                                                    <p style="margin:0 0 7px;"><strong>Invoice No :</strong> ${order.order_number}</p>
                                                                    <p style="margin:0 0 7px;"><strong>Date :</strong> ${new Date(order.created_at).toLocaleString('en-BD')}</p>
                                                                    <p style="margin:0 0 7px;"><strong>Transaction :</strong> ${order.transaction_id}</p>
                                                                    <p style="margin:0;"><strong>Payment :</strong> ${order.payment_method}</p>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <!-- ══ PRODUCT TABLE ══ -->
                                                        <table style="width:100%; border-collapse:collapse; margin-top:10px;">
                                                            <thead>
                                                                <tr style="background:#0d6efd;">
                                                                    <th style="color:#fff; border:1px solid #0d6efd; padding:10px; text-align:center; width:5%;">SL</th>
                                                                    <th style="color:#fff; border:1px solid #0d6efd; padding:10px; text-align:left;">Product Description</th>
                                                                    <th style="color:#fff; border:1px solid #0d6efd; padding:10px; text-align:center; width:18%;">Unit Price</th>
                                                                    <th style="color:#fff; border:1px solid #0d6efd; padding:10px; text-align:center; width:8%;">Qty<br><small style="font-weight:400;font-size:10px;">(Sets)</small></th>
                                                                    <th style="color:#fff; border:1px solid #0d6efd; padding:10px; text-align:right; width:14%;">Total</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                ${rows}
                                                            </tbody>
                                                        </table>

                                                        <!-- ══ SUMMARY TABLE ══ -->
                                                        <table style="width:50%; border-collapse:collapse; margin-top:20px; margin-left:auto;">
                                                            <tr>
                                                                <td style="border:1px solid #dee2e6; padding:10px; background:#f8f9fa;">Sub Total</td>
                                                                <td style="border:1px solid #dee2e6; padding:10px; text-align:right;">৳ ${subtotal.toLocaleString('en-BD', { minimumFractionDigits: 2 })}</td>
                                                            </tr>
                                                            <tr>
                                                                <td style="border:1px solid #dee2e6; padding:10px; background:#f8f9fa;">Shipping</td>
                                                                <td style="border:1px solid #dee2e6; padding:10px; text-align:right;">৳ ${shippingAmt.toLocaleString('en-BD', { minimumFractionDigits: 2 })}</td>
                                                            </tr>
                                                            <tr>
                                                                <td style="border:1px solid #dee2e6; padding:10px; background:#f8f9fa;">VAT / TAX</td>
                                                                <td style="border:1px solid #dee2e6; padding:10px; text-align:right;">৳ ${taxAmt.toLocaleString('en-BD', { minimumFractionDigits: 2 })}</td>
                                                            </tr>
                                                            <tr>
                                                                <td style="background:#0d6efd; color:#fff; font-weight:700; padding:12px; font-size:15px; border:1px solid #0d6efd;">NET PAYABLE</td>
                                                                <td style="background:#0d6efd; color:#fff; font-weight:700; padding:12px; text-align:right; font-size:15px; border:1px solid #0d6efd;">
                                                                    ৳ ${netPayable.toLocaleString('en-BD', { minimumFractionDigits: 2 })}
                                                                </td>
                                                            </tr>
                                                        </table>

                                                        <!-- ══ FOOTER ══ -->
                                                        <div class="row" style="margin-top:30px;">
                                                            <div class="col-md-6">
                                                                <p style="margin-bottom:8px;">
                                                                    <strong>Payment Status :</strong>
                                                                    <span style="background:${payBadgeColor}; color:${payBadgeText}; padding:3px 12px; border-radius:4px; font-size:12px; font-weight:600;">
                                                                        ${order.payment_status}
                                                                    </span>
                                                                </p>
                                                                <p>
                                                                    <strong>Order Status :</strong>
                                                                    <span style="background:${orderBadgeColor}; color:#fff; padding:3px 12px; border-radius:4px; font-size:12px; font-weight:600;">
                                                                        ${order.order_status}
                                                                    </span>
                                                                </p>
                                                            </div>
                                                            <div class="col-md-6" style="text-align:center;">
                                                                <div style="width:200px; margin:40px auto 8px; border-top:2px solid #000;"></div>
                                                                <small style="color:#555;">Authorized Signature</small>
                                                            </div>
                                                        </div>

                                                        <!-- Thank You -->
                                                        <div style="text-align:center; margin-top:30px; padding-top:20px; border-top:1px solid #ddd;">
                                                            <p style="font-size:17px; font-weight:600; margin-bottom:4px;">Thank You For Your Business</p>
                                                            <small style="color:#888;">Apon Plastic Industries</small>
                                                        </div>

                                                        <!-- Print Button -->
                                                        <div style="text-align:center; margin-top:20px;">
                                                            <button onclick="window.print()" class="btn btn-primary px-4">
                                                                <i class="fas fa-print mr-2"></i> Print Invoice
                                                            </button>
                                                        </div>

                                                    </div>
                                                `);
                    },

                    error: function (xhr) {
                        $('#invoiceContent').html(`
                                                    <div class="alert alert-danger m-3">
                                                        Failed to load invoice. 
                                                        ${xhr.status === 403 ? 'Permission denied.' : 'Please try again.'}
                                                        <br><small class="text-muted">Error ${xhr.status}</small>
                                                    </div>
                                                `);
                    }
                });
            });

        });
    </script>
@endpush