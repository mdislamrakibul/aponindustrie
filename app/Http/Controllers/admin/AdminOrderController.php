<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminOrderController extends Controller
{
    /**
     * Order List For Order Page
     *
     * @return void
     */
    public function order_index()
    {

        $order_list = Order::query()
            ->with(['order_items', 'order_items.product', 'order_address'])
            ->get()
            ->toArray();


        return view(
            'admin.order_mgmt.index',
            ['orders' =>  $order_list]
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
        
        return response()->json([
            'success' => true,
            'order' => $order
        ]);
    }
}
