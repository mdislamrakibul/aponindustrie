<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{

    /**
     * Product_Cart
     *
     * @param  mixed $request
     * @return void
     */
    public function Product_Cart(Request $request)
    {

        // 1. Retrieve the current cart from session, or an empty array if it doesn't exist
        $cart = session()->get('cart', []);


        $subtotal = collect($cart)->sum(function ($item) {
            return $item['price'] * $item['quantity'];
        });


        $newProducts = Product::published([
            'id',
            'name',
            'category_id',
            'sale_price',
            'regular_price',
            'package_price',
            'discount_type',
            'discount_value',
            'product_type',
            'is_discounted',
        ])
            ->with(['category:id,name,slug', 'media:id,title,file_path,image_type,position,model_id,image_name'])
            ->latest()
            ->take(7)
            ->get()
            ->toArray();


        // dd([
        //     'cart_info' => session()->get('cart'),
        //     'subTotal' => $subtotal,
        //     'newProducts' => $newProducts,

        // ]);


        return view('cart.Cart', [
            'cart_info' => session()->get('cart'),
            'subTotal' => $subtotal,
            'newProducts' => $newProducts,

        ]);
    }


    /**
     * Product_Cart_ADD
     *
     * @param  mixed $request
     * @return void
     */
    public function Product_Cart_ADD(Request $request)
    {


        $product = Product::with(['media' => function ($q) {
            $q->where('image_type', 'PRODUCT')->orderBy('position')->limit(1)->select('id','title','file_path','image_type','position','model_id','image_name');
        }])->findOrFail($request->product_id);

        // 1. Retrieve the current cart from session, or an empty array if it doesn't exist
        $cart = session()->get('cart', []);

        // 2. If product is already in cart, increment quantity (capped at available stock)
        if (isset($cart[$request->product_id])) {
            if ($cart[$request->product_id]['quantity'] < $product->stock_quantity) {
                $cart[$request->product_id]['quantity']++;
            }
        } else {
            // 3. If not, add the product details to the array
            $cart[$request->product_id] = [
                'product' => $product->toArray(),
                "name" => $product->name,
                "quantity" => 1,
                "minimum_order" => $product->minimum_order,
                "price" => $product->package_price,
            ];
        }

        // 4. Save the updated array back to the session
        session()->put('cart', $cart);

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'status'     => 'success',
                'message'    => 'Product added to cart!',
                'product_id' => (int) $request->product_id,
                'quantity'   => $cart[$request->product_id]['quantity'],
                'cartCount'  => count($cart),
                'subtotal'   => (float) collect($cart)->sum(fn ($item) => $item['price'] * $item['quantity']),
            ]);
        }

        return back()->with('success', 'Product added to cart!');
    }

    /**
     * Product_Cart_Remove
     *
     * @param  mixed $request
     * @return void
     */
    public function Product_Cart_Remove(Request $request)
    {
        session()->forget('cart'); 
        return response()->json([
            'status'    => 'success',
            'message'   => 'Cart cleared successfully',
            'cartCount' => 0
        ]);
    }



    /**
     * Product_Cart_Remove_Single
     *
     * @param  mixed $request
     * @return void
     */
    public function Product_Cart_Remove_Single(Request $request, $id)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            // Option A: Use PHP unset to remove the key from the local array
            unset($cart[$id]);

            // Save the modified array back to the session
            session()->put('cart', $cart);
        }


        return response()->json([
            'status'     => 'success',
            'message'    => 'Item Removed successfully',
            'product_id' => (int) $id,
            'cartCount'  => count($cart),
            'subtotal'   => (float) collect($cart)->sum(fn ($item) => $item['price'] * $item['quantity']),
        ]);
    }


    /**
     * Product_Cart_update_Single
     *
     * @param  mixed $request
     * @param  mixed $id
     * @return void
     */
    public function Product_Cart_update_Single($id, $quantity)
    {
        $quantity = (int) $quantity;

        // 1. Find the product in the database
        $product = Product::find($id);

        if (!$product) {
            return response()->json(['status' => 'error', 'message' => 'Product not found.'], 404);
        }

        $cart = session()->get('cart', []);

        if (!isset($cart[$id])) {
            return response()->json(['status' => 'error', 'message' => 'Item not found in cart.'], 404);
        }

        // Dropping below 1 removes the item, same as the single-remove endpoint
        if ($quantity < 1) {
            unset($cart[$id]);
            session()->put('cart', $cart);

            return response()->json([
                'status'     => 'success',
                'message'    => 'Item removed successfully',
                'removed'    => true,
                'product_id' => (int) $id,
                'cartCount'  => count($cart),
                'subtotal'   => (float) collect($cart)->sum(fn ($item) => $item['price'] * $item['quantity']),
            ]);
        }

        // 2. Check if requested quantity exceeds database stock
        if ($quantity > $product->stock_quantity) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Only ' . $product->stock_quantity . ' units left in stock.'
            ], 400); // 400 Bad Request
        }

        // 3. If check passes, update the session cart
        $cart[$id]['quantity'] = $quantity;
        session()->put('cart', $cart);

        return response()->json([
            'status'     => 'success',
            'message'    => 'Cart updated successfully!',
            'product_id' => (int) $id,
            'quantity'   => $quantity,
            'cartCount'  => count($cart),
            'subtotal'   => (float) collect($cart)->sum(fn ($item) => $item['price'] * $item['quantity']),
        ]);
    }
}
