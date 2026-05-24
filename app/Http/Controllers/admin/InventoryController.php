<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;

class InventoryController extends Controller
{
    public function inventoryList(Request $request)
    {
        $search = $request->search;

        $products = Product::with('category')
            ->when($search, function ($query) use ($search) {

                $query->where('id', $search)
                    ->orWhere('name', 'LIKE', "%{$search}%")
                    ->orWhereHas('category', function ($q) use ($search) {
                        $q->where('name', 'LIKE', "%{$search}%");
                    });
            })
            ->latest()
            ->paginate(10);

        // Dashboard Statistics
        $totalProducts = Product::count();

        $inStockProducts = Product::where('stock_quantity', '>=', 100)
            ->count();

        $lowStockProducts = Product::whereBetween('stock_quantity', [1, 99])
            ->count();

        $outOfStockProducts = Product::where('stock_quantity', 0)
            ->count();

        return view(
            'admin.inventory.inventory-list',
            compact(
                'products',
                'totalProducts',
                'inStockProducts',
                'lowStockProducts',
                'outOfStockProducts'
            )
        );
    }



    public function inventoryUpdate(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:tbl_products,id',
            'stock_quantity' => 'required|numeric|min:0',
            'purchase_price' => 'required|numeric|min:0',
            'regular_price' => 'required|numeric|min:0',
        ]);

        $product = Product::findOrFail($request->product_id);

        /*
        |--------------------------------------------------------------------------
        | STOCK UPDATE LOGIC
        |--------------------------------------------------------------------------
        | Existing stock এর সাথে নতুন quantity ADD হবে
        | Example:
        | Existing = 50
        | New Input = 20
        | Result = 70
        |--------------------------------------------------------------------------
        */

        $product->stock_quantity =
            (int) $product->stock_quantity +
            (int) $request->stock_quantity;

        /*
        |--------------------------------------------------------------------------
        | PRICE UPDATE
        |--------------------------------------------------------------------------
        */

        $product->purchase_price = $request->purchase_price;

        /*
        |--------------------------------------------------------------------------
        | SELLING PRICE
        |--------------------------------------------------------------------------
        | IMPORTANT:
        | regular_price কে Selling Price হিসেবে use করা হচ্ছে
        |--------------------------------------------------------------------------
        */

        $product->regular_price = $request->regular_price;

        /*
        |--------------------------------------------------------------------------
        | UPDATED TIME
        |--------------------------------------------------------------------------
        | Laravel automatically updates updated_at
        |--------------------------------------------------------------------------
        */

        $product->save();

        return redirect()
            ->route('inventory.list')
            ->with('success', 'Inventory updated successfully.');
    }
            
    public function accountsTracking()
    {
        $products = Product::latest()->get();

        return view('admin.inventory.accounts-tracking', compact('products'));
    }
    public function inventoryAccounts()
    {
        $products = \App\Models\Product::latest()->get();

        return view(
            'admin.inventory.accounts-tracking',
            compact('products')
        );
    }
}

