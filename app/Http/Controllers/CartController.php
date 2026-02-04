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
            'discount_type',
            'discount_value',
            'product_type',
            'is_discounted',
        ])
            ->with(['category:id,name,slug', 'media:id,title,file_path,image_type,position,model_id,image_name'])
            ->productType("NEW")
            ->inStock()
            ->inRandomOrder()
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


        $product = Product::findOrFail($request->product_id);

        // 1. Retrieve the current cart from session, or an empty array if it doesn't exist
        $cart = session()->get('cart', []);

        // 2. If product is already in cart, increment quantity
        if (isset($cart[$request->product_id])) {
            $cart[$request->product_id]['quantity']++;
        } else {
            // 3. If not, add the product details to the array
            $cart[$request->product_id] = [
                'product' => $product,
                "name" => $product->name,
                "quantity" => 1,
                "price" => $product->sale_price,
            ];
        }

        // 4. Save the updated array back to the session
        session()->put('cart', $cart);

        return redirect()->route('Product_Cart');
    }

    /**
     * Product_Cart_Remove
     *
     * @param  mixed $request
     * @return void
     */
    public function Product_Cart_Remove(Request $request)
    {


        session()->flush();

        // dd(session()->get('cart'));

        return response()->json([
            'status' => 'success',
            'message' => 'Cart cleared successfully',
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
            'status' => 'success',
            'message' => 'Item Removed successfully',
            'cartCount' => 0
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
        // 1. Find the product in the database
        $product = Product::find($id);

        if (!$product) {
            return response()->json(['status' => 'error', 'message' => 'Product not found.'], 404);
        }

        // 2. Check if requested quantity exceeds database stock
        if ($quantity > $product->stock_quantity) {
            return response()->json([
                'status' => 'error',
                'message' => 'Only ' . $product->stock . ' units left in stock.'
            ], 400); // 400 Bad Request
        }

        // 3. If check passes, update the session cart
        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            $cart[$id]['quantity'] = (int) $quantity;
            session()->put('cart', $cart);

            return response()->json([
                'status' => 'success',
                'message' => 'Cart updated successfully!'
            ]);
        }

        return response()->json(['status' => 'error', 'message' => 'Item not found in cart.'], 404);
    }
}
