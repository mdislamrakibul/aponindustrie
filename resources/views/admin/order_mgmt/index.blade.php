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
                                                <button type="button" class="icon-action-btn edit-btn" title="Edit User">
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


@endsection
@push('css')



@endpush
@push('js')



@endpush