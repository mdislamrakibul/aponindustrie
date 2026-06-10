@extends('admin.layouts.app')

@section('title')
    Order Mgmt
@endsection

<style>
    .invoice-wrapper {
        background: #fff;
        padding: 30px;
    }

    .invoice-top {
        border-bottom: 3px solid red;
    }

    .invoice-table thead th {
        background: blue !important;
        color: white !important;
    }
</style>
@section('content')


    <style>
        .action-btn-group {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 5px;
        }

        .icon-action-btn {
            width: 38px;
            height: 38px;
            border-radius: 10px;
            border: none !important;
            outline: none !important;

            background: #fff !important;
            color: #000 !important;

            display: inline-flex;
            align-items: center;
            justify-content: center;

            transition: all .2s ease;

            text-decoration: none !important;

            box-shadow: none !important;
        }

        .icon-action-btn i {
            font-size: 14px;
        }

        .icon-action-btn:hover {
            background: lightgrey !important;
            color: #fff !important;

            transform: translateY(-2px);
        }

        .icon-action-btn:focus {
            outline: none !important;
            box-shadow: none !important;
        }
    </style>



    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm border-0">

                {{-- Page Header --}}
                <div class="card-header bg-white border-bottom d-flex align-items-center">
                    <div class="flex-grow-1">
                        <h3 class="card-title font-weight-bold mb-0">
                            Order Management
                        </h3>
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
                                    <th>Transaction Id</th>
                                    <th>Created At</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach ($orders as $order)
                                    <tr>
                                        {{-- NAME --}}
                                        <td>
                                            <span class="">
                                                {{ $order['order_number'] }}
                                            </span>
                                        </td>

                                        {{-- MOBILE --}}
                                        <td>
                                            <span class="">
                                                {{ $order['total_amount'] }}
                                            </span>

                                        </td>


                                        <td>
                                            <span class="">
                                                {{ $order['payment_method'] }}
                                            </span>

                                        </td>

                                        <td>
                                            <span class="">
                                                {{ $order['payment_status'] }}
                                            </span>

                                        </td>

                                        <td>
                                            <span class="">
                                                {{ $order['order_status'] }}
                                            </span>

                                        </td>

                                        <td>
                                            <span class="">
                                                {{ $order['transaction_id'] }}
                                            </span>

                                        </td>

                                        <td>
                                            <span class="">
                                                {{ \Carbon\Carbon::parse($order['created_at'])->format('Y-m-d h:i A') }}
                                            </span>

                                        </td>

                                        <td>
                                            <div class="action-btn-group">
                                                <button type="button" class="icon-action-btn view-order-btn"
                                                    data-id="{{ $order['id'] }}" title="View Invoice">
                                                    <i class="fas fa-eye" style="color: cornflowerblue;"></i>
                                                </button>
                                                {{--
                                                <button type="button" class="icon-action-btn update-btn" title="Save">
                                                    <i class="fas fa-pen" style="color: blue;"></i>
                                                </button>

                                                <button type="submit" class="icon-action-btn" title="Delete User">
                                                    <i class="fas fa-trash" style="color: red"></i>
                                                </button>
                                                --}}

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

    <div class="modal fade" id="orderViewModal" tabindex="-1" aria-labelledby="orderModalLabel">

        <div class="modal-dialog modal-xl" style="max-width:1400px;">

            <div class="modal-content">

                <div class="modal-header">

                    <h5 class="modal-title" id="orderModalLabel">
                        Order Invoice
                    </h5>

                    <button type="button" class="close" data-dismiss="modal">

                        <span>&times;</span>

                    </button>

                </div>

                <div class="modal-body">

                    <div id="invoiceContent"></div>

                </div>

            </div>

        </div>

    </div>

@endsection
@push('css')

    <style>




    </style>

