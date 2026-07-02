@extends('admin.layouts.app')

@push('css')
<style>
@media (max-width: 576px) {
    .filter-btn { flex: 1 1 auto; justify-content: center; }
    .filter-bar > a.btn { margin-left: 0 !important; margin-top: 4px; width: 100%; text-align: center; }
}
</style>
@endpush

@section('title')
    Order Management
@endsection

@section('content')

    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6"><h1 class="m-0">Orders</h1></div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard.index') }}">Home</a></li>
                        <li class="breadcrumb-item active">Orders</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card shadow-sm border-0">

                        <div class="card-header bg-white border-bottom d-flex align-items-center" style="padding:16px 20px;">
                            <h3 class="card-title font-weight-bold mb-0">
                                <i class="fas fa-shopping-cart mr-2 text-primary"></i> Order Management
                            </h3>
                        </div>

                        {{-- ── Filter Bar ── --}}
                        @php
                            $allCount       = count($orders);
                            $activeCount    = collect($orders)->filter(fn($o) => !in_array($o['order_status'], ['DELIVERED','CANCELLED']))->count();
                            $completeCount  = collect($orders)->filter(fn($o) => $o['order_status'] === 'DELIVERED' && $o['payment_status'] === 'PAID')->count();
                            $cancelledCount = collect($orders)->filter(fn($o) => $o['order_status'] === 'CANCELLED')->count();
                            $posCount       = collect($orders)->filter(fn($o) => ($o['source'] ?? 'online') === 'pos')->count();
                        @endphp
                        <div class="filter-bar">
                            <button type="button" class="filter-btn active-filter" data-filter="all">
                                All <span class="filter-count">{{ $allCount }}</span>
                            </button>
                            <button type="button" class="filter-btn" data-filter="active">
                                Active <span class="filter-count">{{ $activeCount }}</span>
                            </button>
                            <button type="button" class="filter-btn" data-filter="complete">
                                Complete <span class="filter-count">{{ $completeCount }}</span>
                            </button>
                            <button type="button" class="filter-btn" data-filter="cancelled">
                                Cancelled <span class="filter-count">{{ $cancelledCount }}</span>
                            </button>
                            <button type="button" class="filter-btn" data-filter="pos">
                                <i class="fas fa-store" style="font-size:11px;"></i> Physical Sales <span class="filter-count">{{ $posCount }}</span>
                            </button>
                            <div class="d-flex" style="margin-left:auto;gap:6px;">
                                <a href="{{ route('admin.orders.new.page') }}" class="btn btn-sm btn-outline-warning">
                                    <i class="fas fa-bell mr-1"></i> New Orders
                                </a>
                                <button type="button" class="btn btn-sm btn-success" data-toggle="modal" data-target="#addOrderModal">
                                    <i class="fas fa-plus mr-1"></i> Add Order
                                </button>
                            </div>
                        </div>

                        <div class="card-body p-0">
                            <div class="table-responsive">
                                {{-- NOTE: id must be orderTable, NOT dataTable
                                     because layout.app.blade.php already calls
                                     $('#dataTable').DataTable() globally. --}}
                                <table class="table table-hover align-middle mb-0" id="orderTable">
                                    <thead class="thead-light">
                                        <tr>
                                            <th>Order No.</th>
                                            <th>Customer</th>
                                            <th>Total</th>
                                            <th>Payment Method</th>
                                            <th>Date</th>
                                            <th>Order Status</th>
                                            <th>Payment Status</th>
                                            <th class="text-center nosort" style="width:130px;">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody id="orderTableBody">
                                    @forelse ($orders as $order)
                                        @php $isLocked = $order['order_status'] === 'DELIVERED' && $order['payment_status'] === 'PAID'; @endphp
                                        <tr id="order-row-{{ $order['id'] }}"
                                            data-os="{{ $order['order_status'] }}"
                                            data-ps="{{ $order['payment_status'] }}"
                                            data-source="{{ $order['source'] ?? 'online' }}"
                                            class="{{ $isLocked ? 'row-locked' : '' }}">

                                            {{-- Order Number --}}
                                            <td>
                                                <span class="font-weight-bold text-primary">{{ $order['order_number'] }}</span>
                                                <br><small class="text-muted">#{{ $order['id'] }}</small>
                                            </td>

                                            {{-- Customer --}}
                                            <td>
                                                @if(!empty($order['order_address']))
                                                    <span>{{ trim(($order['order_address']['first_name'] ?? '') . ' ' . ($order['order_address']['last_name'] ?? '')) }}</span>
                                                    <br><small class="text-muted">{{ $order['order_address']['phone'] ?? '' }}</small>
                                                @else
                                                    <span class="text-muted">N/A</span>
                                                @endif
                                            </td>

                                            {{-- Total --}}
                                            <td class="font-weight-bold">
                                                <span class="order-total-{{ $order['id'] }}">৳ {{ number_format($order['total_amount'], 2) }}</span>
                                                <div class="edit-mode d-none mt-2">
                                                    <select class="form-control form-control-sm delivery-zone-select" data-id="{{ $order['id'] }}" style="font-size:11px;min-width:160px;">
                                                        <option value="dhaka_city">In Dhaka City (৳75)</option>
                                                        <option value="outside_dhaka_city">Outside Dhaka City (৳110)</option>
                                                        <option value="outside_dhaka_district">Outside Dhaka District (৳135)</option>
                                                        <option value="free">Free Shipping (৳0)</option>
                                                    </select>
                                                    <button type="button" class="btn btn-info btn-sm mt-1 delivery-zone-btn" data-id="{{ $order['id'] }}" style="font-size:11px;width:100%;">
                                                        <i class="fas fa-truck mr-1"></i> Apply Zone
                                                    </button>
                                                </div>
                                            </td>

                                            {{-- Payment Method --}}
                                            <td><span class="badge badge-light border">{{ $order['payment_method'] }}</span></td>

                                            {{-- Date --}}
                                            <td>
                                                {{ \Carbon\Carbon::parse($order['created_at'])->format('d M Y') }}
                                                <br><small class="text-muted">{{ \Carbon\Carbon::parse($order['created_at'])->format('h:i A') }}</small>
                                            </td>

                                            {{-- Order Status --}}
                                            <td>
                                                <span class="view-mode order-status-badge-{{ $order['id'] }}">
                                                    @php $osBadge = match ($order['order_status']) {
                                                        'PROCESSING' => 'badge-warning', 'SHIPPED' => 'badge-info',
                                                        'DELIVERED' => 'badge-success', 'CANCELLED' => 'badge-danger',
                                                        default => 'badge-secondary'
                                                    }; @endphp
                                                    <span class="badge {{ $osBadge }} px-3 py-2">{{ $order['order_status'] }}</span>
                                                </span>
                                                <select class="form-control form-control-sm edit-mode d-none order-status-select"
                                                    id="order-status-{{ $order['id'] }}" style="min-width:130px;">
                                                    <option value="PROCESSING" {{ $order['order_status'] == 'PROCESSING' ? 'selected' : '' }}>Processing</option>
                                                    <option value="SHIPPED"    {{ $order['order_status'] == 'SHIPPED' ? 'selected' : '' }}>Shipped</option>
                                                    <option value="DELIVERED"  {{ $order['order_status'] == 'DELIVERED' ? 'selected' : '' }}>Delivered</option>
                                                    <option value="CANCELLED"  {{ $order['order_status'] == 'CANCELLED' ? 'selected' : '' }}>Cancelled</option>
                                                </select>
                                            </td>

                                            {{-- Payment Status --}}
                                            <td>
                                                <span class="view-mode payment-status-badge-{{ $order['id'] }}">
                                                    @php $psBadge = match ($order['payment_status']) {
                                                        'PAID' => 'badge-success', 'PENDING' => 'badge-warning',
                                                        'FAILED' => 'badge-danger', 'REFUNDED' => 'badge-info',
                                                        default => 'badge-secondary'
                                                    }; @endphp
                                                    <span class="badge {{ $psBadge }} px-3 py-2">{{ $order['payment_status'] }}</span>
                                                </span>
                                                <select class="form-control form-control-sm edit-mode d-none payment-status-select"
                                                    id="payment-status-{{ $order['id'] }}" style="min-width:120px;">
                                                    <option value="PENDING"  {{ $order['payment_status'] == 'PENDING' ? 'selected' : '' }}>Pending</option>
                                                    <option value="PAID"     {{ $order['payment_status'] == 'PAID' ? 'selected' : '' }}>Paid</option>
                                                    <option value="FAILED"   {{ $order['payment_status'] == 'FAILED' ? 'selected' : '' }}>Failed</option>
                                                    <option value="REFUNDED" {{ $order['payment_status'] == 'REFUNDED' ? 'selected' : '' }}>Refunded</option>
                                                </select>
                                            </td>

                                            {{-- Actions --}}
                                            <td class="text-center">
                                                <div class="d-flex align-items-center justify-content-center" style="gap:5px;">
                                                    <button type="button" class="action-btn view-order-btn"
                                                        data-id="{{ $order['id'] }}" title="View Invoice">
                                                        <i class="fas fa-eye" style="color:cornflowerblue;"></i>
                                                    </button>
                                                    @if($isLocked)
                                                        <button type="button" class="action-btn" title="Order complete — locked" disabled style="cursor:default;opacity:.55;">
                                                            <i class="fas fa-lock" style="color:#6c757d;"></i>
                                                        </button>
                                                    @else
                                                        <button type="button" class="action-btn order-edit-btn"
                                                            data-id="{{ $order['id'] }}" title="Edit Status">
                                                            <i class="fas fa-pen" style="color:#e67e22;"></i>
                                                        </button>
                                                        <button type="button" class="action-btn order-save-btn d-none"
                                                            data-id="{{ $order['id'] }}" title="Save">
                                                            <i class="fas fa-check" style="color:darkgreen;"></i>
                                                        </button>
                                                        <button type="button" class="action-btn order-discard-btn d-none"
                                                            data-id="{{ $order['id'] }}" title="Discard">
                                                            <i class="fas fa-times" style="color:maroon;"></i>
                                                        </button>
                                                    @endif
                                                </div>
                                            </td>

                                        </tr>
                                    @empty
                                        <tr id="empty-orders-row">
                                            <td colspan="8" class="text-center py-5 text-muted">
                                                <i class="fas fa-inbox fa-3x mb-3 d-block" style="color:#dee2e6;"></i>
                                                No accepted orders yet. Go to
                                                <a href="{{ route('admin.orders.new.page') }}">New Orders</a> to accept pending orders.
                                            </td>
                                        </tr>
                                    @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- INVOICE MODAL --}}
    <div class="modal fade" id="orderViewModal" tabindex="-1">
        <div class="modal-dialog modal-xl" style="max-width:1200px;">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Order Invoice</h5>
                    <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                </div>
                <div class="modal-body p-0">
                    <div id="invoiceContent" style="padding:30px;"></div>
                    <div id="posInvoiceContent" style="display:none; background:#e8e8e8; padding:24px; text-align:center; min-height:200px;"></div>
                </div>
                <div class="modal-footer d-none no-print" id="invoiceActionBar" style="justify-content:space-between; flex-wrap:wrap; gap:10px;">
                    <div style="display:flex;flex-wrap:wrap;gap:14px;align-items:center;">
                        <div class="d-flex align-items-center" style="gap:12px;">
                            <span style="font-weight:600;">Format:</span>
                            <label class="mb-0" style="cursor:pointer;"><input type="radio" name="printFormat" value="a4" checked style="margin-right:4px;"> A4</label>
                            <label class="mb-0" style="cursor:pointer;"><input type="radio" name="printFormat" value="pos" style="margin-right:4px;"> POS</label>
                        </div>
                        <div id="posOptions" style="display:none;flex-wrap:wrap;gap:10px;align-items:center;border-left:1px solid #dee2e6;padding-left:14px;">
                            <div class="d-flex align-items-center" style="gap:6px;">
                                <label class="mb-0" style="font-weight:600;font-size:12px;white-space:nowrap;">Hotline 2:</label>
                                <input type="text" id="posHotline2" class="form-control form-control-sm" placeholder="Optional" style="width:130px;font-size:12px;">
                            </div>
                            <div class="d-flex align-items-center" style="gap:6px;">
                                <label class="mb-0" style="font-weight:600;font-size:12px;">NB:</label>
                                <input type="text" id="posNoteNB" class="form-control form-control-sm" placeholder="Optional note" style="width:160px;font-size:12px;">
                            </div>
                        </div>
                    </div>
                    <div class="d-flex" style="gap:8px;">
                        <button onclick="printSelected()" class="btn btn-primary px-4"><i class="fas fa-print mr-2"></i> Print</button>
                        <button onclick="downloadSelected()" class="btn btn-success px-4" id="invoiceDownloadBtn"><i class="fas fa-download mr-2"></i> Download</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- ADD ORDER MODAL --}}
    @php
    $bdDistricts = [
        'Bagerhat','Bandarban','Barguna','Barishal','Bhola','Bogura','Brahmanbaria',
        'Chandpur','Chapainawabganj','Chattogram','Chuadanga',"Cox's Bazar",'Cumilla',
        'Dhaka','Dinajpur','Faridpur','Feni','Gaibandha','Gazipur','Gopalganj',
        'Habiganj','Jamalpur','Jashore','Jhalokati','Jhenaidah','Joypurhat',
        'Khagrachari','Khulna','Kishoreganj','Kurigram','Kushtia','Lakshmipur',
        'Lalmonirhat','Madaripur','Magura','Manikganj','Meherpur','Moulvibazar',
        'Munshiganj','Mymensingh','Naogaon','Narail','Narayanganj','Narsingdi',
        'Natore','Netrokona','Nilphamari','Noakhali','Pabna','Panchagarh',
        'Patuakhali','Pirojpur','Rajbari','Rajshahi','Rangamati','Rangpur',
        'Satkhira','Shariatpur','Sherpur','Sirajganj','Sunamganj','Sylhet',
        'Tangail','Thakurgaon',
    ];
    @endphp
    <div class="modal fade" id="addOrderModal" tabindex="-1">
        <div class="modal-dialog modal-xl" style="max-width:900px;">
            <div class="modal-content">
                <div class="modal-header" style="background:#0d3b66;color:#fff;">
                    <h5 class="modal-title"><i class="fas fa-plus-circle mr-2"></i>Add Order</h5>
                    <button type="button" class="close text-white" data-dismiss="modal"><span>&times;</span></button>
                </div>
                <div class="modal-body" style="background:#f8f9fa;">
                    <div class="row">
                        {{-- LEFT COLUMN --}}
                        <div class="col-md-7">
                            {{-- Customer Info --}}
                            <div class="card mb-3 shadow-sm border-0">
                                <div class="card-header bg-white py-2"><strong><i class="fas fa-user mr-1 text-primary"></i> Customer</strong></div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-sm-6 mb-2">
                                            <label class="small font-weight-bold mb-1">Full Name <span class="text-danger">*</span></label>
                                            <input type="text" id="ao_name" class="form-control form-control-sm" placeholder="Customer name">
                                        </div>
                                        <div class="col-sm-6 mb-2">
                                            <label class="small font-weight-bold mb-1">Phone <span class="text-danger">*</span></label>
                                            <input type="text" id="ao_phone" class="form-control form-control-sm" placeholder="01XXXXXXXXX">
                                        </div>
                                        <div class="col-sm-6 mb-2">
                                            <label class="small font-weight-bold mb-1">Email <span class="text-muted fw-normal">(optional)</span></label>
                                            <input type="email" id="ao_email" class="form-control form-control-sm" placeholder="email@example.com">
                                        </div>
                                        <div class="col-sm-6 mb-2">
                                            <label class="small font-weight-bold mb-1">Thana <span class="text-muted fw-normal">(optional)</span></label>
                                            <input type="text" id="ao_thana" class="form-control form-control-sm" placeholder="Thana / Upazila">
                                        </div>
                                        <div class="col-sm-6 mb-2">
                                            <label class="small font-weight-bold mb-1">District <span class="text-muted fw-normal">(optional)</span></label>
                                            <select id="ao_district" class="form-control form-control-sm">
                                                <option value="">— Select District —</option>
                                                @foreach($bdDistricts as $d)
                                                <option value="{{ $d }}">{{ $d }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-sm-6 mb-2">
                                            <label class="small font-weight-bold mb-1">Address</label>
                                            <input type="text" id="ao_address" class="form-control form-control-sm" placeholder="House / Road / Area">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- Product Search --}}
                            <div class="card mb-3 shadow-sm border-0">
                                <div class="card-header bg-white py-2"><strong><i class="fas fa-box mr-1 text-success"></i> Products</strong></div>
                                <div class="card-body">
                                    <div class="position-relative mb-3">
                                        <input type="text" id="ao_product_search" class="form-control form-control-sm" placeholder="Search by product name or SKU…" autocomplete="off">
                                        <div id="ao_product_dropdown" class="list-group position-absolute w-100 shadow" style="z-index:9999;display:none;max-height:200px;overflow-y:auto;top:100%;left:0;"></div>
                                    </div>
                                    <div class="table-responsive">
                                        <table class="table table-sm table-bordered mb-0" id="ao_items_table">
                                            <thead class="thead-light">
                                                <tr>
                                                    <th>Product</th>
                                                    <th class="text-right" style="width:90px;">Price</th>
                                                    <th class="text-center" style="width:80px;">Qty</th>
                                                    <th class="text-right" style="width:100px;">Total</th>
                                                    <th style="width:40px;"></th>
                                                </tr>
                                            </thead>
                                            <tbody id="ao_items_body">
                                                <tr id="ao_empty_row"><td colspan="5" class="text-center text-muted py-3">No products added yet. Search above.</td></tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- RIGHT COLUMN --}}
                        <div class="col-md-5">
                            {{-- Payment --}}
                            <div class="card mb-3 shadow-sm border-0">
                                <div class="card-header bg-white py-2"><strong><i class="fas fa-credit-card mr-1 text-warning"></i> Payment</strong></div>
                                <div class="card-body">
                                    <div class="mb-2">
                                        <label class="small font-weight-bold mb-1">Payment Method <span class="text-danger">*</span></label>
                                        <select id="ao_payment_method" class="form-control form-control-sm">
                                            <option value="Cash" selected>Cash</option>
                                            <option value="Cash on Delivery">Cash on Delivery</option>
                                            <option value="Online">Online</option>
                                            <option value="Bkash">Bkash</option>
                                        </select>
                                    </div>
                                    <div class="mb-2">
                                        <label class="small font-weight-bold mb-1">Payment Status <span class="text-danger">*</span></label>
                                        <select id="ao_payment_status" class="form-control form-control-sm">
                                            <option value="PAID" selected>PAID</option>
                                            <option value="PENDING">PENDING</option>
                                        </select>
                                    </div>
                                    <div class="mb-0">
                                        <label class="small font-weight-bold mb-1">Order Status <span class="text-danger">*</span></label>
                                        <select id="ao_order_status" class="form-control form-control-sm">
                                            <option value="PROCESSING" selected>PROCESSING</option>
                                            <option value="PENDING">PENDING</option>
                                            <option value="SHIPPED">SHIPPED</option>
                                            <option value="DELIVERED">DELIVERED</option>
                                            <option value="CANCELLED">CANCELLED</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            {{-- Delivery --}}
                            <div class="card mb-3 shadow-sm border-0">
                                <div class="card-header bg-white py-2"><strong><i class="fas fa-truck mr-1 text-info"></i> Delivery</strong></div>
                                <div class="card-body">
                                    <label class="small font-weight-bold mb-2">Delivery Zone</label>
                                    <div class="d-flex flex-column" style="gap:6px;">
                                        <label class="mb-0" style="cursor:pointer;">
                                            <input type="radio" name="ao_zone" value="pickup" id="ao_zone_pickup" style="margin-right:5px;">
                                            Pickup / No delivery <span class="text-muted">(৳0)</span>
                                        </label>
                                        <label class="mb-0" style="cursor:pointer;">
                                            <input type="radio" name="ao_zone" value="inside" id="ao_zone_inside" checked style="margin-right:5px;">
                                            Inside Dhaka <span class="text-muted">(৳100)</span>
                                        </label>
                                        <label class="mb-0" style="cursor:pointer;">
                                            <input type="radio" name="ao_zone" value="outside" id="ao_zone_outside" style="margin-right:5px;">
                                            Outside Dhaka <span class="text-muted">(৳150)</span>
                                        </label>
                                    </div>
                                    <p class="small text-success mt-2 mb-0"><i class="fas fa-info-circle mr-1"></i>FREE delivery if subtotal &gt; ৳1,000</p>
                                </div>
                            </div>

                            {{-- Summary --}}
                            <div class="card mb-3 shadow-sm border-0">
                                <div class="card-header bg-white py-2"><strong><i class="fas fa-calculator mr-1"></i> Summary</strong></div>
                                <div class="card-body py-2">
                                    <div class="d-flex justify-content-between mb-1">
                                        <span class="text-muted small">Sub Total</span>
                                        <span id="ao_subtotal_display" class="small font-weight-bold">৳ 0.00</span>
                                    </div>
                                    <div class="d-flex justify-content-between mb-1">
                                        <span class="text-muted small">Delivery</span>
                                        <span id="ao_delivery_display" class="small font-weight-bold">৳ 0.00</span>
                                    </div>
                                    <hr class="my-2">
                                    <div class="d-flex justify-content-between">
                                        <span class="font-weight-bold">Total</span>
                                        <span id="ao_total_display" class="font-weight-bold text-success" style="font-size:15px;">৳ 0.00</span>
                                    </div>
                                </div>
                            </div>

                            {{-- Notes --}}
                            <div class="mb-3">
                                <label class="small font-weight-bold mb-1">Notes (optional)</label>
                                <textarea id="ao_notes" class="form-control form-control-sm" rows="2" placeholder="Special instructions…"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-white">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="button" id="ao_submit_btn" class="btn btn-success px-4">
                        <i class="fas fa-check-circle mr-1"></i> Place Order
                    </button>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('css')
    <style>
    /* ─── TABLE ── */
    #orderTable td, #orderTable th { vertical-align: middle; }
    #orderTable thead th {
        font-size: 12px; font-weight: 700;
        text-transform: uppercase; letter-spacing:.5px;
        color:#555; border-top:none; padding:14px 12px;
    }
    #orderTable tbody td { padding:12px; }

    /* ─── LOCKED ROW ── */
    tr.row-locked { background: #f6fff9 !important; }
    tr.row-locked td { color: #555; }

    /* ─── ACTION BUTTONS ── */
    .action-btn {
        width:34px; height:34px; border-radius:8px;
        border:none; outline:none; background:#f8f9fa;
        display:inline-flex; align-items:center; justify-content:center;
        cursor:pointer; transition:all .2s;
        box-shadow:0 1px 3px rgba(0,0,0,.08);
    }
    .action-btn:hover { background:#e2e8f0; transform:translateY(-2px); }
    .action-btn:focus { outline:none; box-shadow:none; }
    .action-btn i { font-size:13px; }

    /* ─── FILTER BAR ── */
    .filter-bar {
        padding: 14px 20px;
        background: #f8f9fa;
        border-bottom: 1px solid #e8ecf0;
        display: flex;
        align-items: flex-end;
        gap: 10px;
        flex-wrap: wrap;
    }
    .filter-btn {
        display: inline-flex; align-items: center; gap: 6px;
        padding: 7px 16px; border-radius: 20px; border: 1.5px solid #dee2e6;
        background: #fff; color: #555; font-size: 12px; font-weight: 600;
        cursor: pointer; transition: all .18s; white-space: nowrap;
        box-shadow: 0 1px 2px rgba(0,0,0,.06);
    }
    .filter-btn:hover { border-color: #0d6efd; color: #0d6efd; box-shadow: 0 2px 5px rgba(13,110,253,.15); }
    .filter-btn.active-filter                              { background: #0d6efd; border-color: #0d6efd; color: #fff; box-shadow: 0 3px 8px rgba(13,110,253,.35); }
    .filter-btn.active-filter:hover                        { background: #0b5ed7; }
    .filter-btn[data-filter="cancelled"].active-filter     { background: #dc3545; border-color: #dc3545; box-shadow: 0 3px 8px rgba(220,53,69,.35); }
    .filter-btn[data-filter="cancelled"].active-filter:hover { background: #c82333; border-color: #c82333; }
    .filter-btn[data-filter="cancelled"]:hover             { border-color: #dc3545; color: #dc3545; }
    .filter-btn[data-filter="pos"].active-filter           { background: #6f42c1; border-color: #6f42c1; box-shadow: 0 3px 8px rgba(111,66,193,.35); }
    .filter-btn[data-filter="pos"].active-filter:hover     { background: #5a32a3; border-color: #5a32a3; }
    .filter-btn[data-filter="pos"]:hover                   { border-color: #6f42c1; color: #6f42c1; }
    .filter-count {
        background: rgba(0,0,0,.1); border-radius: 10px;
        padding: 1px 7px; font-size: 11px; font-weight: 700; min-width: 20px; text-align: center;
    }
    .filter-btn.active-filter .filter-count { background: rgba(255,255,255,.3); }

    /* ─── POS RECEIPT ── */
    .pos-receipt { width:80mm; max-width:80mm; margin:0 auto; padding:6px 8px; font-family:'Courier New',monospace; font-size:12px; line-height:1.5; color:#000; background:#fff; }
    .pos-center  { text-align:center; }
    .pos-bold    { font-weight:700; }
    .pos-sm      { font-size:11px; }
    .pos-hr      { border-top:1px dashed #000; margin:6px 0; }
    .pos-hr.pos-double { border-top:2px solid #000; }
    .pos-row     { display:flex; justify-content:space-between; gap:8px; }
    .pos-items   { width:100%; border-collapse:collapse; font-size:11px; table-layout:fixed; }
    .pos-items th, .pos-items td { text-align:left; padding:2px 4px; word-break:break-word; }
    .pos-items th:nth-child(1), .pos-items td:nth-child(1) { width:10%; }
    .pos-items th:nth-child(2), .pos-items td:nth-child(2) { width:40%; }
    .pos-items th:nth-child(3), .pos-items td:nth-child(3) { width:10%; text-align:right; }
    .pos-items th:nth-child(4), .pos-items td:nth-child(4) { width:20%; text-align:right; }
    .pos-items th:nth-child(5), .pos-items td:nth-child(5) { width:20%; text-align:right; }

    /* ─── PAYMENT PROOF ── */
    .payment-proof-img {
        max-width:100%; max-height:200px;
        border:1px solid #dee2e6; border-radius:6px;
        margin-top:8px; cursor:pointer; display:block;
    }

    /* ─── PRINT: fallback for Ctrl+P on the modal page ── */
    @media print {
        body * { visibility: hidden !important; }
        #invoiceContent, #invoiceContent * { visibility: visible !important; }
        #invoiceContent {
            position: absolute; left: 0; top: 0; width: 100%;
            padding: 0 !important; margin: 0 !important; box-shadow: none !important;
        }
        .no-print, .modal-header, .modal-footer { display: none !important; }
        .modal, .modal-dialog, .modal-content { position: static !important; border: 0 !important; box-shadow: none !important; }
        * { -webkit-print-color-adjust: exact !important; print-color-adjust: exact !important; }
    }
    </style>
@endpush

@push('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
    <script>
    var _posOrder = null, _posExt = {};

    $(document).ready(function () {

        const CSRF     = '{{ csrf_token() }}';
        const BASE_URL = '{{ url("admin/orders") }}';

        $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': CSRF, 'X-Requested-With': 'XMLHttpRequest' } });

        /* ════════════════════════════════════════════════════════
           📊 FILTER LOGIC — registered BEFORE DataTable init
        ════════════════════════════════════════════════════════ */
        var currentFilter = 'all';

        $.fn.dataTable.ext.search.push(function (settings, data, dataIndex) {
            if (settings.nTable.id !== 'orderTable') return true;
            if (currentFilter === 'all') return true;
            var node = orderDT.row(dataIndex).node();
            var os   = $(node).data('os');
            var ps   = $(node).data('ps');
            if (currentFilter === 'complete')   return os === 'DELIVERED' && ps === 'PAID';
            if (currentFilter === 'active')     return os !== 'DELIVERED' && os !== 'CANCELLED';
            if (currentFilter === 'cancelled')  return os === 'CANCELLED';
            if (currentFilter === 'pos')        return $(node).data('source') === 'pos';
            return true;
        });

        /* ── DataTable ── */
        var orderDT = $('#orderTable').DataTable({
            columnDefs: [{ orderable: false, targets: [5, 6, 7] }],
            order: [[4, 'desc']],
            pageLength: 10,
            language: { emptyTable: 'No accepted orders yet.' }
        });

        /* ── Filter pill buttons ── */
        $(document).on('click', '.filter-btn', function () {
            currentFilter = $(this).data('filter');
            $('.filter-btn').removeClass('active-filter');
            $(this).addClass('active-filter');
            orderDT.draw();
        });

        /* ════════════════════════════════════════════════════════
           ✏️ EDIT / SAVE / DISCARD — Main Table
        ════════════════════════════════════════════════════════ */

        /* EDIT */
        $(document).on('click', '.order-edit-btn', function () {
            var id  = $(this).data('id');
            var row = $('#order-row-' + id);
            row.data('orig-os', row.find('.order-status-select').val());
            row.data('orig-ps', row.find('.payment-status-select').val());
            row.find('.view-mode').addClass('d-none');
            row.find('.edit-mode').removeClass('d-none');
            row.find('.order-edit-btn, .view-order-btn').addClass('d-none');
            row.find('.order-save-btn, .order-discard-btn').removeClass('d-none');
        });

        /* DISCARD */
        $(document).on('click', '.order-discard-btn', function () {
            var id  = $(this).data('id');
            var row = $('#order-row-' + id);
            row.find('.order-status-select').val(row.data('orig-os'));
            row.find('.payment-status-select').val(row.data('orig-ps'));
            row.find('.view-mode').removeClass('d-none');
            row.find('.edit-mode').addClass('d-none');
            row.find('.order-edit-btn, .view-order-btn').removeClass('d-none');
            row.find('.order-save-btn, .order-discard-btn').addClass('d-none');
        });

        /* SAVE */
        $(document).on('click', '.order-save-btn', function () {
            var id      = $(this).data('id');
            var row     = $('#order-row-' + id);
            var saveBtn = $(this);
            var os      = row.find('.order-status-select').val();
            var ps      = row.find('.payment-status-select').val();

            if (!os || !ps) {
                Swal.fire('Error', 'Could not read status values — please refresh the page.', 'error');
                return;
            }

            saveBtn.prop('disabled', true)
                   .html('<i class="fas fa-spinner fa-spin" style="color:darkgreen;font-size:13px;"></i>');

            $.ajax({
                url:      BASE_URL + '/' + id + '/update-status',
                type:     'POST',
                dataType: 'json',
                data:     { _token: CSRF, _method: 'PATCH', order_status: os, payment_status: ps }
            })
            .done(function (res) {
                try {
                    if (!res.success) { Swal.fire('Error', 'Update failed.', 'error'); return; }

                    var osBadge = { PROCESSING:'badge-warning', SHIPPED:'badge-info', DELIVERED:'badge-success', CANCELLED:'badge-danger' };
                    var psBadge = { PAID:'badge-success', PENDING:'badge-warning', FAILED:'badge-danger', REFUNDED:'badge-info' };

                    row.find('.order-status-badge-'   + id).html('<span class="badge ' + (osBadge[res.order_status]  || 'badge-secondary') + ' px-3 py-2">' + res.order_status  + '</span>');
                    row.find('.payment-status-badge-' + id).html('<span class="badge ' + (psBadge[res.payment_status] || 'badge-secondary') + ' px-3 py-2">' + res.payment_status + '</span>');

                    row.attr('data-os', res.order_status).data('os', res.order_status);
                    row.attr('data-ps', res.payment_status).data('ps', res.payment_status);

                    var isNowLocked = res.order_status === 'DELIVERED' && res.payment_status === 'PAID';

                    if (isNowLocked) {
                        row.addClass('row-locked');
                        row.find('.view-mode').removeClass('d-none');
                        row.find('.edit-mode').addClass('d-none');
                        /* hide save/discard, replace only edit with lock icon — saveBtn stays in DOM for .always() */
                        row.find('.order-save-btn, .order-discard-btn').addClass('d-none');
                        row.find('.order-edit-btn').replaceWith(
                            '<button type="button" class="action-btn" title="Order complete — locked" disabled style="cursor:default;opacity:.55;">' +
                            '<i class="fas fa-lock" style="color:#6c757d;"></i></button>'
                        );
                        row.find('.view-order-btn').removeClass('d-none');
                        Swal.fire({
                            icon: 'success',
                            title: 'Order Complete!',
                            html: '<span style="color:#28a745;font-weight:600;">DELIVERED & PAID</span> — this order is now locked.',
                            timer: 2200,
                            showConfirmButton: false
                        });
                    } else {
                        row.find('.view-mode').removeClass('d-none');
                        row.find('.edit-mode').addClass('d-none');
                        row.find('.order-edit-btn, .view-order-btn').removeClass('d-none');
                        row.find('.order-save-btn, .order-discard-btn').addClass('d-none');
                        Swal.fire({ icon:'success', title:'Saved!', text:'Order status updated.', timer:1500, showConfirmButton:false });
                    }
                } catch (e) {
                    Swal.fire('Error', 'Unexpected error while updating UI.', 'error');
                }
            })
            .fail(function (xhr) {
                try {
                    var msg = 'Failed to update. (HTTP ' + xhr.status + ')';
                    if (xhr.responseJSON) {
                        if (xhr.responseJSON.errors) {
                            /* .flat() is ES2019 — use concat for compatibility */
                            var lines = [];
                            $.each(xhr.responseJSON.errors, function(k, v) {
                                lines.push($.isArray(v) ? v[0] : v);
                            });
                            msg = lines.join('\n');
                        } else if (xhr.responseJSON.message) {
                            msg = xhr.responseJSON.message;
                        }
                    }
                    Swal.fire('Update Failed', msg, 'error');
                } catch (e) {
                    Swal.fire('Update Failed', 'HTTP ' + xhr.status, 'error');
                }
            })
            .always(function () {
                /* guaranteed to run even if .done() throws — restores the save button */
                saveBtn.prop('disabled', false)
                       .html('<i class="fas fa-check" style="color:darkgreen;font-size:13px;"></i>');
            });
        });

        /* ════════════════════════════════════════════════════════
           🧾 INVOICE MODAL — Main Table
        ════════════════════════════════════════════════════════ */
        // Toggle A4 / POS preview when radio changes
        $(document).on('change', 'input[name="printFormat"]', function () {
            if ($(this).val() === 'pos') {
                $('#invoiceContent').hide();
                $('#posInvoiceContent').show();
                $('#posOptions').css('display', 'flex');
            } else {
                $('#invoiceContent').show();
                $('#posInvoiceContent').hide();
                $('#posOptions').hide();
            }
        });

        $(document).on('click', '.view-order-btn', function () {
            var id = $(this).data('id');
            // Reset to A4 view
            $('#invoiceActionBar').addClass('d-none');
            $('#posInvoiceContent').hide();
            $('#posOptions').hide();
            $('#invoiceContent').show().html(
                '<div style="text-align:center;padding:60px 0;">' +
                '<div class="spinner-border text-primary" role="status"></div>' +
                '<p class="mt-3 text-muted">Loading invoice...</p></div>'
            );
            $('input[name="printFormat"][value="a4"]').prop('checked', true);
            $('input[name="posSize"][value="80"]').prop('checked', true);
            $('#posHotline2').val('');
            $('#posNoteNB').val('');
            _posOrder = null; _posExt = {};
            $('#orderViewModal').modal('show');

            $.get(BASE_URL + '/' + id).done(function (res) {
                if (!res.success) { $('#invoiceContent').html('<div class="alert alert-danger m-3">Order not found.</div>'); return; }

                var o = res.order, rows = '', sub = 0, totalDiscount = 0, totalVat = 0;
                o.order_items.forEach(function (item, i) {
                    var pp = parseFloat(item.package_price || 0);
                    var qs = parseInt(item.qty_sets || 1);
                    var mo = parseInt(item.min_order || 1);
                    var lt = parseFloat(item.line_total || 0); sub += lt;
                    var ppp = mo > 0 ? pp / mo : pp;
                    var da = parseFloat(item.discount_amount || 0);
                    var va = parseFloat(item.vat_amount || 0);
                    totalDiscount += da * qs;
                    totalVat      += va;
                    rows += '<tr style="background:' + (i%2===0?'#fff':'#f7f9fc') + ';">' +
                        '<td style="border:1px solid #dee2e6;padding:10px;text-align:center;">' + (i+1) + '</td>' +
                        '<td style="border:1px solid #dee2e6;padding:10px;">' + (item.product ? item.product.name : '-') + '</td>' +
                        '<td style="border:1px solid #dee2e6;padding:10px;text-align:center;">' + mo + '</td>' +
                        '<td style="border:1px solid #dee2e6;padding:10px;text-align:right;">৳ ' + ppp.toLocaleString('en-BD',{minimumFractionDigits:2}) + '</td>' +
                        '<td style="border:1px solid #dee2e6;padding:10px;text-align:right;">' + (da > 0 ? '− ৳ ' + da.toLocaleString('en-BD',{minimumFractionDigits:2}) : '৳ 0.00') + '</td>' +
                        '<td style="border:1px solid #dee2e6;padding:10px;text-align:right;">৳ ' + pp.toLocaleString('en-BD',{minimumFractionDigits:2}) + '</td>' +
                        '<td style="border:1px solid #dee2e6;padding:10px;text-align:center;">' + qs + '</td>' +
                        '<td style="border:1px solid #dee2e6;padding:10px;text-align:right;">৳ ' + lt.toLocaleString('en-BD',{minimumFractionDigits:2}) + '</td>' +
                        '</tr>';
                });

                var ship = parseFloat(o.shipping_amount||0);
                var tax  = totalVat;
                var net  = sub - totalDiscount + ship + tax;
                var addr = o.order_address || {};
                var cn   = [addr.first_name,addr.last_name].filter(Boolean).join(' ') || 'N/A';
                var pbg  = o.payment_status === 'PAID' ? '#28a745' : '#ffc107';
                var ptx  = o.payment_status === 'PAID' ? '#fff'    : '#000';

                $('#invoiceContent').html(
                    '<div style="background:#fff;color:#222;font-family:\'Segoe UI\',sans-serif;font-size:14px;">' +
                    '<div style="text-align:center;border-bottom:3px solid #a9d0e1;padding-bottom:20px;margin-bottom:30px;">' +
                      '<div style="font-size:15px;font-weight:600;color:#444;line-height:26px;">Government of the People\'s Republic of Bangladesh<br>National Board of Revenue</div>' +
                      '<div style="font-size:32px;font-weight:800;color:#a9d0e1;letter-spacing:1px;margin-top:10px;">APON PLASTIC INDUSTRIES</div>' +
                      '<div style="margin-top:6px;font-size:13px;line-height:24px;color:#555;">Office &amp; Factory: Rupshi, Rupganj, Narayanganj.<br>Hotline: <a href="tel:+8801330473873" style="color:#a9d0e1;text-decoration:none;">(+880)1330-473873</a></div>' +
                      '<div style="margin-top:14px;font-size:20px;font-weight:700;letter-spacing:3px;color:#444;">RETAIL INVOICE</div>' +
                    '</div>' +
                    '<div style="display:flex;gap:20px;margin-bottom:30px;align-items:stretch;">' +
                      '<div style="flex:1;min-width:0;"><div style="background:#f8f9fa;border:1px solid #dce0e4;border-radius:10px;padding:18px;height:100%;">' +
                        '<div style="background:#a9d0e1;color:#0d3b66;padding:8px 14px;border-radius:4px;font-weight:700;margin-bottom:12px;font-size:13px;">CUSTOMER INFORMATION</div>' +
                        '<p style="margin:0 0 7px;"><strong>Name:</strong> ' + cn + '</p>' +
                        '<p style="margin:0 0 7px;"><strong>Phone:</strong> ' + (addr.phone||'N/A') + '</p>' +
                        '<p style="margin:0 0 7px;"><strong>Email:</strong> ' + (addr.email||'N/A') + '</p>' +
                        '<p style="margin:0;"><strong>Address:</strong> ' + (addr.address_line1||'N/A') + '</p>' +
                      '</div></div>' +
                      '<div style="flex:1;min-width:0;"><div style="background:#f8f9fa;border:1px solid #dce0e4;border-radius:10px;padding:18px;height:100%;">' +
                        '<div style="background:#a9d0e1;color:#0d3b66;padding:8px 14px;border-radius:4px;font-weight:700;margin-bottom:12px;font-size:13px;">INVOICE INFORMATION</div>' +
                        '<p style="margin:0 0 7px;"><strong>Order ID:</strong> ' + o.order_number + '</p>' +
                        '<p style="margin:0 0 7px;"><strong>Date:</strong> ' + new Date(o.created_at).toLocaleString('en-BD') + '</p>' +
                        '<p style="margin:0 0 7px;"><strong>Transaction ID:</strong> ' + (o.transaction_id||'N/A') + '</p>' +
                        '<p style="margin:0 0 7px;"><strong>Accepted By:</strong> ' + (o.accepted_by_name || 'N/A') + '</p>' +
                        '<p style="margin:0 0 7px;"><strong>Payment Method:</strong> ' + o.payment_method + '</p>' +
                        (o.payment_method !== 'CASH'
                            ? '<p style="margin:0 0 7px;"><strong>Payer No:</strong> ' + (o.payer_number || 'N/A') + '</p>'
                            : '') +
                        '<p style="margin:0;"><strong>Payment Status:</strong> <span style="background:' + pbg + ';color:' + ptx + ';padding:3px 12px;border-radius:4px;font-size:12px;font-weight:600;">' + o.payment_status + '</span></p>' +
                      '</div></div>' +
                    '</div>' +
                    '<table style="width:100%;border-collapse:collapse;margin-top:10px;">' +
                    '<thead><tr style="background:#a9d0e1;">' +
                      '<th style="color:#0d3b66;border:1px solid #a9d0e1;padding:10px;text-align:center;width:4%;">SL</th>' +
                      '<th style="color:#0d3b66;border:1px solid #a9d0e1;padding:10px;text-align:left;">Product</th>' +
                      '<th style="color:#0d3b66;border:1px solid #a9d0e1;padding:10px;text-align:center;width:10%;">Min Qty/Per</th>' +
                      '<th style="color:#0d3b66;border:1px solid #a9d0e1;padding:10px;text-align:right;width:12%;">Single Piece Price</th>' +
                      '<th style="color:#0d3b66;border:1px solid #a9d0e1;padding:10px;text-align:right;width:11%;">Discount (−)</th>' +
                      '<th style="color:#0d3b66;border:1px solid #a9d0e1;padding:10px;text-align:right;width:12%;">Package Price</th>' +
                      '<th style="color:#0d3b66;border:1px solid #a9d0e1;padding:10px;text-align:center;width:7%;">Qty</th>' +
                      '<th style="color:#0d3b66;border:1px solid #a9d0e1;padding:10px;text-align:right;width:12%;">Total</th>' +
                    '</tr></thead><tbody>' + rows + '</tbody></table>' +
                    '<table style="width:50%;border-collapse:collapse;margin-top:20px;margin-left:auto;">' +
                      '<tr><td style="border:1px solid #dee2e6;padding:10px;background:#f8f9fa;">Sub Total</td><td style="border:1px solid #dee2e6;padding:10px;text-align:right;">৳ ' + sub.toLocaleString('en-BD',{minimumFractionDigits:2}) + '</td></tr>' +
                      '<tr><td style="border:1px solid #dee2e6;padding:10px;background:#f8f9fa;">Discount (−)</td><td style="border:1px solid #dee2e6;padding:10px;text-align:right;' + (totalDiscount > 0 ? 'color:#dc3545;font-weight:600;' : '') + '">' + (totalDiscount > 0 ? '− ৳ ' + totalDiscount.toLocaleString('en-BD',{minimumFractionDigits:2}) : '৳ 0.00') + '</td></tr>' +
                      '<tr><td style="border:1px solid #dee2e6;padding:10px;background:#f8f9fa;">Shipping</td><td style="border:1px solid #dee2e6;padding:10px;text-align:right;">৳ ' + ship.toLocaleString('en-BD',{minimumFractionDigits:2}) + '</td></tr>' +
                      '<tr><td style="border:1px solid #dee2e6;padding:10px;background:#f8f9fa;">VAT</td><td style="border:1px solid #dee2e6;padding:10px;text-align:right;">৳ ' + tax.toLocaleString('en-BD',{minimumFractionDigits:2}) + '</td></tr>' +
                      '<tr><td style="background:#a9d0e1;color:#0d3b66;font-weight:700;padding:12px;font-size:15px;border:1px solid #a9d0e1;">NET PAYABLE</td><td style="background:#a9d0e1;color:#0d3b66;font-weight:700;padding:12px;text-align:right;font-size:15px;border:1px solid #a9d0e1;">৳ ' + net.toLocaleString('en-BD',{minimumFractionDigits:2}) + '<span style="display:block;font-size:11px;font-weight:600;color:#0d3b66;margin-top:2px;">(' + numberToWords(net) + ' BDT Only)</span></td></tr>' +
                    '</table>' +
                    '<div style="display:flex;margin-top:50px;">' +
                      '<div style="flex:1;text-align:center;">' +
                        '<div style="width:200px;margin:40px auto 8px;border-top:2px solid #000;"></div>' +
                        '<small style="color:#555;">Customer Signature</small>' +
                      '</div>' +
                      '<div style="flex:1;text-align:center;">' +
                        '<div style="width:200px;margin:40px auto 8px;border-top:2px solid #000;"></div>' +
                        '<small style="color:#555;">Authorized Signature</small>' +
                      '</div>' +
                    '</div>' +
                    '<div style="text-align:center;margin-top:18px;font-size:12px;color:#777;font-style:italic;">' +
                      'This is a software generated invoice. Therefore, no signature is required.' +
                    '</div>' +
                    '<div style="text-align:center;margin-top:26px;padding-top:12px;border-top:1px solid #e5e7eb;font-size:12px;color:#777;">' +
                      'Design, Developed &amp; Managed by ' +
                      '<a href="https://versedsoft.com/" target="_blank" rel="noopener" style="color:#0d6efd;font-weight:600;text-decoration:none;">' +
                        'Versedsoft &mdash; Your Complication, Our Solutions' +
                      '</a>' +
                      '<div style="margin-top:4px;">+8801723821264 (WhatsApp)</div>' +
                    '</div>' +
                    '</div>'
                );
                $('#invoiceActionBar').removeClass('d-none');

                // ── Store order data for POS receipt builder ──────────
                _posOrder = o;
                _posExt   = { sub: sub, totalDiscount: totalDiscount, ship: ship, tax: tax, net: net, cn: cn, addr: addr };
                buildPosReceipt();
                // ──────────────────────────────────────────────────────

            }).fail(function (xhr) {
                $('#invoiceContent').html('<div class="alert alert-danger m-3">Error ' + xhr.status + '. Failed to load.</div>');
            });
        });

    });

    function numberToWords(num) {
        num = Math.floor(num); if (num === 0) return 'Zero';
        var a = ['','One','Two','Three','Four','Five','Six','Seven','Eight','Nine','Ten','Eleven','Twelve','Thirteen','Fourteen','Fifteen','Sixteen','Seventeen','Eighteen','Nineteen'];
        var b = ['','','Twenty','Thirty','Forty','Fifty','Sixty','Seventy','Eighty','Ninety'];
        function two(n) { return n < 20 ? a[n] : b[Math.floor(n/10)] + (n%10 ? ' ' + a[n%10] : ''); }
        function three(n) { return (n >= 100 ? a[Math.floor(n/100)] + ' Hundred' + (n%100 ? ' ' : '') : '') + (n%100 ? two(n%100) : ''); }
        var s = '', cr = Math.floor(num/10000000); num %= 10000000;
        var lk = Math.floor(num/100000); num %= 100000;
        var th = Math.floor(num/1000); num %= 1000;
        if (cr) s += three(cr) + ' Crore ';
        if (lk) s += two(lk) + ' Lakh ';
        if (th) s += two(th) + ' Thousand ';
        if (num) s += three(num);
        return s.trim();
    }

    function printInvoice() {
        var invoice = document.getElementById('invoiceContent');
        if (!invoice) return;

        var clone = invoice.cloneNode(true);
        clone.querySelectorAll('.no-print').forEach(function (el) { el.remove(); });

        var headStyles = '';
        document.querySelectorAll('link[rel="stylesheet"], style').forEach(function (node) {
            headStyles += node.outerHTML;
        });

        var printCss =
            '<style>' +
                '@page { size: A4; margin: 10mm; }' +
                '* { -webkit-print-color-adjust: exact !important; print-color-adjust: exact !important; }' +
                'body { margin: 0; padding: 20px; background: #fff; }' +
                '.no-print { display: none !important; }' +
                '@media print {' +
                    'html, body { height: auto; }' +
                    '#invoiceContent { page-break-inside: avoid; }' +
                    '#invoiceContent * { page-break-inside: avoid; }' +
                    '#invoiceContent [style*="display:flex"] { display:flex !important; flex-wrap:nowrap !important; }' +
                    '#invoiceContent [style*="margin-top:50px"] { margin-top: 24px !important; }' +
                    '#invoiceContent [style*="margin-bottom:30px"] { margin-bottom: 16px !important; }' +
                '}' +
            '</style>';

        var w = window.open('', 'PRINT', 'width=900,height=700');
        w.document.open();
        w.document.write(
            '<!DOCTYPE html><html><head><meta charset="utf-8"><title>Invoice</title>' +
            headStyles + printCss +
            '</head><body>' + clone.outerHTML + '</body></html>'
        );
        w.document.close();

        var doc = w.document;
        var el = doc.getElementById('invoiceContent') || doc.body.firstElementChild;
        var pageH = 1122;
        if (el && el.scrollHeight > pageH) {
            var scale = pageH / el.scrollHeight;
            el.style.transformOrigin = 'top left';
            el.style.transform = 'scale(' + scale + ')';
            el.style.width = (100 / scale) + '%';
        }

        var printFired = false;
        w.onload = function () {
            if (printFired) return;
            printFired = true;
            setTimeout(function () { w.focus(); w.print(); w.close(); }, 300);
        };
        setTimeout(function () {
            if (printFired) return;
            printFired = true;
            try { w.focus(); w.print(); } catch (e) {}
        }, 700);
    }

    function printSelected() {
        var fmt = document.querySelector('input[name="printFormat"]:checked');
        if (fmt && fmt.value === 'pos') { printPosInvoice(); } else { printInvoice(); }
    }

    function getPosSize() {
        var el = document.querySelector('input[name="posSize"]:checked');
        return el ? parseInt(el.value) : 80;
    }

    function buildPosReceipt() {
        if (!_posOrder) return;
        var o   = _posOrder;
        var ext = _posExt;
        var hotline2 = (document.getElementById('posHotline2') || {}).value || '';
        var nbNote   = (document.getElementById('posNoteNB') || {}).value || '';
        var invNo      = 'INV-' + String(o.id || '').padStart(5, '0');
        var posDate    = new Date(o.created_at);
        var posDateStr = posDate.getDate() + '-' +
            posDate.toLocaleString('en-US', {month:'short'}) + '-' +
            posDate.getFullYear() + ' ' +
            posDate.toLocaleTimeString('en-US', {hour:'2-digit',minute:'2-digit',hour12:true}).toLowerCase();
        var posRows = '';
        o.order_items.forEach(function (item, idx) {
            var pp    = parseFloat(item.package_price || 0);
            var qs    = parseInt(item.qty_sets || 1);
            var lt    = parseFloat(item.line_total || 0);
            var pname = item.product ? item.product.name : '-';
            posRows += '<tr><td>' + (idx+1) + '</td><td>' + pname + '</td><td>' + qs +
                       '</td><td>' + pp.toFixed(2) + '</td><td>' + lt.toFixed(2) + '</td></tr>';
        });
        document.getElementById('posInvoiceContent').innerHTML =
            '<div class="pos-receipt">' +
            '<div class="pos-center pos-bold" style="font-size:13px;">APON PLASTIC INDUSTRIES</div>' +
            '<div class="pos-center pos-sm">Office &amp; Factory: Rupshi, Rupganj,</div>' +
            '<div class="pos-center pos-sm">Narayanganj</div>' +
            '<div class="pos-center pos-sm">Hotline: (+880)1330-473873</div>' +
            (hotline2 ? '<div class="pos-center pos-sm">Hotline 2: ' + hotline2 + '</div>' : '') +
            '<div class="pos-hr"></div>' +
            '<div class="pos-center pos-bold">SALES INVOICE</div>' +
            '<div class="pos-hr"></div>' +
            '<div class="pos-row"><span>Date</span><span>' + posDateStr + '</span></div>' +
            '<div class="pos-row"><span>Invoice No</span><span>' + invNo + '</span></div>' +
            '<div class="pos-row"><span>Order ID</span><span>' + o.order_number + '</span></div>' +
            '<div class="pos-row"><span>Customer</span><span>' + ext.cn + '</span></div>' +
            '<div class="pos-row"><span>Phone</span><span>' + (ext.addr.phone || 'N/A') + '</span></div>' +
            (ext.addr.address_line1 ? '<div class="pos-row"><span>Address</span><span style="text-align:right;max-width:60%;">' + ext.addr.address_line1 + '</span></div>' : '') +
            (ext.addr.thana ? '<div class="pos-row"><span>Thana</span><span>' + ext.addr.thana + '</span></div>' : '') +
            (ext.addr.district ? '<div class="pos-row"><span>District</span><span>' + ext.addr.district + '</span></div>' : '') +
            '<div class="pos-row"><span>Transaction ID</span><span>' + (o.transaction_id || 'N/A') + '</span></div>' +
            '<div class="pos-row"><span>Accepted By</span><span>' + (o.accepted_by_name || 'N/A') + '</span></div>' +
            '<div class="pos-hr"></div>' +
            '<table class="pos-items"><thead><tr><th>SL</th><th>PRODUCT</th><th>Qty</th><th>Rate</th><th>Amt</th></tr></thead>' +
            '<tbody>' + posRows + '</tbody></table>' +
            '<div class="pos-hr"></div>' +
            '<div class="pos-row"><span>Sub Total BDT</span><span>' + ext.sub.toFixed(2) + '</span></div>' +
            '<div class="pos-row"><span>Bill Discount BDT</span><span>-' + ext.totalDiscount.toFixed(2) + '</span></div>' +
            '<div class="pos-row"><span>VAT</span><span>' + ext.tax.toFixed(2) + '</span></div>' +
            '<div class="pos-row"><span>Shipping BDT</span><span>' + ext.ship.toFixed(2) + '</span></div>' +
            '<div class="pos-row pos-bold"><span>Net Amount BDT</span><span>' + ext.net.toFixed(2) + '</span></div>' +
            '<div class="pos-hr"></div>' +
            '<div class="pos-sm">In Words: <b>' + numberToWords(ext.net) + ' BDT Only</b></div>' +
            '<div class="pos-hr"></div>' +
            (nbNote ? '<div class="pos-sm"><b>NB:</b> ' + nbNote + '</div><div class="pos-hr"></div>' : '') +
            '<div class="pos-row"><span>Payment Type</span><span>' + o.payment_method + '</span></div>' +
            '<div class="pos-row"><span>Status</span><span>' + o.payment_status + '</span></div>' +
            '<div class="pos-hr pos-double"></div>' +
            '<div class="pos-center pos-sm">This is an software generated invoice.</div>' +
            '<div class="pos-center pos-sm">No signature is required.</div>' +
            '<div class="pos-center pos-sm" style="margin-top:6px;">Software Design, Developed &amp; Managed by</div>' +
            '<div class="pos-center pos-sm">Versedsoft — Your Complication,</div>' +
            '<div class="pos-center pos-sm">Our Solutions</div>' +
            '<div class="pos-center pos-sm">+8801723821264 (Whatsapp)</div>' +
            '</div>';
    }

    function printPosInvoice() {
        buildPosReceipt();
        var receipt = document.querySelector('#posInvoiceContent .pos-receipt');
        if (!receipt) { alert('Please open an order invoice first.'); return; }
        var size = getPosSize();
        var posCSS =
            '.pos-receipt{width:' + size + 'mm;max-width:' + size + 'mm;margin:0 auto;padding:6px 8px;font-family:"Courier New",monospace;font-size:12px;line-height:1.5;color:#000;background:#fff;}' +
            '.pos-center{text-align:center;}' +
            '.pos-bold{font-weight:700;}' +
            '.pos-sm{font-size:11px;}' +
            '.pos-hr{border-top:1px dashed #000;margin:6px 0;}' +
            '.pos-hr.pos-double{border-top:2px solid #000;}' +
            '.pos-row{display:flex;justify-content:space-between;gap:8px;}' +
            '.pos-items{width:100%;border-collapse:collapse;font-size:11px;table-layout:fixed;}' +
            '.pos-items th,.pos-items td{text-align:left;padding:2px 4px;word-break:break-word;}' +
            '.pos-items th:nth-child(1),.pos-items td:nth-child(1){width:10%;}' +
            '.pos-items th:nth-child(2),.pos-items td:nth-child(2){width:40%;}' +
            '.pos-items th:nth-child(3),.pos-items td:nth-child(3){width:10%;text-align:right;}' +
            '.pos-items th:nth-child(4),.pos-items td:nth-child(4){width:20%;text-align:right;}' +
            '.pos-items th:nth-child(5),.pos-items td:nth-child(5){width:20%;text-align:right;}';
        var winW = size === 58 ? 320 : 420;
        var w = window.open('', '', 'width=' + winW + ',height=700');
        if (!w) { alert('Popup blocked! Please allow popups for this page and try again.'); return; }
        w.document.open();
        w.document.write(
            '<!DOCTYPE html><html><head><meta charset="utf-8"><title>POS Invoice</title>' +
            '<style>@page{size:' + size + 'mm auto;margin:0;}body{margin:0;background:#fff;}' + posCSS + '</style>' +
            '</head><body>' + receipt.outerHTML + '</body></html>'
        );
        w.document.close();

        var printFired = false;
        w.onload = function () {
            if (printFired) return;
            printFired = true;
            setTimeout(function () { w.focus(); w.print(); w.close(); }, 200);
        };
        setTimeout(function () {
            if (printFired) return;
            printFired = true;
            try { w.focus(); w.print(); } catch (e) {}
        }, 900);
    }

    function downloadSelected() {
        var fmt = document.querySelector('input[name="printFormat"]:checked');
        if (fmt && fmt.value === 'pos') { downloadPosInvoice(); } else { downloadInvoice(); }
    }

    function downloadInvoice() {
        var el = document.getElementById('invoiceContent');
        if (!el) return;
        var clone = el.cloneNode(true);
        clone.querySelectorAll('.no-print').forEach(function (n) { n.remove(); });
        html2pdf().set({
            margin: 10,
            filename: 'invoice.pdf',
            image: { type: 'jpeg', quality: 0.98 },
            html2canvas: { scale: 2, useCORS: true },
            jsPDF: { unit: 'mm', format: 'a4', orientation: 'portrait' },
            pagebreak: { mode: ['avoid-all'] }
        }).from(clone).save();
    }

    function downloadPosInvoice() {
        buildPosReceipt();
        var receipt = document.querySelector('#posInvoiceContent .pos-receipt');
        if (!receipt) return;
        var size    = getPosSize();
        var heightMm = Math.ceil(receipt.scrollHeight * 25.4 / 96) + 8;

        html2pdf().set({
            margin: 0,
            filename: 'pos-invoice.pdf',
            image: { type: 'jpeg', quality: 0.98 },
            html2canvas: { scale: 2, useCORS: true, logging: false },
            jsPDF: { unit: 'mm', format: [size, heightMm], orientation: 'portrait' },
            pagebreak: { mode: [] }
        }).from(receipt).save();
    }

    /* ── Apply Delivery Zone (inline in order table edit row) ── */
    $(document).ready(function () {
        var CSRF     = '{{ csrf_token() }}';
        var BASE_URL = '{{ url("admin/orders") }}';

        var zoneLabels = {
            dhaka_city:             'In Dhaka City',
            outside_dhaka_city:     'Outside Dhaka City',
            outside_dhaka_district: 'Outside Dhaka District',
            free:                   'Free Shipping'
        };

        $(document).on('click', '.delivery-zone-btn', function () {
            var id   = $(this).data('id');
            var zone = $(this).closest('td').find('.delivery-zone-select').val();
            var btn  = $(this);
            btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i>');

            $.post(BASE_URL + '/' + id + '/delivery', { _token: CSRF, zone: zone })
                .done(function (res) {
                    if (!res.success) { Swal.fire('Error', 'Could not update delivery zone.', 'error'); return; }
                    var fmt   = { minimumFractionDigits: 2 };
                    var label = zoneLabels[zone] || zone;
                    $('.order-total-' + id).text('৳ ' + parseFloat(res.total_amount).toLocaleString('en-BD', fmt));
                    Swal.fire({
                        icon: 'success', title: 'Zone updated!',
                        html: '<b>' + label + '</b><br>' +
                              'Delivery: ৳' + parseFloat(res.shipping_amount).toLocaleString('en-BD', fmt) +
                              ' &nbsp;|&nbsp; Total: ৳' + parseFloat(res.total_amount).toLocaleString('en-BD', fmt),
                        timer: 2500, showConfirmButton: false
                    });
                })
                .fail(function () { Swal.fire('Error', 'Failed to update delivery zone.', 'error'); })
                .always(function () { btn.prop('disabled', false).html('<i class="fas fa-truck mr-1"></i> Apply Zone'); });
        });
    });
    </script>

    {{-- ════ ADD ORDER MODAL JS ════ --}}
    <script>
    (function () {
        var AO_CSRF      = '{{ csrf_token() }}';
        var AO_SEARCH    = '{{ route("admin.orders.product.search") }}';
        var AO_STORE     = '{{ route("admin.orders.store.manual") }}';
        var FREE_THRESH  = 1000;
        var INSIDE_FEE   = 100;
        var OUTSIDE_FEE  = 150;

        /* item storage: product_id → { name, price, qty } */
        var aoItems = {};

        /* ── helpers ── */
        function fmt(n) {
            return '৳ ' + parseFloat(n).toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ',');
        }

        function recompute() {
            var subtotal = 0;
            Object.values(aoItems).forEach(function (it) { subtotal += it.price * it.qty; });

            var zone = document.querySelector('input[name="ao_zone"]:checked');
            var zoneVal = zone ? zone.value : 'inside';
            var delivery = 0;
            if (zoneVal !== 'pickup') {
                delivery = subtotal > FREE_THRESH ? 0 : (zoneVal === 'inside' ? INSIDE_FEE : OUTSIDE_FEE);
            }
            var total = subtotal + delivery;

            $('#ao_subtotal_display').text(fmt(subtotal));
            $('#ao_delivery_display').text(fmt(delivery));
            $('#ao_total_display').text(fmt(total));
        }

        function renderItems() {
            var $body = $('#ao_items_body');
            $body.empty();
            var keys = Object.keys(aoItems);
            if (keys.length === 0) {
                $body.html('<tr id="ao_empty_row"><td colspan="5" class="text-center text-muted py-3">No products added yet. Search above.</td></tr>');
            } else {
                keys.forEach(function (pid) {
                    var it = aoItems[pid];
                    var lineTotal = it.price * it.qty;
                    $body.append(
                        '<tr data-pid="' + pid + '">' +
                        '<td><span class="font-weight-bold" style="font-size:12px;">' + $('<div>').text(it.name).html() + '</span>' +
                        '<br><small class="text-muted">' + $('<div>').text(it.sku).html() + '</small></td>' +
                        '<td class="text-right" style="font-size:12px;">৳' + parseFloat(it.price).toFixed(2) + '</td>' +
                        '<td class="text-center"><input type="number" class="form-control form-control-sm ao-qty-input text-center" data-pid="' + pid + '" value="' + it.qty + '" min="1" style="width:60px;margin:0 auto;"></td>' +
                        '<td class="text-right font-weight-bold" style="font-size:12px;" id="ao_line_' + pid + '">৳' + lineTotal.toFixed(2) + '</td>' +
                        '<td class="text-center"><button type="button" class="btn btn-sm btn-outline-danger ao-remove-btn py-0 px-1" data-pid="' + pid + '" style="line-height:1.4;"><i class="fas fa-times"></i></button></td>' +
                        '</tr>'
                    );
                });
            }
            recompute();
        }

        /* ── Product search ── */
        var searchTimer;
        $(document).on('input', '#ao_product_search', function () {
            var q = $(this).val().trim();
            clearTimeout(searchTimer);
            if (q.length < 1) { $('#ao_product_dropdown').hide(); return; }
            searchTimer = setTimeout(function () {
                $.get(AO_SEARCH, { q: q, _token: AO_CSRF })
                    .done(function (res) {
                        var $dd = $('#ao_product_dropdown').empty();
                        if (!res.products || res.products.length === 0) {
                            $dd.html('<a class="list-group-item list-group-item-action disabled text-muted small py-2">No products found</a>').show();
                            return;
                        }
                        res.products.forEach(function (p) {
                            var stock = parseInt(p.stock_quantity) || 0;
                            var priceDisplay = parseFloat(p.package_price).toFixed(2);
                            var $item = $('<a class="list-group-item list-group-item-action py-2" style="cursor:pointer;font-size:13px;"></a>');
                            $item.html(
                                '<span class="font-weight-bold">' + $('<div>').text(p.name).html() + '</span>' +
                                ' <small class="text-muted">' + $('<div>').text(p.sku).html() + '</small>' +
                                '<span class="float-right">৳' + priceDisplay + ' <small class="text-muted ml-1">Stock: ' + stock + '</small></span>'
                            );
                            $item.on('click', function () {
                                var pid = String(p.id);
                                if (aoItems[pid]) {
                                    aoItems[pid].qty += 1;
                                } else {
                                    aoItems[pid] = { name: p.name, sku: p.sku, price: parseFloat(p.package_price), qty: 1, min_order: parseInt(p.minimum_order) || 1 };
                                }
                                renderItems();
                                $('#ao_product_search').val('');
                                $dd.hide();
                            });
                            $dd.append($item);
                        });
                        $dd.show();
                    });
            }, 250);
        });

        /* Close dropdown on outside click */
        $(document).on('click', function (e) {
            if (!$(e.target).closest('#ao_product_search, #ao_product_dropdown').length) {
                $('#ao_product_dropdown').hide();
            }
        });

        /* Qty change */
        $(document).on('change', '.ao-qty-input', function () {
            var pid = $(this).data('pid');
            var qty = parseInt($(this).val()) || 1;
            if (qty < 1) qty = 1;
            $(this).val(qty);
            if (aoItems[pid]) {
                aoItems[pid].qty = qty;
                $('#ao_line_' + pid).text('৳' + (aoItems[pid].price * qty).toFixed(2));
                recompute();
            }
        });

        /* Remove item */
        $(document).on('click', '.ao-remove-btn', function () {
            var pid = $(this).data('pid');
            delete aoItems[pid];
            renderItems();
        });

        /* Zone change → recompute */
        $(document).on('change', 'input[name="ao_zone"]', function () { recompute(); });

        /* Reset modal when closed */
        $('#addOrderModal').on('hidden.bs.modal', function () {
            aoItems = {};
            $('#ao_name,#ao_phone,#ao_email,#ao_address,#ao_thana,#ao_notes,#ao_product_search').val('');
            $('#ao_district').val('');
            $('#ao_payment_method').val('Cash');
            $('#ao_payment_status').val('PAID');
            $('#ao_order_status').val('PROCESSING');
            $('#ao_zone_inside').prop('checked', true);
            renderItems();
        });

        /* ── Submit ── */
        $(document).on('click', '#ao_submit_btn', function () {
            var name   = $('#ao_name').val().trim();
            var phone  = $('#ao_phone').val().trim();
            var dist   = $('#ao_district').val();

            if (!name)  { Swal.fire('Missing', 'Customer name is required.', 'warning'); return; }
            if (!phone) { Swal.fire('Missing', 'Phone number is required.', 'warning'); return; }
            if (Object.keys(aoItems).length === 0) { Swal.fire('Missing', 'Add at least one product.', 'warning'); return; }

            var items = Object.keys(aoItems).map(function (pid) {
                return { product_id: parseInt(pid), qty: aoItems[pid].qty };
            });

            var payload = {
                _token:         AO_CSRF,
                name:           name,
                phone:          phone,
                email:          $('#ao_email').val().trim(),
                address:        $('#ao_address').val().trim(),
                district:       dist,
                thana:          $('#ao_thana').val().trim(),
                items:          items,
                payment_method: $('#ao_payment_method').val(),
                payment_status: $('#ao_payment_status').val(),
                order_status:   $('#ao_order_status').val(),
                delivery_zone:  $('input[name="ao_zone"]:checked').val(),
                notes:          $('#ao_notes').val().trim(),
            };

            var $btn = $('#ao_submit_btn').prop('disabled', true)
                .html('<i class="fas fa-spinner fa-spin mr-1"></i> Placing…');

            $.ajax({
                url:         AO_STORE,
                type:        'POST',
                data:        JSON.stringify(payload),
                contentType: 'application/json',
                dataType:    'json',
            })
            .done(function (res) {
                if (res.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Order Placed!',
                        html: 'Order <strong>' + res.order_number + '</strong> created successfully.',
                        confirmButtonText: 'OK'
                    }).then(function () {
                        $('#addOrderModal').modal('hide');
                        location.reload();
                    });
                } else {
                    Swal.fire('Error', res.message || 'Could not place order.', 'error');
                }
            })
            .fail(function (xhr) {
                var msg = 'Server error.';
                try { var j = JSON.parse(xhr.responseText); msg = j.message || msg; } catch (e) {}
                Swal.fire('Error', msg, 'error');
            })
            .always(function () {
                $btn.prop('disabled', false).html('<i class="fas fa-check-circle mr-1"></i> Place Order');
            });
        });
    })();
    </script>
@endpush
