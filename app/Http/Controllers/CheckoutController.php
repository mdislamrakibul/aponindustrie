<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItems;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class CheckoutController extends Controller
{

    /**
     * calculateTotal
     *
     * @param  mixed $cart
     * @return void
     */
    private function calculateTotal($cart)
    {
        $total = 0;
        foreach ($cart as $item) {
            $total += $item['product']['sale_price'] * $item['quantity'];
        }
        return $total;
    }

    /**
     * Product_Cart
     *
     * @param  mixed $request
     * @return void
     */
    public function Product_Checkout(Request $request)
    {

        $cart = session()->get('cart', []);

        if (!isset($cart) || (isset($cart) && count($cart) < 0)) {
            return redirect()->route('home.index');
        }

        $subtotal = collect($cart)->sum(function ($item) {
            return $item['price'] * $item['quantity'];
        });


        // dd([
        //     'cart_info' => session()->get('cart'),
        //     'subTotal' => $subtotal,
        //     'newProducts' => $newProducts,

        // ]);


        return view('checkout.Checkout', [
            'cart_info' => session()->get('cart'),
            'subTotal' => $subtotal,
        ]);
    }


    /**
     * Product_Checkout_Create
     *
     * @return void
     */
    public function Product_Checkout_Create(Request $request)
    {
        $request->validate([
            'fname' => 'required|string|max:255',
            'lname' => 'required|string|max:255',
            'billing_address' => 'required',
            'phone' => [
                'required',
                'regex:/^(?:\+88|88)?(01[3-9]\d{8})$/'
            ],
            'email' => 'required|email',
        ]);


        $cart = Session::get('cart');
        if (!$cart) {
            return response()->json(['status' => 'error', 'message' => 'Cart is empty'], 400);
        }

        // Use a Transaction to ensure everything saves or nothing saves
        DB::beginTransaction();

        try {
            // 2. Create the Order
            $order = new Order();
            $order->user_id = auth()->id() ?? null; // Null if guest checkout
            $order->order_number = 'ORD-' . strtoupper(uniqid());
            $order->total_amount = $this->calculateTotal($cart);
            $order->fname = $request->fname;
            $order->lname = $request->lname;
            $order->email = $request->email;
            $order->phone = $request->phone;
            $order->address = $request->billing_address;
            $order->notes = $request->order_notes;
            $order->save();

            // 3. Save Order Items & Reduce Stock
            foreach ($cart as $id => $details) {
                OrderItems::create([
                    'order_id'   => $order->id,
                    'product_id' => $id,
                    'quantity'   => $details['quantity'],
                    'price'      => $details['product']['sale_price'],
                ]);

                // Reduce Product Stock in DB
                Product::where('id', $id)->decrement('stock', $details['quantity']);
            }

            DB::commit();

            // 4. Clear the Cart
            Session::forget('cart');


            return response()->json([
                'status' => 'success',
                'order_id' => $order->id,
                'message' => 'Order placed successfully!'
            ]);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
        }
    }
}
