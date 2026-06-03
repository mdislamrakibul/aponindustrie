@extends('admin.layouts.app')

@section('title', 'Customer List')

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
                        <li class="breadcrumb-item active">Customer</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->


    <section class="content">

        <div class="container-fluid">

            <div class="card shadow-sm border-0">

                <div class="card-header bg-white">

                    <h3 class="card-title">
                        Customer Management
                    </h3>

                </div>

                <div class="card-body table-responsive">

                    <table class="table table-hover" id="dataTable">

                        <thead class="bg-light">

                            <tr>

                                <th>SL</th>
                                <th>Name</th>
                                <th>Mobile</th>
                                <th>Joined Date</th>
                                <th>Status</th>
                                <th class="text-center">
                                    Actions
                                </th>

                            </tr>

                        </thead>

                        <tbody>

                            @forelse($customers as $customer)

                                <tr>

                                    <td>
                                        {{ $loop->iteration }}.
                                    </td>

                                    <td>
                                        {{ $customer->first_name }}
                                        {{ $customer->last_name }}
                                    </td>

                                    <td>
                                        {{ $customer->phone ?? 'N/A' }}
                                    </td>

                                    <td>
                                        {{ date('d M Y', strtotime($customer->created_at)) }}
                                    </td>

                                    <td>

                                        <span class="badge bg-success">
                                            Active
                                        </span>

                                    </td>

                                    <td class="text-center">

                                        <div class="action-btn-group">

                                            <button type="button" class="action-btn-custom viewHistoryBtn"
                                                data-id="{{ $customer->id }}" title="Order History">

                                                <i class="fas fa-eye" style="color: cornflowerblue;">
                                                </i>

                                            </button>



                                        </div>

                                    </td>
                                </tr>

                            @empty

                                <tr>

                                    <td colspan="6" class="text-center py-4">

                                        No Customers Found

                                    </td>

                                </tr>

                            @endforelse

                        </tbody>

                    </table>

                </div>

            </div>

        </div>

    </section>

    <!-- ORDER HISTORY MODAL -->

    <div class="modal fade" id="orderHistoryModal" tabindex="-1">

        <div class="modal-dialog modal-xl">

            <div class="modal-content border-0 shadow-lg">

                {{-- HEADER --}}
                <div class="modal-header bg-dark">

                    <h5 class="modal-title text-white">

                        Customer Order History

                    </h5>

                    <button type="button" class="close text-white" data-dismiss="modal">

                        <span>&times;</span>

                    </button>

                </div>

                {{-- BODY --}}
                <div class="modal-body">

                    <div class="row">

                        <!-- Left -->

                        <div class="col-md-4">

                            <div class="card">

                                <div class="card-header">

                                    Customer Details

                                </div>

                                <div class="card-body">

                                    <p>
                                        <strong>Name:</strong>
                                        <span id="customerName"></span>
                                    </p>

                                    <p>
                                        <strong>Phone:</strong>
                                        <span id="customerPhone"></span>
                                    </p>

                                    <p>
                                        <strong>Joined:</strong>
                                        <span id="customerJoinDate"></span>
                                    </p>

                                </div>

                            </div>

                        </div>

                        <!-- Right -->

                        <div class="col-md-8">

                            <table class="table table-hover">

                                <thead>

                                    <tr>

                                        <th>Invoice</th>
                                        <th>Date</th>
                                        <th>Amount</th>
                                        <th>Status</th>

                                    </tr>

                                </thead>

                                <tbody id="orderHistoryData">

                                </tbody>

                            </table>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>
    @push('scripts')

        <script>

            $(document).ready(function () {

                $('.viewHistoryBtn').click(function () {

                    let customerId = $(this).data('id');

                    $.ajax({

                        url: '/admin/customers/order-history/' + customerId,
                        type: 'GET',


                        success: function (response) {

                            $('#customerName').text(
                                (response.customer.first_name ?? '') + ' ' +
                                (response.customer.last_name ?? '')
                            );

                            $('#customerPhone').text(
                                response.customer.phone ?? 'N/A'
                            );

                            $('#customerJoinDate').text(
                                response.customer.created_at ?? 'N/A'
                            );

                            let rows = '';

                            if (response.orders.length > 0) {

                                response.orders.forEach(function (order) {

                                    rows += `

                                                                                                                                    <tr>

                                                                                                                                        <td>#${order.invoice_id ?? order.id}</td>

                                                                                                                                        <td>${order.created_at}</td>

                                                                                                                                        <td>৳ ${order.total_amount ?? 0}</td>

                                                                                                                                        <td>

                                                                                                                                            <span class="badge bg-success">

                                                                                                                                                ${order.status ?? 'Completed'}

                                                                                                                                            </span>

                                                                                                                                        </td>

                                                                                                                                    </tr>

                                                                                                                                `;

                                });

                            } else {

                                rows = `

                                                                                                                            <tr>

                                                                                                                                <td colspan="4" class="text-center py-4">

                                                                                                                                    No Order History Found

                                                                                                                                </td>

                                                                                                                            </tr>

                                                                                                                        `;

                            }

                            $('#orderHistoryData').html(rows);

                            $('#orderHistoryModal').modal('show');

                        }

                    });

                });

            });

        </script>

    @endpush

    @push('styles')
        <style>
            .action-btn-custom {
                width: 40px;
                height: 40px;
                border: none !important;
                outline: none !important;
                background: #f8f9fa;
                border-radius: 8px;
                display: flex;
                align-items: center;
                justify-content: center;
                transition: all .3s ease;
                cursor: pointer;
            }

            .action-btn-custom:hover {
                background: #fff;
                transform: translateY(-3px);
                box-shadow: 0 5px 15px rgba(0, 0, 0, .15);
            }

            .action-btn-custom:focus {
                outline: none !important;
                box-shadow: none !important;
            }

            .action-btn-custom i {
                font-size: 15px;
            }

            .action-btn-custom {
                border: none !important;
            }

            .action-btn-custom:hover {
                border: none !important;
            }

            .action-btn-custom:focus {
                border: none !important;
            }

            .action-btn-custom:active {
                border: none !important;
            }
        </style>
    @endpush

@endsection