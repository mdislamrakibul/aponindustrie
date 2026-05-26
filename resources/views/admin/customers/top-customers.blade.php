@extends('admin.layouts.app')

@section('title', 'Top Customer List')


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
                    <li class="breadcrumb-item active">Top Customer</li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->

<section class="content">

    <div class="container-fluid">

        <div class="card shadow-sm border-0">

            <div class="card-header bg-white border-0">

                <h3 class="card-title">
                    Top Customer List <span style="color:brown; font-weight: bold">[Customers ranked by total spending]</span>
                </h3>

            </div>

            <div class="card-body table-responsive">

                <table class="table table-hover align-middle" id="dataTable">

                    <thead class="bg-light">

                        <tr>

                            <th>SL.</th>
                            <th>Customer</th>
                            <th>Mobile</th>
                            <th>Total Orders</th>
                            <th>Total Spending</th>
                            <th>Customer Type</th>
                            <th>Joined Date</th>
                            <th class="text-center">Action</th>

                        </tr>

                    </thead>

                    <tbody>

                    @forelse($topCustomers as $customer)

                        <tr>

                            <td>
                                {{ $loop->iteration }}.
                            </td>

                            <td>

                                <div class="fw-semibold">

                                    {{ $customer->first_name }}
                                    {{ $customer->last_name }}

                                </div>

                            </td>

                            <td>
                                {{ $customer->phone ?? 'N/A' }}
                            </td>

                            <td>

                                <span class="badge badge-info px-3 py-2">

                                    {{ $customer->total_orders }}

                                </span>

                            </td>

                            <td>

                                <strong>

                                    ৳ {{ number_format($customer->total_spending ?? 0, 2) }}

                                </strong>

                            </td>

                            <td>

                                <form action="{{ route('admin.customers.update.type', $customer->id) }}"
                                      method="POST">

                                    @csrf

                                    <div class="d-flex">

                                        <select name="customer_type"
                                                class="form-control form-control-sm">

                                            <option value="Regular"
                                                {{ $customer->customer_type == 'Regular' ? 'selected' : '' }}>
                                                Regular
                                            </option>

                                            <option value="VIP"
                                                {{ $customer->customer_type == 'VIP' ? 'selected' : '' }}>
                                                VIP
                                            </option>

                                            <option value="Premium"
                                                {{ $customer->customer_type == 'Premium' ? 'selected' : '' }}>
                                                Premium
                                            </option>

                                        </select>

                                        <button type="submit"
                                                class="btn btn-sm btn-primary ml-2">

                                            <i class="fas fa-save"></i>

                                        </button>

                                    </div>

                                </form>

                            </td>

                            <td>

                                {{ \Carbon\Carbon::parse($customer->created_at)->format('d M Y') }}

                            </td>

                            <td class="text-center">

                                <button class="btn btn-sm btn-dark">

                                    <i class="fas fa-edit"></i>

                                </button>

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td colspan="8" class="text-center py-4">

                                No top customers found

                            </td>

                        </tr>

                    @endforelse

                    </tbody>

                </table>

            </div>

        </div>

    </div>

</section>

@endsection