@endpush
@push('js')

    <script>

        $(document).ready(function () {

            $('.view-order-btn').click(function () {

                let orderId = $(this).data('id');

                $.ajax({

                    url: "{{ url('admin/orders') }}/" + orderId,

                    type: 'GET',

                    success: function (response) {


                        if (response.success) {

                            let order = response.order;

                            let rows = '';

                            let subtotal = 0;

                            order.order_items.forEach((item, index) => {

                                let lineTotal =
                                    parseFloat(item.price) *
                                    parseInt(item.quantity);

                                subtotal += lineTotal;

                                rows += `
            <tr style="background:${index % 2 === 0 ? '#fff' : '#f7f9fc'};">
                <td style="border:1px solid #dee2e6; padding:10px; text-align:center;">${index + 1}</td>
                <td style="border:1px solid #dee2e6; padding:10px;">${item.product?.name ?? '-'}</td>
                <td style="border:1px solid #dee2e6; padding:10px; text-align:center;">৳ ${parseFloat(item.price).toFixed(2)}</td>
                <td style="border:1px solid #dee2e6; padding:10px; text-align:center;">${item.quantity}</td>
                <td style="border:1px solid #dee2e6; padding:10px; text-align:right;">৳ ${lineTotal.toFixed(2)}</td>
            </tr>
            `;
                            });

                            $('#invoiceContent').html(`
                        <div style="background:#fff; color:#222; font-family:'Segoe UI',sans-serif; padding:30px; font-size:14px;">

                            <!-- Header -->
                            <div style="text-align:center; border-bottom:3px solid #0d6efd; padding-bottom:20px; margin-bottom:30px;">
                                <div style="font-size:18px; font-weight:600; color:#222; line-height:28px;">
                                    Government of the People's Republic of Bangladesh
                                </div>
                                <div style="font-size:18px; font-weight:600; color:#222; line-height:28px;">
                                    National Board of Revenue
                                </div>
                                <div style="font-size:34px; font-weight:800; color:#0d6efd; letter-spacing:1px; margin-top:10px;">
                                    APON PLASTIC INDUSTRIES
                                </div>
                                <div style="margin-top:6px; font-size:14px; line-height:26px;">Gazipur, Dhaka, Bangladesh</div>
                                <div style="font-size:14px; line-height:26px;">Phone : 017xxxxxxxx</div>
                                <div style="font-size:14px; line-height:26px;">Email : info@aponplastic.com</div>
                                <div style="font-size:14px; line-height:26px;">Website : www.aponplastic.com</div>
                                <div style="font-size:14px; line-height:26px;">BIN : 123456789</div>
                                <div style="margin-top:15px; font-size:22px; font-weight:700; letter-spacing:3px; color:#444;">
                                    RETAIL INVOICE
                                </div>
                            </div>

                            <!-- Customer & Invoice Info -->
                            <div class="row" style="margin-bottom:30px;">

                                <div class="col-md-6">
                                    <div style="background:#f3f4f6; border:1px solid #dce0e4; border-radius:12px; padding:18px; min-height:200px;">
                                        <div style="background:#0d6efd; color:#fff; padding:10px 14px; border-radius:4px; font-weight:700; margin-bottom:12px;">
                                            CUSTOMER INFORMATION
                                        </div>
                                        <p style="margin-bottom:8px;"><strong>Name :</strong> ${order.order_address.first_name} ${order.order_address.last_name}</p>
                                        <p style="margin-bottom:8px;"><strong>Phone :</strong> ${order.order_address.phone}</p>
                                        <p style="margin-bottom:8px;"><strong>Email :</strong> ${order.order_address.email}</p>
                                        <p style="margin-bottom:8px;"><strong>Address :</strong> ${order.order_address.address_line1}</p>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div style="background:#f3f4f6; border:1px solid #dce0e4; border-radius:12px; padding:18px; min-height:200px;">
                                        <div style="background:#0d6efd; color:#fff; padding:10px 14px; border-radius:4px; font-weight:700; margin-bottom:12px;">
                                            INVOICE INFORMATION
                                        </div>
                                        <p style="margin-bottom:8px;"><strong>Invoice No :</strong> ${order.order_number}</p>
                                        <p style="margin-bottom:8px;"><strong>Date :</strong> ${new Date(order.created_at).toLocaleString()}</p>
                                        <p style="margin-bottom:8px;"><strong>Transaction :</strong> ${order.transaction_id}</p>
                                        <p style="margin-bottom:8px;"><strong>Payment :</strong> ${order.payment_method}</p>
                                    </div>
                                </div>

                            </div>

                            <!-- Product Table -->
                            <table style="width:100%; border-collapse:collapse; margin-top:20px;">
                                <thead>
                                    <tr style="background:#0d6efd;">
                                        <th style="color:#fff; border:1px solid #0d6efd; padding:10px; text-align:center; width:6%;">SL</th>
                                        <th style="color:#fff; border:1px solid #0d6efd; padding:10px; text-align:left;">Product Description</th>
                                        <th style="color:#fff; border:1px solid #0d6efd; padding:10px; text-align:center; width:14%;">Unit Price</th>
                                        <th style="color:#fff; border:1px solid #0d6efd; padding:10px; text-align:center; width:8%;">Qty</th>
                                        <th style="color:#fff; border:1px solid #0d6efd; padding:10px; text-align:right; width:14%;">Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    ${rows}
                                </tbody>
                            </table>

                            <!-- Summary Table -->
                            <table style="width:100%; border-collapse:collapse; margin-top:20px;">
                                <tr>
                                    <td style="border:1px solid #dee2e6; padding:12px;">Sub Total</td>
                                    <td style="border:1px solid #dee2e6; padding:12px; text-align:right;">৳ ${order.total_amount}</td>
                                </tr>
                                <tr>
                                    <td style="border:1px solid #dee2e6; padding:12px;">Shipping</td>
                                    <td style="border:1px solid #dee2e6; padding:12px; text-align:right;">৳ ${order.shipping_amount}</td>
                                </tr>
                                <tr>
                                    <td style="border:1px solid #dee2e6; padding:12px;">VAT / TAX</td>
                                    <td style="border:1px solid #dee2e6; padding:12px; text-align:right;">৳ ${order.tax_amount}</td>
                                </tr>
                                <tr>
                                    <td style="background:#0d6efd; color:#fff; font-weight:700; padding:12px; font-size:16px; border:1px solid #0d6efd;">
                                        NET PAYABLE
                                    </td>
                                    <td style="background:#0d6efd; color:#fff; font-weight:700; padding:12px; text-align:right; font-size:16px; border:1px solid #0d6efd;">
                                        ৳ ${order.total_amount}
                                    </td>
                                </tr>
                            </table>

                            <!-- Footer -->
                            <div class="row" style="margin-top:30px;">

                                <div class="col-md-6">
                                    <p style="margin-bottom:8px;">
                                        <strong>Payment Status :</strong>
                                        <span style="background:#ffc107; color:#000; padding:4px 12px; border-radius:4px; font-size:12px; font-weight:600;">
                                            ${order.payment_status}
                                        </span>
                                    </p>
                                    <p>
                                        <strong>Order Status :</strong>
                                        <span style="background:#0d6efd; color:#fff; padding:4px 12px; border-radius:4px; font-size:12px; font-weight:600;">
                                            ${order.order_status}
                                        </span>
                                    </p>
                                </div>

                                <div class="col-md-6" style="text-align:center;">
                                    <div style="width:220px; margin:40px auto 10px; border-top:2px solid #000;"></div>
                                    <small>Authorized Signature</small>
                                </div>

                            </div>

                            <!-- Thank You -->
                            <div style="text-align:center; margin-top:30px; padding-top:20px; border-top:1px solid #ddd;">
                                <p style="font-size:18px; font-weight:600;">Thank You For Your Business</p>
                                <small style="color:#666;">Apon Plastic Industries</small>
                            </div>

                            <!-- Print Button -->
                            <div style="text-align:center; margin-top:20px;">
                                <button onclick="window.print()" class="btn btn-primary">Print Invoice</button>
                            </div>

                        </div>
                        `);

                            $('#orderViewModal').modal('show');

                        }

                    }

                });

            });

        });

    </script>

@endpush