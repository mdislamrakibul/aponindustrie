<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

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
}
