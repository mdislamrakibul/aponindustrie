<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderAddress;
use App\Models\OrderItems;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminOrderController extends Controller
{
    /**
     * Order Management List
     * Shows all orders that have been accepted (status != PENDING)
     */
    public function order_index()
    {
        $orders = Order::with(['order_items', 'order_items.product', 'order_address'])
            ->where('order_status', '!=', 'PENDING')
            ->orderByDesc('created_at')
            ->get()
            ->toArray();

        return view('admin.order_mgmt.index', ['orders' => $orders]);
    }

    /**
     * Get single order details — used by invoice & summary modals
     * GET /admin/orders/{id}
     */
    public function show($id)
    {
        $order = Order::with(['order_items', 'order_items.product', 'order_address', 'acceptedBy'])->find($id);

        if (!$order) {
            return response()->json(['success' => false, 'message' => 'Order not found'], 404);
        }

        $order->order_items->transform(function ($item) {
            $product             = $item->product;
            $minOrder            = ($product->minimum_order ?? 1) ?: 1;
            $item->package_price = (float) $item->price;
            $item->qty_sets      = $minOrder > 0 ? (int) round($item->quantity / $minOrder) : (int) $item->quantity;
            $item->min_order     = $minOrder;
            $item->line_total    = $item->package_price * $item->qty_sets;
            $item->regular_price = (float) ($product->regular_price ?? 0);

            $type  = strtoupper($product->discount_type ?? 'NONE');
            $value = (float) ($product->discount_value ?? 0);
            $discount = 0;
            if ($type === 'PERCENTAGE') {
                $discount = $item->package_price * ($value / 100);
            } elseif ($type === 'FLAT') {
                $discount = $value;
            }
            $item->discount_amount = round($discount, 2);

            $item->tax_percentage = (float) ($product->tax_percentage ?? 0);
            $lineDiscount         = $item->discount_amount * $item->qty_sets;
            $taxableBase          = max(0, $item->line_total - $lineDiscount);
            $item->vat_amount     = round($taxableBase * $item->tax_percentage / 100, 2);

            return $item;
        });

        $acceptedByUser = $order->acceptedBy;
        $order->accepted_by_name = ($acceptedByUser && in_array(strtolower($acceptedByUser->role ?? ''), ['admin', 'vendor', 'cashier']))
            ? trim(($acceptedByUser->first_name ?? '') . ' ' . ($acceptedByUser->last_name ?? ''))
            : null;

        return response()->json(['success' => true, 'order' => $order]);
    }

    /**
     * Full-page view of pending orders
     * GET /admin/orders/new
     */
    public function newOrdersPage()
    {
        $orders = Order::with(['order_items', 'order_items.product', 'order_address'])
            ->where('order_status', 'PENDING')
            ->orderByDesc('created_at')
            ->get()
            ->toArray();

        return view('admin.order_mgmt.new_orders', ['orders' => $orders]);
    }

    /**
     * New (unaccepted) orders JSON — used by sidebar badge counter
     * GET /admin/orders/new-orders
     */
    public function newOrders()
    {
        $orders = Order::with(['order_items', 'order_items.product', 'order_address'])
            ->where('order_status', 'PENDING')
            ->orderByDesc('created_at')
            ->get()
            ->map(function ($order) {
                return [
                    'id'             => $order->id,
                    'order_number'   => $order->order_number,
                    'total_amount'   => $order->total_amount,
                    'payment_method' => $order->payment_method,
                    'payment_status' => $order->payment_status,
                    'order_status'   => $order->order_status,
                    'created_at'     => $order->created_at,
                    'customer_name'  => $order->order_address
                        ? trim(($order->order_address->first_name ?? '') . ' ' . ($order->order_address->last_name ?? ''))
                        : 'N/A',
                    'customer_phone' => $order->order_address->phone ?? 'N/A',
                    'item_count'     => $order->order_items->count(),
                ];
            });

        return response()->json([
            'success' => true,
            'count'   => $orders->count(),
            'orders'  => $orders,
        ]);
    }

    /**
     * Accept a new order → moves it to the management table
     * POST /admin/orders/{id}/accept
     */
    public function acceptOrder($id)
    {
        $order = Order::with(['order_items', 'order_items.product', 'order_address'])->find($id);

        if (!$order) {
            return response()->json(['success' => false, 'message' => 'Order not found'], 404);
        }

        $order->update([
            'order_status' => 'PROCESSING',
            'accepted_by'  => session('user_id'),
        ]);
        $order->refresh();

        $order->order_items->transform(function ($item) {
            $minOrder          = $item->product->minimum_order ?? 1;
            $item->package_price = (float) $item->price;
            $item->qty_sets    = $minOrder > 0
                ? (int) round($item->quantity / $minOrder)
                : (int) $item->quantity;
            $item->min_order   = $minOrder;
            $item->line_total  = $item->package_price * $item->qty_sets;
            return $item;
        });

        return response()->json([
            'success' => true,
            'message' => 'Order accepted successfully.',
            'order'   => $order,
        ]);
    }

    /**
     * Reject / cancel a new order from the notification panel
     * POST /admin/orders/{id}/reject
     */
    public function rejectOrder($id)
    {
        $order = Order::find($id);

        if (!$order) {
            return response()->json(['success' => false, 'message' => 'Order not found'], 404);
        }

        $order->update(['order_status' => 'CANCELLED']);

        return response()->json(['success' => true, 'message' => 'Order has been cancelled.']);
    }

    /**
     * Update order & payment status from the management table
     * PATCH /admin/orders/{id}/update-status
     */
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'order_status'   => 'required|in:PROCESSING,SHIPPED,DELIVERED,CANCELLED',
            'payment_status' => 'required|in:PENDING,PAID,FAILED,REFUNDED',
        ]);

        $order = Order::find($id);

        if (!$order) {
            return response()->json(['success' => false, 'message' => 'Order not found'], 404);
        }

        $order->update([
            'order_status'   => $request->order_status,
            'payment_status' => $request->payment_status,
        ]);

        return response()->json([
            'success'        => true,
            'order_status'   => $order->order_status,
            'payment_status' => $order->payment_status,
        ]);
    }

    /**
     * Update delivery zone / charge
     * POST /admin/orders/{id}/delivery
     */
    public function updateDelivery(Request $request, $id)
    {
        $request->validate([
            'zone' => 'required|in:dhaka_city,outside_dhaka_city,outside_dhaka_district,free',
        ]);

        $order = Order::find($id);
        if (!$order) {
            return response()->json(['success' => false, 'message' => 'Order not found'], 404);
        }

        $zoneCharges = [
            'dhaka_city'             => (int) config('delivery.dhaka_city', 75),
            'outside_dhaka_city'     => (int) config('delivery.outside_dhaka_city', 110),
            'outside_dhaka_district' => (int) config('delivery.outside_dhaka_district', 135),
            'free'                   => 0,
        ];

        $subTotal  = $order->total_amount - $order->shipping_amount;
        $newCharge = $zoneCharges[$request->zone];

        $order->update([
            'shipping_amount' => $newCharge,
            'total_amount'    => $subTotal + $newCharge,
        ]);

        activityLog('Order', 'UPDATE', 'Delivery zone set (' . $request->zone . ') — ৳' . $newCharge);

        return response()->json([
            'success'         => true,
            'shipping_amount' => $newCharge,
            'total_amount'    => $order->fresh()->total_amount,
        ]);
    }

    /**
     * Payment gateway callback
     * POST /admin/orders/{id}/payment-callback
     */
    public function paymentCallback(Request $request, $id)
    {
        $order = Order::find($id);

        if (!$order) {
            return response()->json(['success' => false, 'message' => 'Order not found'], 404);
        }

        $request->validate([
            'transaction_id' => 'required|string',
            'payment_status' => 'required|in:PENDING,PAID,FAILED,REFUNDED',
            'payment_method' => 'nullable|string',
        ]);

        $data = [
            'payment_status' => $request->payment_status,
            'transaction_id' => $request->transaction_id,
        ];

        if ($request->filled('payment_method')) {
            $data['payment_method'] = $request->payment_method;
        }

        if ($request->payment_status === 'PAID') {
            $data['order_status'] = 'PROCESSING';
        } elseif ($request->payment_status === 'FAILED') {
            $data['order_status'] = 'CANCELLED';
        }

        $order->update($data);
        $order->refresh();

        return response()->json([
            'success'        => true,
            'message'        => 'Payment status updated.',
            'payment_status' => $order->payment_status,
            'order_status'   => $order->order_status,
            'transaction_id' => $order->transaction_id,
        ]);
    }

    /**
     * Product search for the Add Order modal
     * GET /admin/orders/product-search?q=...
     */
    public function productSearch(Request $request)
    {
        $q = trim($request->input('q', ''));

        $products = Product::where('status', 'PUBLISHED')
            ->where(function ($query) use ($q) {
                $query->where('name', 'LIKE', '%' . $q . '%')
                      ->orWhere('sku', 'LIKE', '%' . $q . '%');
            })
            ->select('id', 'name', 'sku', 'package_price', 'minimum_order', 'stock_quantity')
            ->orderBy('name')
            ->limit(10)
            ->get();

        return response()->json(['success' => true, 'products' => $products]);
    }

    /**
     * Place a manual order on behalf of a customer
     * POST /admin/orders/store-manual
     */
    public function storeManual(Request $request)
    {
        $request->validate([
            'name'               => 'required|string|max:255',
            'phone'              => ['required', 'regex:/^(?:\+88|88)?(01[3-9]\d{8})$/'],
            'email'              => 'nullable|email|max:255',
            'address'            => 'nullable|string|max:500',
            'district'           => 'nullable|string|max:100',
            'thana'              => 'nullable|string|max:100',
            'items'              => 'required|array|min:1',
            'items.*.product_id' => 'required|integer|exists:tbl_products,id',
            'items.*.qty'        => 'required|integer|min:1',
            'payment_method'     => 'required|in:Cash,Cash on Delivery,Online,Bkash',
            'payment_status'     => 'required|in:PAID,PENDING',
            'order_status'       => 'required|in:PENDING,PROCESSING,SHIPPED,DELIVERED,CANCELLED',
            'delivery_zone'      => 'required|in:pickup,inside,outside',
            'notes'              => 'nullable|string|max:1000',
        ], [
            'phone.regex' => 'Enter a valid Bangladeshi mobile number, e.g. 01888888881.',
        ]);

        DB::beginTransaction();
        try {
            $phone     = preg_replace('/^(\+88|88)/', '', $request->phone);
            $nameParts = explode(' ', trim($request->name), 2);
            $fname     = $nameParts[0];
            $lname     = $nameParts[1] ?? '';

            $existingUser = User::where('mobile_no', $phone)->first();
            if ($existingUser) {
                $userId = $existingUser->id;
            } else {
                $newUser = User::create([
                    'first_name' => $fname,
                    'last_name'  => $lname,
                    'mobile_no'  => $phone,
                    'email'      => $request->email,
                    'role'       => 'customer',
                    'status'     => 'active',
                ]);
                $userId = $newUser->id;
            }

            // Server-side total computation
            $subtotal  = 0;
            $itemsData = [];
            foreach ($request->items as $item) {
                $product   = Product::findOrFail($item['product_id']);
                $qty       = (int) $item['qty'];
                $qtyUnits  = ($product->minimum_order ?? 1) * $qty;
                $lineTotal = $product->package_price * $qty;
                $subtotal += $lineTotal;
                $itemsData[] = compact('product', 'qty', 'qtyUnits', 'lineTotal');
            }

            $zone          = $request->delivery_zone;
            $freeThreshold = config('delivery.free_threshold');
            if ($zone === 'pickup') {
                $delivery = 0;
            } else {
                $delivery = $subtotal > $freeThreshold
                    ? 0
                    : ($zone === 'inside' ? config('delivery.inside_dhaka') : config('delivery.outside_dhaka'));
            }
            $total = $subtotal + $delivery;

            $order = Order::create([
                'user_id'         => $userId,
                'order_number'    => 'ORD-' . strtoupper(uniqid()),
                'total_amount'    => $total,
                'shipping_amount' => $delivery,
                'payment_method'  => $request->payment_method,
                'payment_status'  => $request->payment_status,
                'order_status'    => $request->order_status,
                'transaction_id'  => 'TRX-' . strtoupper(uniqid()),
                'notes'           => $request->notes,
                'accepted_by'     => session('user_id'),
                'source'          => 'pos',
            ]);

            OrderAddress::create([
                'order_id'      => $order->id,
                'type'          => 'BILLING',
                'first_name'    => $fname,
                'last_name'     => $lname,
                'email'         => $request->email,
                'phone'         => $request->phone,
                'address_line1' => $request->address,
                'district'      => $request->district,
                'thana'         => $request->thana,
            ]);

            foreach ($itemsData as $d) {
                OrderItems::create([
                    'order_id'   => $order->id,
                    'product_id' => $d['product']->id,
                    'quantity'   => $d['qtyUnits'],
                    'price'      => $d['product']->package_price,
                    'total'      => $d['lineTotal'],
                ]);
                Product::where('id', $d['product']->id)->decrement('stock_quantity', $d['qtyUnits']);
            }

            DB::commit();

            activityLog('Order Management', 'MANUAL ORDER', $order->order_number, 'Manual order placed by admin');

            return response()->json([
                'success'      => true,
                'message'      => 'Order placed successfully!',
                'order_number' => $order->order_number,
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }
}
