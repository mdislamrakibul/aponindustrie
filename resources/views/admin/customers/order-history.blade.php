@extends('admin.layouts.app')

@section('title', 'Order History')

@section('content')

<div class="content-header">

    <div class="container-fluid">

        <div class="row mb-3">

            <div class="col-sm-6">

                <h1 class="m-0">

                    Order History

                </h1>

            </div>

        </div>

    </div>

</div>

<section class="content">

    <div class="container-fluid">

        <div class="card shadow-sm border-0">

            <div class="card-header bg-white">

                <h3 class="card-title">

                    Customer:
                    {{ $customer->first_name }}
                    {{ $customer->last_name }}

                </h3>

            </div>

            <div class="card-body table-responsive p-0">

                <table class="table table-hover text-nowrap">

                    <thead class="bg-light">

                        <tr>

                            <th>Invoice</th>
                            <th>Date</th>
                            <th>Amount</th>
                            <th>Status</th>

                        </tr>

                    </thead>

                    <tbody>

                        @foreach($orders as $order)

                            <tr>

                                <td>
                                    {{ $order['invoice'] }}
                                </td>

                                <td>
                                    {{ $order['date'] }}
                                </td>

                                <td>
                                    ৳ {{ number_format($order['amount']) }}
                                </td>

                                <td>

                                    @if($order['status'] == 'Completed')

                                        <span class="badge bg-success">

                                            Completed

                                        </span>

                                    @else

                                        <span class="badge bg-warning">

                                            Pending

                                        </span>

                                    @endif

                                </td>

                            </tr>

                        @endforeach

                    </tbody>

                </table>

            </div>

        </div>

    </div>

</section>

@endsection