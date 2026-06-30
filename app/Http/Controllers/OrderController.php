<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function Order_Success(Request $request, $id)
    {
        $order = Order::with([
            'order_items.product',
            'order_address'
        ])->where('order_number', $id)->firstOrFail();

        // If a logged-in user is viewing, ensure they own this order
        if (session('user_id') && $order->user_id && $order->user_id !== (int) session('user_id')) {
            abort(403, 'Access denied.');
        }

        return view('order.Order_Success', compact('order'));
    }
}