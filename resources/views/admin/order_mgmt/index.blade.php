@extends('admin.layouts.app')

@section('title')
    Order Mgmt
@endsection


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

        <div class="modal-dialog modal-lg">

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
            padding: 25px;
            font-family: 'Segoe UI', sans-serif;
        }

        .invoice-header {
            text-align: center;
            border-bottom: 2px dashed #ddd;
            padding-bottom: 15px;
            margin-bottom: 20px;
        }

        .invoice-header h4 {
            margin: 0;
            font-weight: 700;
        }

        .invoice-header h5 {
            margin: 4px 0;
            font-weight: 700;
        }

        .invoice-meta {
            margin-top: 15px;
        }

        .invoice-section-title {
            font-weight: 700;
            border-bottom: 1px solid #ddd;
            margin-bottom: 10px;
            padding-bottom: 5px;
        }

        .invoice-table th {
            background: #f8f9fa;
        }

        .invoice-summary {
            margin-top: 20px;
        }

        .invoice-summary table {
            width: 100%;
        }

        .invoice-summary td {
            padding: 5px 0;
        }

        .invoice-total {
            font-size: 18px;
            font-weight: 700;
        }

        .print-btn {
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

                            order.order_items.forEach((item, index) => {

                                rows += `
                                            <tr>
                                                <td>${index + 1}</td>
                                                <td>${item.product?.name ?? 'Product'}</td>
                                                <td>${item.price}</td>
                                                <td>${item.quantity}</td>
                                                <td>${item.total}</td>
                                            </tr>
                                        `;

                            });

                            $('#invoiceContent').html(`

                                    <div class="invoice-wrapper">

                                        <div class="invoice-header">

                                            <div>
                                                Government of the People's Republic of Bangladesh
                                            </div>

                                            <div>
                                                National Board of Revenue
                                            </div>

                                            <br>

                                            <h4>
                                                APON PLASTIC INDUSTRIES
                                            </h4>

                                            <div>
                                                Gazipur, Dhaka, Bangladesh
                                            </div>

                                            <div>
                                                Phone: 017xxxxxxxx
                                            </div>

                                            <div>
                                                Email: info@aponplastic.com
                                            </div>

                                            <div>
                                                Website: www.aponplastic.com
                                            </div>

                                            <div>
                                                BIN: 123456789
                                            </div>

                                            <br>

                                            <h5>
                                                RETAIL INVOICE
                                            </h5>

                                        </div>

                                        <div class="row invoice-meta">

                                            <div class="col-md-6">

                                                <div class="invoice-section-title">
                                                    Customer Information
                                                </div>

                                                <p>
                                                    <strong>Name:</strong>
                                                    ${order.order_address.first_name}
                                                    ${order.order_address.last_name}
                                                </p>

                                                <p>
                                                    <strong>Phone:</strong>
                                                    ${order.order_address.phone}
                                                </p>

                                                <p>
                                                    <strong>Email:</strong>
                                                    ${order.order_address.email}
                                                </p>

                                                <p>
                                                    <strong>Address:</strong>
                                                    ${order.order_address.address_line1}
                                                </p>

                                            </div>

                                            <div class="col-md-6">

                                                <div class="invoice-section-title">
                                                    Invoice Information
                                                </div>

                                                <p>
                                                    <strong>Invoice No:</strong>
                                                    ${order.order_number}
                                                </p>

                                                <p>
                                                    <strong>Date:</strong>
                                                    ${order.created_at}
                                                </p>

                                                <p>
                                                    <strong>Transaction:</strong>
                                                    ${order.transaction_id}
                                                </p>

                                            </div>

                                        </div>

                                        <table class="table table-bordered invoice-table mt-3">

                                            <thead>

                                                <tr>

                                                    <th>SL</th>

                                                    <th>Product</th>

                                                    <th>Unit Price</th>

                                                    <th>Qty</th>

                                                    <th>Total</th>

                                                </tr>

                                            </thead>

                                            <tbody>

                                                ${rows}

                                            </tbody>

                                        </table>

                                        <div class="invoice-summary">

                                            <table>

                                                <tr>

                                                    <td>Subtotal</td>

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

                                                <tr class="invoice-total">

                                                    <td>Net Payable</td>

                                                    <td class="text-right">
                                                        ৳ ${order.total_amount}
                                                    </td>

                                                </tr>

                                            </table>

                                        </div>

                                        <hr>

                                        <div>

                                            <p>
                                                <strong>Payment Method:</strong>
                                                ${order.payment_method}
                                            </p>

                                            <p>
                                                <strong>Payment Status:</strong>
                                                ${order.payment_status}
                                            </p>

                                            <p>
                                                <strong>Order Status:</strong>
                                                ${order.order_status}
                                            </p>

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