<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminOrderController extends Controller
{
    /**
     * Order List For Order Page
     */
    public function order_index()
    {
        $order_list = Order::query()
            ->with(['order_items', 'order_items.product', 'order_address'])
            ->get()
            ->toArray();

        return view(
            'admin.order_mgmt.index',
            ['orders' => $order_list]
        );
    }

    public function show($id)
    {
        $order = Order::with([
            'order_items',
            'order_items.product',
            'order_address'
        ])->find($id);

        if (!$order) {
            return response()->json([
                'success' => false,
                'message' => 'Order not found'
            ]);
        }


        $order->order_items->transform(function ($item) {
            $minOrder = $item->product->minimum_order ?? 1;

            $item->package_price = (float) $item->price;


            $item->qty_sets = $minOrder > 0
                ? (int) round($item->quantity / $minOrder)
                : (int) $item->quantity;


            $item->min_order = $minOrder;


            $item->line_total = $item->package_price * $item->qty_sets;

            return $item;
        });

        return response()->json([
            'success' => true,
            'order'   => $order
        ]);
    }
}
