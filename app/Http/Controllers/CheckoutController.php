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
    public function Product_Checkout(Request $request)
    {
        $cart = session()->get('cart', []);

        if (!isset($cart) || count($cart) < 1) {
            return redirect()->route('home.index');
        }

        $subtotal = collect($cart)->sum(function ($item) {
            return $item['price'] * $item['quantity'];
        });

        return view('checkout.Checkout', [
            'cart_info' => session()->get('cart'),
            'subTotal'  => $subtotal,
        ]);
    }

    public function Product_Checkout_Create(Request $request)
    {
        $request->validate([
            'fname'           => 'required|string|max:255',
            'lname'           => 'required|string|max:255',
            'billing_address' => 'required',
            'phone'           => [
                'required',
                'regex:/^(?:\+88|88)?(01[3-9]\d{8})$/'
            ],
            'email' => 'required|email',
        ]);

        $cart = Session::get('cart');

        if (!$cart || count($cart) === 0) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Cart is empty'
            ], 400);
        }

        DB::beginTransaction();

        try {
            // ── STEP 1: User resolve ── //


            if (session('user_id')) {
                $userId = session('user_id');
            } else {
                $phone = preg_replace('/^(\+88|88)/', '', $request->phone);
                $existingUser = User::where('mobile_no', $phone)->first();

                if ($existingUser) {
                    $userId = $existingUser->id;
                } else {
                    
                    $user = User::create([
                        'first_name' => $request->fname,
                        'last_name'  => $request->lname,
                        'mobile_no'  => $phone,
                        'role'       => 'customer',
                        'status'     => 'active',
                    ]);

                    $userId = $user->id;
                }
            }

            // ── STEP 2: Total calculate ──

            $totalAmount = collect($cart)->sum(function ($item) {
                return ($item['price'] ?? 0) * ($item['quantity'] ?? 1);
            });

            // ── STEP 3: Order save ──
            $order = Order::create([
                'user_id'        => $userId,
                'order_number'   => 'ORD-' . strtoupper(uniqid()),
                'total_amount'   => $totalAmount,
                'payment_method' => 'CASH',
                'payment_status' => 'PENDING',
                'order_status'   => 'PROCESSING',
                'transaction_id' => 'TRX-' . strtoupper(uniqid()),
                'notes'          => $request->order_notes,
            ]);

            // ── STEP 4: Billing address save ──
            OrderAddress::create([
                'order_id'      => $order->id,
                'type'          => 'BILLING',
                'first_name'    => $request->fname,
                'last_name'     => $request->lname,
                'email'         => $request->email,
                'phone'         => $request->phone,
                'address_line1' => $request->billing_address,
            ]);

            // ── STEP 5: Order items save + stock  ──
            foreach ($cart as $productId => $details) {
                $qty       = ($details['minimum_order'] ?? 1) * ($details['quantity'] ?? 1);
                $lineTotal = ($details['price'] ?? 0) * ($details['quantity'] ?? 1);

                OrderItems::create([
                    'order_id'   => $order->id,
                    'product_id' => $productId,
                    'quantity'   => $qty,
                    'price'      => $details['price'] ?? 0,
                    'total'      => $lineTotal,
                ]);

                Product::where('id', $productId)
                    ->decrement('stock_quantity', $qty);
            }

            DB::commit();
            Session::forget('cart');

            return response()->json([
                'status'       => 'success',
                'order_number' => $order->order_number,
                'message'      => 'Order placed successfully!',
            ]);

        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'status'  => 'error',
                'message' => $e->getMessage(),
            ], 500);
        }
    }
}