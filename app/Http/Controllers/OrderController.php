<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;

class OrderController extends Controller
{


    /**
     * Order_Success
     *
     * @param  mixed $request
     * @return void
     */
    public function Order_Success(Request $request, $id)
    {
        // If ID is wrong, it immediately stops and shows a 404 page
        $order = Order::where([
            'order_number' => $id
        ])->first();

        return view('order.Order_Success', [
            'order' => $order
        ]);
    }
}
