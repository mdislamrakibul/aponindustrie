@extends('layout.master')

@section('title', 'My Account')

@section('content')
<main class="profile-main" style="padding: 48px 0; min-height: 60vh; background: #f4f6f9;">
    <div class="container" style="max-width: 1200px; margin: 0 auto; padding: 0 20px;">

        <h2 style="font-size: 22px; font-weight: 700; margin-bottom: 28px; color: #222;">My Account</h2>

        <div class="row">

            {{-- LEFT: Profile Card --}}
            <div class="col-12 col-md-4 col-lg-3 mb-4">
                <div style="background: #fff; border-radius: 12px; overflow: hidden; box-shadow: 0 2px 12px rgba(0,0,0,.08);">
                    <div style="background: linear-gradient(135deg, #3BB77E, #2a9d60); padding: 28px 20px; text-align: center;">
                        <div style="width: 72px; height: 72px; border-radius: 50%; background: rgba(255,255,255,.25); display: flex; align-items: center; justify-content: center; margin: 0 auto 14px;">
                            <i class="fa fa-user" style="font-size: 30px; color: #fff;"></i>
                        </div>
                        <h5 style="margin: 0 0 4px; color: #fff; font-weight: 700; font-size: 16px;">
                            {{ $login->first_name }} {{ $login->last_name }}
                        </h5>
                        <small style="color: rgba(255,255,255,.8); text-transform: capitalize;">
                            {{ $login->role ?? 'Customer' }}
                        </small>
                    </div>
                    <div style="padding: 20px;">
                        <table style="width: 100%; font-size: 13px; border-collapse: collapse;">
                            <tr>
                                <td style="padding: 7px 0; color: #888; width: 40%;">Mobile</td>
                                <td style="padding: 7px 0; font-weight: 600; color: #333;">
                                    {{ $login->phone ?? 'N/A' }}
                                </td>
                            </tr>
                            <tr style="border-top: 1px solid #f0f0f0;">
                                <td style="padding: 7px 0; color: #888;">Status</td>
                                <td style="padding: 7px 0;">
                                    <span style="color: {{ ($login->status ?? 'active') === 'active' ? '#3BB77E' : '#dc3545' }}; font-weight: 600; text-transform: capitalize;">
                                        {{ $login->status ?? 'Active' }}
                                    </span>
                                </td>
                            </tr>
                            <tr style="border-top: 1px solid #f0f0f0;">
                                <td style="padding: 7px 0; color: #888;">Joined</td>
                                <td style="padding: 7px 0; font-weight: 600; color: #333;">
                                    {{ \Carbon\Carbon::parse($login->created_at)->format('d M Y') }}
                                </td>
                            </tr>
                        </table>

                        <form action="{{ route('logout') }}" method="POST" style="margin-top: 20px;">
                            @csrf
                            <button type="submit"
                                style="width: 100%; padding: 10px; background: #dc3545; color: #fff; border: none; border-radius: 8px; font-size: 13px; font-weight: 600; cursor: pointer; letter-spacing: .3px;">
                                <i class="fa fa-sign-out" style="margin-right: 6px;"></i> Log Out
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            {{-- RIGHT: Order History --}}
            <div class="col-12 col-md-8 col-lg-9">
                <div style="background: #fff; border-radius: 12px; overflow: hidden; box-shadow: 0 2px 12px rgba(0,0,0,.08);">
                    <div style="padding: 18px 22px; border-bottom: 1px solid #f0f0f0; display: flex; align-items: center; justify-content: space-between;">
                        <h5 style="margin: 0; font-weight: 700; font-size: 16px; color: #222;">Order History</h5>
                        <span style="background: #e8f5e9; color: #2e7d32; padding: 3px 12px; border-radius: 20px; font-size: 12px; font-weight: 700;">
                            {{ $orders->count() }} order{{ $orders->count() !== 1 ? 's' : '' }}
                        </span>
                    </div>
                    <div style="overflow-x: auto;">
                        <table style="width: 100%; border-collapse: collapse; font-size: 14px;">
                            <thead>
                                <tr style="background: #f8f9fa;">
                                    <th style="padding: 12px 16px; text-align: left; font-size: 11px; text-transform: uppercase; letter-spacing: .5px; color: #888; font-weight: 700; white-space: nowrap;">Order #</th>
                                    <th style="padding: 12px 16px; text-align: left; font-size: 11px; text-transform: uppercase; letter-spacing: .5px; color: #888; font-weight: 700; white-space: nowrap;">Date</th>
                                    <th style="padding: 12px 16px; text-align: center; font-size: 11px; text-transform: uppercase; letter-spacing: .5px; color: #888; font-weight: 700;">Items</th>
                                    <th style="padding: 12px 16px; text-align: right; font-size: 11px; text-transform: uppercase; letter-spacing: .5px; color: #888; font-weight: 700; white-space: nowrap;">Total</th>
                                    <th style="padding: 12px 16px; text-align: center; font-size: 11px; text-transform: uppercase; letter-spacing: .5px; color: #888; font-weight: 700;">Status</th>
                                    <th style="padding: 12px 16px; text-align: center; font-size: 11px; text-transform: uppercase; letter-spacing: .5px; color: #888; font-weight: 700;"></th>
                                </tr>
                            </thead>
                            <tbody>
                            @forelse($orders as $order)
                                @php
                                    $statusColors = [
                                        'PENDING'    => ['bg' => '#fff3cd', 'text' => '#856404'],
                                        'PROCESSING' => ['bg' => '#cce5ff', 'text' => '#004085'],
                                        'SHIPPED'    => ['bg' => '#d1ecf1', 'text' => '#0c5460'],
                                        'DELIVERED'  => ['bg' => '#d4edda', 'text' => '#155724'],
                                        'CANCELLED'  => ['bg' => '#f8d7da', 'text' => '#721c24'],
                                    ];
                                    $sc = $statusColors[$order->order_status] ?? ['bg' => '#e2e3e5', 'text' => '#383d41'];
                                @endphp
                                <tr style="border-top: 1px solid #f0f0f0;">
                                    <td style="padding: 14px 16px; white-space: nowrap;">
                                        <strong style="color: #3BB77E;">{{ $order->order_number }}</strong>
                                    </td>
                                    <td style="padding: 14px 16px; color: #555; white-space: nowrap;">
                                        {{ $order->created_at->format('d M Y') }}
                                    </td>
                                    <td style="padding: 14px 16px; text-align: center;">
                                        <span style="background: #e8f5e9; color: #2e7d32; padding: 2px 10px; border-radius: 20px; font-size: 12px; font-weight: 700;">
                                            {{ $order->order_items->count() }}
                                        </span>
                                    </td>
                                    <td style="padding: 14px 16px; text-align: right; font-weight: 700; color: #222; white-space: nowrap;">
                                        ৳{{ number_format($order->total_amount, 2) }}
                                    </td>
                                    <td style="padding: 14px 16px; text-align: center; white-space: nowrap;">
                                        <span style="background: {{ $sc['bg'] }}; color: {{ $sc['text'] }}; padding: 3px 10px; border-radius: 20px; font-size: 11px; font-weight: 700; text-transform: uppercase;">
                                            {{ $order->order_status }}
                                        </span>
                                    </td>
                                    <td style="padding: 14px 16px; text-align: center;">
                                        <button onclick="viewOrder({{ $order->id }})"
                                            style="background: #3BB77E; color: #fff; border: none; border-radius: 6px; padding: 5px 14px; font-size: 12px; font-weight: 600; cursor: pointer;">
                                            View
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" style="padding: 60px 20px; text-align: center; color: #aaa;">
                                        <i class="fa fa-shopping-bag" style="font-size: 40px; display: block; margin-bottom: 16px; color: #ddd;"></i>
                                        You have no orders yet.
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
</main>

