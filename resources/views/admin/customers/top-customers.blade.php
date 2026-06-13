@extends('admin.layouts.app')

@section('title', 'Top Customer List')

@section('content')

    <!-- Content Header -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Dashboard</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard.index') }}">Home</a></li>
                        <li class="breadcrumb-item active">Top Customer</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <div class="card shadow-sm border-0">

                {{-- Card Header with Filter Buttons --}}
                <div class="card-header bg-white border-0 d-flex justify-content-between align-items-center">
                    <h3 class="card-title mb-0">
                        Top Customer List
                        <span style="color:brown; font-weight:bold;">
                            [Ranked by {{ $filter === 'orders' ? 'Total Orders' : 'Total Spending' }}]
                        </span>
                    </h3>
                    <div class="btn-group" role="group">
                        <a href="{{ route('admin.customers.top') }}?filter=spending"
                            class="btn btn-sm {{ $filter !== 'orders' ? 'btn-dark' : 'btn-outline-dark' }}">
                            <i class="fas fa-money-bill-wave mr-1"></i> By Spending
                        </a>
                        <a href="{{ route('admin.customers.top') }}?filter=orders"
                            class="btn btn-sm {{ $filter === 'orders' ? 'btn-dark' : 'btn-outline-dark' }}">
                            <i class="fas fa-shopping-cart mr-1"></i> By Orders
                        </a>
                    </div>
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
                            </tr>
                        </thead>

                        <tbody>
                            @forelse($topCustomers as $customer)
                                <tr>
                                    {{-- SL --}}
                                    <td>{{ $loop->iteration }}.</td>

                                    {{-- Customer Name + Guest Badge --}}
                                    <td>
                                        <div class="fw-semibold">
                                            {{ $customer->first_name }} {{ $customer->last_name }}
                                            @if($customer->is_guest)
                                                <span class="badge badge-warning ml-1" style="font-size:10px;">Guest</span>
                                            @endif
                                        </div>
                                    </td>

                                    {{-- Mobile --}}
                                    <td>{{ $customer->phone ?? $customer->mobile_no ?? 'N/A' }}</td>

                                    {{-- Total Orders --}}
                                    <td>
                                        <span class="badge badge-info px-3 py-2">
                                            {{ $customer->total_orders }}
                                        </span>
                                    </td>

                                    {{-- Total Spending --}}
                                    <td>
                                        <strong>৳ {{ number_format($customer->total_spending ?? 0, 2) }}</strong>
                                    </td>

                                    {{-- Customer Type — update form --}}
                                    <td>
                                        <form action="{{ route('admin.customers.update.type', $customer->id) }}" method="POST">
                                            @csrf
                                            <div class="d-flex">
                                                <select name="customer_type" class="form-control form-control-sm">
                                                    <option value="Regular" {{ $customer->customer_type == 'Regular' ? 'selected' : '' }}>Regular</option>
                                                    <option value="VIP" {{ $customer->customer_type == 'VIP' ? 'selected' : '' }}>
                                                        VIP</option>
                                                    <option value="Premium" {{ $customer->customer_type == 'Premium' ? 'selected' : '' }}>Premium</option>
                                                </select>
                                                <button type="submit" class="btn btn-sm btn-primary ml-2">
                                                    <i class="fas fa-save"></i>
                                                </button>
                                            </div>
                                        </form>
                                    </td>

                                    {{-- Joined Date --}}
                                    <td>{{ \Carbon\Carbon::parse($customer->created_at)->format('d M Y') }}</td>

                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center py-4">No top customers found</td>
                                </tr>
                            @endforelse
                        </tbody>

                    </table>
                </div>

            </div>
        </div>
    </section>

@endsection