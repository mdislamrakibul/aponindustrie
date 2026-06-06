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
        .invoice-wrapper {
            background: #fff;
            color: #222;
            font-family: 'Segoe UI', sans-serif;
            padding: 30px;
            font-size: 14px;
        }

        .invoice-top {
            text-align: center;
            border-bottom: 2px solid #ddd;
            padding-bottom: 15px;
            margin-bottom: 25px;
        }

        .invoice-top .gov {
            font-size: 16px;
            font-weight: 600;
        }

        .invoice-top .nbr {
            font-size: 16px;
            font-weight: 600;
        }

        .company-name {
            font-size: 34px;
            font-weight: 800;
            color: #0d6efd !important;
            letter-spacing: 1px;
            margin-top: 10px;
        }

        .govt-title {
            font-size: 18px;
            font-weight: 600;
            color: #222;
            line-height: 28px;
        }

        .company-info {
            margin-top: 10px;
            line-height: 26px;
            font-size: 14px;
        }

        .invoice-title {
            margin-top: 15px;
            font-size: 22px;
            font-weight: 700;
            letter-spacing: 3px;
            color: #444;

        }

        .invoice-top-section {
            margin-top: 30px;
            margin-bottom: 30px;
        }

        .section-title {
            display: block !important;
            background: #0d6efd !important;
            color: #fff !important;
            padding: 12px 15px !important;
            border-radius: 4px !important;
        }

        .invoice-section-title {
            font-weight: 700;
            text-transform: uppercase;
            font-size: 14px;
            margin-bottom: 10px;
            color: #111;
        }

        .customer-box {

            background:
                rgba(243,
                    244,
                    246,
                    .78) !important;

            border:
                1px solid rgba(220,
                    223,
                    228,
                    .9);

            border-radius:
                14px;

            padding:
                18px;

            min-height:
                220px;

            box-shadow:
                0 2px 10px rgba(0, 0, 0, .05);

        }


        .customer-box:hover {

            background:
                rgba(238,
                    240,
                    243,
                    .88) !important;

            transition:
                .25s ease;

        }


        .invoice-box {

            min-height: 160px;

        }

        .invoice-meta {
            margin-top: 30px;
            margin-bottom: 25px;
        }

        .invoice-meta p {
            margin-bottom: 10px;
        }

        .invoice-table {
            margin-top: 20px;
        }

        .invoice-table thead tr {
            background: #0d6efd !important;
        }

        .invoice-table thead th {
            background: #0d6efd !important;
            color: #fff !important;
            border: 1px solid #0d6efd !important;
            font-weight: 700;
        }

        .invoice-table th {
            text-align: center;
            vertical-align: middle;
        }

        .invoice-table td {
            vertical-align: middle;
        }

        .invoice-table tbody tr:nth-child(even) {
            background: #f7f9fc;
        }

        .summary-table {
            width: 100%;
            margin-top: 20px;
            border-collapse: collapse;
        }

        .summary-table td {
            border: 1px solid #dee2e6;
            padding: 12px;
        }

        .summary-table tr:last-child td {
            background: #0d6efd !important;
            color: #fff !important;
            font-weight: 700;
        }

        .invoice-header {
            text-align: center;
            border-bottom: 3px solid #0d6efd !important;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }

        .summary-label {
            font-weight: 600;
        }

        .net-payable {
            background: #f8f9fa;
            font-size: 18px;
            font-weight: 700;
        }

        .invoice-footer {
            margin-top: 40px;
        }

        .status-box {
            margin-top: 10px;
        }

        .status-badge {
            padding: 5px 12px;
            border-radius: 4px;
            font-size: 12px;
            font-weight: 600;
        }

        .payment-badge {
            background: #ffc107 !important;
            color: #000 !important;
        }

        .order-badge {
            background: #0d6efd !important;
            color: #fff !important;
        }

        .badge-payment {
            background: #ffc107;
            color: #000;
            padding: 4px 10px;
            font-weight: 600;
        }

        .badge-order {
            background: #0d6efd;
            color: #fff;
            padding: 4px 10px;
            font-weight: 600;
        }

        .signature-box {
            text-align: center;
            margin-top: 40px;
        }

        .signature-line {
            width: 220px;
            margin: 40px auto 10px;
            border-top: 2px solid #000;
        }

        .thankyou {
            text-align: center;
            margin-top: 30px;
            font-size: 18px;
            font-weight: 600;
        }

        .company-footer {
            text-align: center;
            margin-top: 10px;
            color: #666;
        }

        .print-btn {
            text-align: center;
            margin-top: 20px;
        }

        @media print {

            body * {
                visibility: hidden;
            }

            #invoiceContent,
            #invoiceContent * {
                visibility: visible;
            }

            #invoiceContent {
                position: absolute;
                left: 0;
                top: 0;
                width: 100%;
            }

            .print-btn {
                display: none;
            }



        }
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
                                                                                                                                                                                                    <tr>
                                                                                                                                                                                                        <td class="text-center">
                                                                                                                                                                                                            ${index + 1}
                                                                                                                                                                                                        </td>

                                                                                                                                                                                                        <td>
                                                                                                                                                                                                            ${item.product?.name ?? '-'}
                                                                                                                                                                                                        </td>

                                                                                                                                                                                                        <td class="text-center">
                                                                                                                                                                                                            ৳ ${parseFloat(item.price).toFixed(2)}
                                                                                                                                                                                                        </td>

                                                                                                                                                                                                        <td class="text-center">
                                                                                                                                                                                                            ${item.quantity}
                                                                                                                                                                                                        </td>

                                                                                                                                                                                                        <td class="text-right">
                                                                                                                                                                                                            ৳ ${lineTotal.toFixed(2)}
                                                                                                                                                                                                        </td>
                                                                                                                                                                                                    </tr>
                                                                                                                                                                                                `;
                            });

                            $('#invoiceContent').html(`

                                                                                                                                                                                <div class="invoice-wrapper">

                                                                                                                                                                                    <!-- Header -->

                                                                                                                                                                                    <div class="invoice-header text-center">

                                                                                                                                                                                        <div class="govt-title">
                                                                                                                                                                                            Government of the People's Republic of Bangladesh
                                                                                                                                                                                        </div>

                                                                                                                                                                                        <div class="govt-title">
                                                                                                                                                                                            National Board of Revenue
                                                                                                                                                                                        </div>

                                                                                                                                                                                        <div class="company-name">
                                                                                                                                                                                            APON PLASTIC INDUSTRIES
                                                                                                                                                                                        </div>

                                                                                                                                                                                        <div class="company-info">
                                                                                                                                                                                            Gazipur, Dhaka, Bangladesh
                                                                                                                                                                                        </div>

                                                                                                                                                                                        <div class="company-info">
                                                                                                                                                                                            Phone : 017xxxxxxxx
                                                                                                                                                                                        </div>

                                                                                                                                                                                        <div class="company-info">
                                                                                                                                                                                            Email : info@aponplastic.com
                                                                                                                                                                                        </div>

                                                                                                                                                                                        <div class="company-info">
                                                                                                                                                                                            Website : www.aponplastic.com
                                                                                                                                                                                        </div>

                                                                                                                                                                                        <div class="company-info">
                                                                                                                                                                                            BIN : 123456789
                                                                                                                                                                                        </div>

                                                                                                                                                                                        <div class="invoice-title">
                                                                                                                                                                                            RETAIL INVOICE
                                                                                                                                                                                        </div>

                                                                                                                                                                                    </div>


                                                                                                                                                                                    <!-- Customer & Invoice -->

                                                                                                                                                                                    <div class="row invoice-top-section">

                                                                                                                                                                                        <div class="col-md-6 customer-box">

                                                                                                                                                                                            <h6 class="section-title">
                                                                                                                                                                                                CUSTOMER INFORMATION
                                                                                                                                                                                            </h6>

                                                                                                                                                                                            <p>
                                                                                                                                                                                                <strong>Name :</strong>
                                                                                                                                                                                                ${order.order_address.first_name}
                                                                                                                                                                                                ${order.order_address.last_name}
                                                                                                                                                                                            </p>

                                                                                                                                                                                            <p>
                                                                                                                                                                                                <strong>Phone :</strong>
                                                                                                                                                                                                ${order.order_address.phone}
                                                                                                                                                                                            </p>

                                                                                                                                                                                            <p>
                                                                                                                                                                                                <strong>Email :</strong>
                                                                                                                                                                                                ${order.order_address.email}
                                                                                                                                                                                            </p>

                                                                                                                                                                                            <p>
                                                                                                                                                                                                <strong>Address :</strong>
                                                                                                                                                                                                ${order.order_address.address_line1}
                                                                                                                                                                                            </p>


                                                                                                                                                                                        </div>

                                                                                                                                                                                        <div class="col-md-6">

                                                                                                                                                                                            <h6 class="section-title">
                                                                                                                                                                                                INVOICE INFORMATION
                                                                                                                                                                                            </h6>

                                                                                                                                                                                            <p>
                                                                                                                                                                                                <strong>Invoice No :</strong>
                                                                                                                                                                                                ${order.order_number}
                                                                                                                                                                                            </p>

                                                                                                                                                                                            <p>
                                                                                                                                                                                                <strong>Date :</strong>
                                                                                                                                                                                                ${new Date(order.created_at).toLocaleString()}
                                                                                                                                                                                            </p>

                                                                                                                                                                                            <p>
                                                                                                                                                                                                <strong>Transaction :</strong>
                                                                                                                                                                                                ${order.transaction_id}
                                                                                                                                                                                            </p>

                                                                                                                                                                                            <p>
                                                                                                                                                                                                <strong>Payment :</strong>
                                                                                                                                                                                                ${order.payment_method}
                                                                                                                                                                                            </p>

                                                                                                                                                                                        </div>

                                                                                                                                                                                    </div>


                                                                                                                                                                                    <!-- Product Table -->

                                                                                                                                                                                    <table class="table invoice-table">

                                                                                                                                                                                        <thead>

                                                                                                                                                                                            <tr>

                                                                                                                                                                                                <th width="6%">SL</th>

                                                                                                                                                                                                <th>Product Description</th>

                                                                                                                                                                                                <th width="14%">Unit Price</th>

                                                                                                                                                                                                <th width="8%">Qty</th>

                                                                                                                                                                                                <th width="14%">Total</th>

                                                                                                                                                                                            </tr>

                                                                                                                                                                                        </thead>

                                                                                                                                                                                        <tbody>

                                                                                                                                                                                            ${rows}

                                                                                                                                                                                        </tbody>

                                                                                                                                                                                    </table>


                                                                                                                                                                                    <!-- Summary -->

                                                                                                                                                                                    <table class="table table-bordered summary-table">

                                                                                                                                                                                        <tr>

                                                                                                                                                                                            <td>Sub Total</td>

                                                                                                                                                                                            <td class="text-right">
                                                                                                                                                                                                ৳ ${order.total_amount}
                                                                                                                                                                                            </td>

                                                                                                                                                                                        </tr>

                                                                                                                                                                                        <tr>

                                                                                                                                                                                            <td>Shipping</td>

                                                                                                                                                                                            <td class="text-right">
                                                                                                                                                                                                ৳ ${order.shipping_amount}
                                                                                                                                                                                            </td>

                                                                                                                                                                                        </tr>

                                                                                                                                                                                        <tr>

                                                                                                                                                                                            <td>VAT / TAX</td>

                                                                                                                                                                                            <td class="text-right">
                                                                                                                                                                                                ৳ ${order.tax_amount}
                                                                                                                                                                                            </td>

                                                                                                                                                                                        </tr>

                                                                                                                                                                                        <tr class="net-payable">

                                                                                                                                                                                            <td>NET PAYABLE</td>

                                                                                                                                                                                            <td class="text-right">
                                                                                                                                                                                                ৳ ${order.total_amount}
                                                                                                                                                                                            </td>

                                                                                                                                                                                        </tr>

                                                                                                                                                                                    </table>


                                                                                                                                                                                    <!-- Footer -->

                                                                                                                                                                                    <div class="row mt-4">

                                                                                                                                                                                        <div class="col-md-6">

                                                                                                                                                                                            <p>
                                                                                                                                                                                                <strong>Payment Status :</strong>

                                                                                                                                                                                                <span class="status-badge payment-badge">
                                                                                                                                                                                                    ${order.payment_status}
                                                                                                                                                                                                </span>

                                                                                                                                                                                            </p>

                                                                                                                                                                                            <p>
                                                                                                                                                                                                <strong>Order Status :</strong>

                                                                                                                                                                                                <span class="status-badge order-badge">
                                                                                                                                                                                                    ${order.order_status}
                                                                                                                                                                                                </span>

                                                                                                                                                                                            </p>

                                                                                                                                                                                        </div>

                                                                                                                                                                                        <div class="col-md-6 text-center">

                                                                                                                                                                                            <div class="signature-line"></div>

                                                                                                                                                                                            <small>
                                                                                                                                                                                                Authorized Signature
                                                                                                                                                                                            </small>

                                                                                                                                                                                        </div>

                                                                                                                                                                                    </div>


                                                                                                                                                                                    <div class="invoice-footer text-center">

                                                                                                                                                                                        <p>
                                                                                                                                                                                            Thank You For Your Business
                                                                                                                                                                                        </p>

                                                                                                                                                                                        <small>
                                                                                                                                                                                            Apon Plastic Industries
                                                                                                                                                                                        </small>

                                                                                                                                                                                    </div>


                                                                                                                                                                                    <div class="text-center print-btn">

                                                                                                                                                                                        <button
                                                                                                                                                                                            onclick="window.print()"
                                                                                                                                                                                            class="btn btn-primary"
                                                                                                                                                                                        >
                                                                                                                                                                                            Print Invoice
                                                                                                                                                                                        </button>

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