{{-- ORDER SUMMARY MODAL --}}
<div id="orderModal"
     style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,.55); z-index: 9999; overflow-y: auto; padding: 30px 15px;">
    <div style="max-width: 700px; margin: 0 auto; background: #fff; border-radius: 14px; overflow: hidden; box-shadow: 0 20px 60px rgba(0,0,0,.3);">
        <div style="background: linear-gradient(135deg, #3BB77E, #2a9d60); color: #fff; padding: 18px 22px; display: flex; align-items: center; justify-content: space-between;">
            <span style="font-size: 15px; font-weight: 700;"><i class="fa fa-file-text-o" style="margin-right: 8px;"></i>Order Summary</span>
            <button onclick="closeModal()"
                    style="background: none; border: none; color: #fff; font-size: 22px; cursor: pointer; line-height: 1; padding: 0;">&times;</button>
        </div>
        <div id="orderModalBody" style="padding: 24px;">
            <div style="text-align: center; padding: 40px;">
                <i class="fa fa-spinner fa-spin" style="font-size: 32px; color: #3BB77E;"></i>
            </div>
        </div>
    </div>
</div>

<script>
function viewOrder(id) {
    var modal = document.getElementById('orderModal');
    var body  = document.getElementById('orderModalBody');
    modal.style.display = 'block';
    body.innerHTML = '<div style="text-align:center;padding:40px;"><i class="fa fa-spinner fa-spin" style="font-size:32px;color:#3BB77E;"></i><p style="margin-top:12px;color:#999;font-size:13px;">Loading…</p></div>';

    fetch('/my-account/order/' + id, { headers: { 'X-Requested-With': 'XMLHttpRequest' } })
        .then(function(r) { return r.json(); })
        .then(function(res) {
            if (!res.success) {
                body.innerHTML = '<p style="color:red;text-align:center;padding:30px;">Could not load order details.</p>';
                return;
            }
            var o    = res.order;
            var addr = o.order_address || {};
            var name = [addr.first_name, addr.last_name].filter(Boolean).join(' ') || 'N/A';

            var rows = '', subtotal = 0;
            (o.order_items || []).forEach(function(item, i) {
                var lineTotal = parseFloat(item.total || 0);
                subtotal += lineTotal;
                rows += '<tr style="background:' + (i % 2 === 0 ? '#fff' : '#f9fafb') + ';">'
                    + '<td style="padding:10px 12px;border:1px solid #e5e7eb;">'
                        + (item.product ? item.product.name : '<em style="color:#aaa;">Product removed</em>')
                    + '</td>'
                    + '<td style="padding:10px 12px;border:1px solid #e5e7eb;text-align:center;">'
                        + (item.quantity || 1)
                    + '</td>'
                    + '<td style="padding:10px 12px;border:1px solid #e5e7eb;text-align:right;white-space:nowrap;">'
                        + '৳' + lineTotal.toLocaleString('en-BD', { minimumFractionDigits: 2 })
                    + '</td>'
                    + '</tr>';
            });

            var ship  = parseFloat(o.shipping_amount || 0);
            var grand = subtotal + ship;

            var sColors = {
                PENDING:    { bg:'#fff3cd', text:'#856404' },
                PROCESSING: { bg:'#cce5ff', text:'#004085' },
                SHIPPED:    { bg:'#d1ecf1', text:'#0c5460' },
                DELIVERED:  { bg:'#d4edda', text:'#155724' },
                CANCELLED:  { bg:'#f8d7da', text:'#721c24' }
            };
            var pColors = { PAID:{ bg:'#d4edda', text:'#155724' }, PENDING:{ bg:'#fff3cd', text:'#856404' }, FAILED:{ bg:'#f8d7da', text:'#721c24' } };
            var sc = sColors[o.order_status]   || { bg:'#e2e3e5', text:'#383d41' };
            var pc = pColors[o.payment_status] || { bg:'#e2e3e5', text:'#383d41' };

            body.innerHTML =
                '<div style="display:grid;grid-template-columns:1fr 1fr;gap:14px;margin-bottom:20px;">'
                    + '<div style="background:#f8fffe;border:1px solid #d1fae5;border-radius:8px;padding:14px;">'
                        + '<div style="font-size:10px;font-weight:700;color:#3BB77E;margin-bottom:10px;text-transform:uppercase;letter-spacing:.8px;">Ship To</div>'
                        + '<div style="font-weight:600;font-size:14px;">' + name + '</div>'
                        + '<div style="color:#666;font-size:12px;margin-top:2px;">' + (addr.phone || '') + '</div>'
                        + '<div style="color:#666;font-size:12px;margin-top:2px;">' + (addr.address_line1 || '') + '</div>'
                        + '<div style="color:#666;font-size:12px;margin-top:2px;">' + (addr.email || '') + '</div>'
                    + '</div>'
                    + '<div style="background:#f8fffe;border:1px solid #d1fae5;border-radius:8px;padding:14px;">'
                        + '<div style="font-size:10px;font-weight:700;color:#3BB77E;margin-bottom:10px;text-transform:uppercase;letter-spacing:.8px;">Order Info</div>'
                        + '<div style="font-size:13px;margin-bottom:5px;"><strong>Order #:</strong> ' + o.order_number + '</div>'
                        + '<div style="font-size:13px;margin-bottom:5px;"><strong>Payment:</strong> ' + (o.payment_method || 'N/A') + '</div>'
                        + '<div style="font-size:13px;margin-bottom:5px;"><strong>Status:</strong> <span style="background:' + sc.bg + ';color:' + sc.text + ';padding:2px 8px;border-radius:20px;font-size:11px;font-weight:700;">' + o.order_status + '</span></div>'
                        + '<div style="font-size:13px;"><strong>Payment:</strong> <span style="background:' + pc.bg + ';color:' + pc.text + ';padding:2px 8px;border-radius:20px;font-size:11px;font-weight:700;">' + (o.payment_status || 'N/A') + '</span></div>'
                    + '</div>'
                + '</div>'
                + '<table style="width:100%;border-collapse:collapse;margin-bottom:6px;">'
                    + '<thead><tr style="background:#3BB77E;color:#fff;">'
                        + '<th style="padding:10px 12px;text-align:left;border:1px solid #3BB77E;">Product</th>'
                        + '<th style="padding:10px 12px;text-align:center;border:1px solid #3BB77E;width:70px;">Qty</th>'
                        + '<th style="padding:10px 12px;text-align:right;border:1px solid #3BB77E;width:110px;white-space:nowrap;">Amount</th>'
                    + '</tr></thead>'
                    + '<tbody>' + rows + '</tbody>'
                    + '<tfoot>'
                        + '<tr><td colspan="2" style="padding:9px 12px;text-align:right;border:1px solid #e5e7eb;background:#f9fafb;color:#555;">Subtotal</td>'
                            + '<td style="padding:9px 12px;text-align:right;border:1px solid #e5e7eb;background:#f9fafb;white-space:nowrap;">৳' + subtotal.toLocaleString('en-BD',{minimumFractionDigits:2}) + '</td></tr>'
                        + '<tr><td colspan="2" style="padding:9px 12px;text-align:right;border:1px solid #e5e7eb;background:#f9fafb;color:#555;">Shipping</td>'
                            + '<td style="padding:9px 12px;text-align:right;border:1px solid #e5e7eb;background:#f9fafb;white-space:nowrap;">৳' + ship.toLocaleString('en-BD',{minimumFractionDigits:2}) + '</td></tr>'
                        + '<tr><td colspan="2" style="padding:10px 12px;text-align:right;border:1px solid #2a9d60;background:#3BB77E;color:#fff;font-weight:700;">NET PAYABLE</td>'
                            + '<td style="padding:10px 12px;text-align:right;border:1px solid #2a9d60;background:#3BB77E;color:#fff;font-weight:700;white-space:nowrap;">৳' + grand.toLocaleString('en-BD',{minimumFractionDigits:2}) + '</td></tr>'
                    + '</tfoot>'
                + '</table>';
        })
        .catch(function() {
            body.innerHTML = '<p style="color:red;text-align:center;padding:30px;">Failed to load order. Please try again.</p>';
        });
}

function closeModal() {
    document.getElementById('orderModal').style.display = 'none';
}

document.getElementById('orderModal').addEventListener('click', function(e) {
    if (e.target === this) closeModal();
});
</script>
@endsection
