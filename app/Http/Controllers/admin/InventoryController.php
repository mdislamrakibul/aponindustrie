<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

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

        $totalProducts = DB::table('tbl_products')->count();

        /*
        |--------------------------------------------------------------------------
        | QUANTITY BASED COUNTS
        |--------------------------------------------------------------------------
        */

        $totalStockQuantity = DB::table('tbl_products')
            ->sum('stock_quantity');

        $inStockQuantity = DB::table('tbl_products')
            ->where('stock_quantity', '>=', 100)
            ->sum('stock_quantity');

        $lowStockQuantity = DB::table('tbl_products')
            ->whereBetween('stock_quantity', [1, 99])
            ->sum('stock_quantity');

        $outOfStockQuantity = DB::table('tbl_products')
            ->where('stock_quantity', 0)
            ->sum('stock_quantity');

        return view(
            'admin.inventory.inventory-list',
            compact(
                'products',
                'totalProducts',
                'inStockProducts',
                'lowStockProducts',
                'outOfStockProducts',

                'totalStockQuantity',
                'inStockQuantity',
                'lowStockQuantity',
                'outOfStockQuantity'
            )
        );
    }
    public function dashboard()
    {
                /*
        |--------------------------------------------------------------------------
        | USER SUMMARY
        |--------------------------------------------------------------------------
        */

        $totalUsers = DB::table('tbl_info_user')->count();

        $totalAdmins = DB::table('tbl_info_user')
            ->where('role', 'admin')
            ->count();

        $totalVendors = DB::table('tbl_info_user')
            ->where('role', 'vendor')
            ->count();

        $totalCustomers = DB::table('tbl_info_user')
            ->where('role', 'customer')
            ->count();


        // TOTAL PRODUCTS
        $totalProducts = DB::table('tbl_products')->count();

        // PRODUCT STATUS COUNTS
        $inStockProducts = DB::table('tbl_products')
            ->where('stock_quantity', '>=', 100)
            ->count();

        $lowStockProducts = DB::table('tbl_products')
            ->whereBetween('stock_quantity', [1, 99])
            ->count();

        $outOfStockProducts = DB::table('tbl_products')
            ->where('stock_quantity', 0)
            ->count();

        // QUANTITY SUMMARY
        $totalStockQuantity = DB::table('tbl_products')
            ->sum('stock_quantity');

        $inStockQuantity = DB::table('tbl_products')
            ->where('stock_quantity', '>=', 100)
            ->sum('stock_quantity');

        $lowStockQuantity = DB::table('tbl_products')
            ->whereBetween('stock_quantity', [1, 99])
            ->sum('stock_quantity');

        return view(
            'admin.dashboard',
            
            compact(

                // USER
                'totalUsers',
                'totalAdmins',
                'totalVendors',
                'totalCustomers',

                // PRODUCT
                'totalProducts',
                'inStockProducts',
                'lowStockProducts',
                'outOfStockProducts',

                // QUANTITY
                'totalStockQuantity',
                'inStockQuantity',
                'lowStockQuantity'
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

