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

        return view('order.Order_Success', compact('order'));
    }
}