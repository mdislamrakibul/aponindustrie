<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

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
        $order = Order::with(['order_items', 'order_items.product', 'order_address'])->find($id);

        if (!$order) {
            return response()->json(['success' => false, 'message' => 'Order not found'], 404);
        }

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

        $order->update(['order_status' => 'PROCESSING']);
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
}
