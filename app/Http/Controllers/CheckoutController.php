<?php

namespace App\Http\Controllers;

use App\Models\Login;
use App\Models\Order;
use App\Models\OrderAddress;
use App\Models\OrderItems;
use App\Models\Product;
use App\Models\User;
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


        // foreach ($cart as $id => $details) {
        //     dd($details['quantity']);
        // }
        // Use a Transaction to ensure everything saves or nothing saves
        DB::beginTransaction();

        try {

            // 2. Create the user
            $user = new User();
            $user->first_name = $request->fname;
            $user->last_name = $request->lname;
            $user->mobile_no = $request->phone;
            // $user->password = uniqid();
            $user->save();

            // Create Login Info
            $login = new Login();
            $login->user_id = $user->id;
            $login->name = $request->fname . ' ' . $request->lname;
            $login->email = $request->email;
            $login->phone = $request->phone;
            $login->address = $request->billing_address;
            $login->password = 'USER - ' . uniqid();
            $login->save();

            // 2. Create the Order
            $order = new Order();
            $order->user_id = session('user_id') ?? $user->id; // Null if guest checkout
            $order->order_number = 'ORD-' . strtoupper(uniqid());
            $order->total_amount = $this->calculateTotal($cart);
            $order->payment_method = "CASH";
            $order->payment_status = "PENDING";
            $order->order_status = "PROCESSING";
            $order->transaction_id = 'TRX-' . strtoupper(uniqid());
            $order->notes = $request->order_notes;
            $order->save();

            // create billing address
            $orderAddress = new OrderAddress();
            $orderAddress->order_id = $order->id;
            $orderAddress->type = "BILLING";
            $orderAddress->first_name = $request->fname;
            $orderAddress->last_name = $request->lname;
            $orderAddress->email = $request->email;
            $orderAddress->phone = $request->phone;
            $orderAddress->address_line1 = $request->billing_address;
            $orderAddress->save();



            // 3. Save Order Items & Reduce Stock
            foreach ($cart as $id => $details) {

                $qty = $details['minimum_order'] * $details['quantity'];

                $lineTotal = $details['price'] * $qty;

                OrderItems::create([
                    'order_id'   => $order->id,
                    'product_id' => $id,
                    'quantity'   => $qty,
                    'price'      => $details['price'],
                    'total'      => $lineTotal,
                ]);

                // Reduce Product Stock in DB
                Product::where('id', $id)->decrement('stock_quantity', $details['minimum_order'] * $details['quantity']);
            }

            DB::commit();

            // 4. Clear the Cart
            Session::forget('cart');


            return response()->json([
                'status' => 'success',
                'order_number' => $order->order_number,
                'message' => 'Order placed successfully!'
            ]);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
        }
    }
}
