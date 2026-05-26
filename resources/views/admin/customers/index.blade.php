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

                                    <div class="action-buttons">

                                        {{-- ORDER HISTORY --}}
                                        <button type="button"
                                                class="btn-action btn-history viewHistoryBtn"
                                                data-id="{{ $customer->id }}">

                                            <i class="fas fa-eye"></i>

                                        </button>

                                        {{-- EDIT --}}
                                        <button type="button"
                                                class="btn-action btn-edit">

                                            <i class="fas fa-edit"></i>

                                        </button>

                                        {{-- DELETE --}}
                                        <button type="button"
                                                class="btn-action btn-delete">

                                            <i class="fas fa-trash"></i>

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

<div class="modal fade"
     id="orderHistoryModal"
     tabindex="-1">

    <div class="modal-dialog modal-xl">

        <div class="modal-content border-0 shadow-lg">

            {{-- HEADER --}}
            <div class="modal-header bg-dark">

                <h5 class="modal-title text-white">

                    Customer Order History

                </h5>

                <button type="button"
                        class="close text-white"
                        data-dismiss="modal">

                    <span>&times;</span>

                </button>

            </div>

            {{-- BODY --}}
            <div class="modal-body">

                <div class="table-responsive">

                    <table class="table table-hover">

                        <thead class="bg-light">

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
@push('scripts')

<script>

    $(document).ready(function () {

        $('.viewHistoryBtn').click(function () {

            let customerId = $(this).data('id');

            $.ajax({

                url: '/admin/customers/order-history/' + customerId,
                type: 'GET',

                success: function (response) {

                    let rows = '';

                    if(response.orders.length > 0){

                        response.orders.forEach(function(order){

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

    .action-buttons {

        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;

    }

    .btn-action {

        width: 36px;
        height: 36px;

        border: none;
        border-radius: 10px;

        display: flex;
        align-items: center;
        justify-content: center;

        transition: 0.3s ease;

        color: #fff;

        cursor: pointer;

    }

    .btn-history {

        background: #17a2b8;

    }

    .btn-history:hover {

        background: #138496;
        transform: translateY(-2px);

    }

    .btn-edit {

        background: #007bff;

    }

    .btn-edit:hover {

        background: #0056b3;
        transform: translateY(-2px);

    }

    .btn-delete {

        background: #dc3545;

    }

    .btn-delete:hover {

        background: #b02a37;
        transform: translateY(-2px);

    }

    .table tbody tr:hover {

        background: #f8f9fa;

    }

    .modal-content {

        border-radius: 16px;
        overflow: hidden;

    }

</style>

@endpush

@endsection
